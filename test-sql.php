<?php

namespace Lmscript\UploadUsers;

use Lmscript\UploadUsers\config\DBConfig;
use Lmscript\UploadUsers\Services\SQLSourceEntities;
use PDO;

require_once __DIR__  . "/vendor/autoload.php";

$dbConfig = new DBConfig();

$pdo = new PDO($dbConfig->dsn, $dbConfig->username, $dbConfig->password);
$stmt = $pdo->query($dbConfig->sql);
$sourceEntities = new SQLSourceEntities($stmt, \PDO::FETCH_ASSOC);

foreach ($sourceEntities as $entity) {
    var_dump($entity);
}
