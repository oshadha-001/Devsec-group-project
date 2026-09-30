<?php
require __DIR__.'/../src/classes/GroupDns.php';
foreach (['127.0.0.1','::1'] as $ip) {
    if (GroupDns::resolve($ip) !== [$ip]) { throw new Exception('IP lookup failed.'); }
}
foreach (['127.0.0.1; printf GROUP-CMD-PROOF','localhost|whoami','$(whoami)',"localhost\nwhoami",'--help',[],str_repeat('a',254)] as $input) {
    try { GroupDns::resolve($input); throw new Exception('Unsafe input accepted.'); }
    catch (InvalidArgumentException $expected) {}
}
if (!in_array('127.0.0.1',GroupDns::resolve('localhost'),true)) { throw new Exception('Localhost resolution failed.'); }
echo "PASS: literal IPs, localhost and rejected command syntax.\n";
