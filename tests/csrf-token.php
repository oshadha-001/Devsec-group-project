<?php
require __DIR__.'/../src/classes/GroupCsrf.php';
$_SESSION=[];
if (GroupCsrf::valid('')) { throw new Exception('Uninitialized token accepted.'); }
$one=GroupCsrf::token();
if (!GroupCsrf::valid($one) || GroupCsrf::token() !== $one) { throw new Exception('Valid token rejected.'); }
foreach ([null,'',[],str_repeat('0',64),substr($one,1)] as $bad) {
    if (GroupCsrf::valid($bad)) { throw new Exception('Invalid token accepted.'); }
}
$_SESSION=[]; $two=GroupCsrf::token();
if ($one===$two || GroupCsrf::valid($one)) { throw new Exception('Cross-session token accepted.'); }
echo "PASS: generated token, valid submission, invalid shapes and cross-session denial.\n";
