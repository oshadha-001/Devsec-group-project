"""Build a bounded inventory from observed source banners; do not infer versions."""
from pathlib import Path
import hashlib, json, re

root = Path(__file__).resolve().parents[1]
output = root / 'reports'
output.mkdir(exist_ok=True)
specs = [
    ('jquery', 'src/javascript/jQuery/jquery.js', r'Library v([\d.]+)', 'npm'),
    ('jquery', 'src/javascript/ddsmoothmenu/jquery.min.js', r'Library v([\d.]+)', 'npm'),
    ('Colorbox', 'src/javascript/jQuery/colorbox/jquery.colorbox.js', r'ColorBox v([\d.]+)', None),
    ('NuSOAP', 'src/webservices/soap/lib/nusoap.php', r"var \$version = '([\d.]+)'", None),
]
components = []
for name, rel, pattern, ecosystem in specs:
    content = (root / rel).read_bytes()
    match = re.search(pattern, content.decode('utf-8'))
    if not match:
        raise SystemExit('Review changed dependency version banner: ' + rel)
    version = match[1]
    item = {'type':'library', 'bom-ref':rel, 'name':name, 'version':version,
            'hashes':[{'alg':'SHA-256', 'content':hashlib.sha256(content).hexdigest()}],
            'properties':[{'name':'source-file','value':rel}]}
    if ecosystem:
        item['purl'] = f'pkg:{ecosystem}/{name}@{version}'
    components.append(item)
sbom = {'bomFormat':'CycloneDX', 'specVersion':'1.5', 'version':1, 'components':components}
(output/'vendor-sbom.json').write_text(json.dumps(sbom, indent=2)+'\n', encoding='utf-8')
coverage = {'identifiedComponents':len(components), 'verifiedPackageIdentities':2,
    'limitations':['Colorbox and NuSOAP versions are recorded without verified registry mapping.',
                  'JWT, Gritter and DHTML menu sources lack verified release identities.',
                  'This bounded inventory may omit other bundled third-party code.']}
(output/'vendor-coverage.json').write_text(json.dumps(coverage, indent=2)+'\n', encoding='utf-8')
print(json.dumps(coverage))
