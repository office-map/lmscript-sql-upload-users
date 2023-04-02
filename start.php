<?php

namespace Lmscript\UploadUsers;

use LeaderMapConnection\Connection;
use LeaderMapRequests\Options\Location;
use Lmscript\UploadUsers\config\DBConfig;
use Lmscript\UploadUsers\config\LeaderMapConfig;
use Lmscript\UploadUsers\config\SaveLeaderMapUserConfig;
use Lmscript\UploadUsers\Services\CombinedMapStrategy;
use Lmscript\UploadUsers\Services\ConfigMapStrategy;
use Lmscript\UploadUsers\Services\DeleteNullMapStrategy;
use Lmscript\UploadUsers\Services\SaveLeaderMapUserStrategy;
use Lmscript\UploadUsers\Services\SQLSourceEntities;
use Lmscript\UploadUsers\Services\TestSourceEntities;
use PDO;

require_once __DIR__  . "/vendor/autoload.php";

$mappingConfig = require_once(__DIR__ . "/config/mapping.php");
$dbConfig = new DBConfig();
$leaderMapConfig = new LeaderMapConfig();
$saveLeaderMapConfig = new SaveLeaderMapUserConfig();

// $sourceEntities = new TestSourceEntities();
// $db = new PDO($dbConfig->dsn, $dbConfig->username, $dbConfig->password);
$db = new PDO($dbConfig->dsn, $dbConfig->username, $dbConfig->password, [
    PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $db->query($dbConfig->sql);
$sourceEntities = new SQLSourceEntities($stmt, \PDO::FETCH_ASSOC);

$mapStrategy = new CombinedMapStrategy(
    new DeleteNullMapStrategy(),
    new ConfigMapStrategy($mappingConfig)
);

$saveStrategy = new SaveLeaderMapUserStrategy(
    new Connection($leaderMapConfig),
    Location::fromObject($leaderMapConfig),
    $saveLeaderMapConfig->insert,
    $saveLeaderMapConfig->update,
    $saveLeaderMapConfig->defaultNewUser
);

$app = new App($sourceEntities, $mapStrategy, $saveStrategy);
$app->run();
