<?php
chdir('/var/www/html');
require 'includes/database-config.inc';
$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
$tables = $db->query("SHOW TABLES LIKE 'accounts'");
if ($tables->num_rows > 0) { echo "Existing lab data retained.\n"; exit(0); }
$db->close();
ob_start();
require 'set-up-database.php';
ob_end_clean();
if ($lErrorDetected) { fwrite(STDERR, "Lab initialization failed.\n"); exit(1); }
echo "Synthetic lab initialized. Credentials are in ignored local secret files.\n";
