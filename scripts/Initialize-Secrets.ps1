$ErrorActionPreference = 'Stop'
$projectRoot = Split-Path $PSScriptRoot -Parent
$secretDir = Join-Path $projectRoot '.secrets'
New-Item -ItemType Directory -Path $secretDir -Force | Out-Null
foreach ($secretName in @('db_password','root_password','admin_password','user_password','jwt_key')) {
    $secretPath = Join-Path $secretDir ($secretName + '.txt')
    if (-not (Test-Path -LiteralPath $secretPath)) {
        $bytes = New-Object byte[] 32
        $rng = [System.Security.Cryptography.RandomNumberGenerator]::Create()
        $rng.GetBytes($bytes)
        $rng.Dispose()
        $secretValue = -join ($bytes | ForEach-Object { $_.ToString('x2') })
        if ($secretName -eq 'db_password' -and $env:CI_DB_PASSWORD) {
            if ($env:CI_DB_PASSWORD -notmatch '^[a-f0-9]{64}$') { throw 'CI_DB_PASSWORD must be 64 lowercase hexadecimal characters.' }
            $secretValue = $env:CI_DB_PASSWORD
        }
        [IO.File]::WriteAllText($secretPath, $secretValue, [Text.UTF8Encoding]::new($false))
    }
}
Write-Output 'Local secret files are ready. Values were not printed.'
