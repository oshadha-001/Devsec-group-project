<?php
require __DIR__ . '/../src/classes/SQLQueryHandler.php';
class QueryRecorder {
    public $calls = [];
    public function executePrepared($sql, $types, $values) {
        $this->calls[] = [$sql, $types, $values];
        return 'recorded';
    }
}
class LookupForTest extends SQLQueryHandler {
    public function __construct($db) { $this->mMySQLHandler = $db; }
}
$db = new QueryRecorder(); $lookup = new LookupForTest($db);
foreach ([['jeremy', 'ordinary-value'], ["' OR 1=1 -- ", ''], ['O\'Brien', 'quotes\'remain']] as $input) {
    if ($lookup->getUserAccount(...$input) !== 'recorded') { throw new Exception('Wrong result.'); }
    [$sql, $types, $values] = $db->calls[count($db->calls)-1];
    if ($sql !== 'SELECT * FROM accounts WHERE username = ? AND password = ?' || $types !== 'ss' || $values !== $input) {
        throw new Exception('Query and input were not separated.');
    }
}
foreach ([[[], ''], ['jeremy', []], [str_repeat('x',256),'']] as $input) {
    try { $lookup->getUserAccount(...$input); throw new Exception('Invalid input accepted.'); }
    catch (InvalidArgumentException $expected) {}
}
echo "PASS: parameter binding contract and input shape checks (no live database).\n";
