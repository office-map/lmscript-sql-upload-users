<?php

namespace Lmscript\UploadUsers;

use LeaderMapConnection\Connection;
use LeaderMapRequests\Options\Location;
use LeaderMapRequests\Query\Meta\UserRequest;
use Lmscript\UploadUsers\config\LeaderMapConfig;

require_once __DIR__  . "/vendor/autoload.php";

$leaderMapConfig = new LeaderMapConfig();

$id = 10;

$connection = new Connection($leaderMapConfig);
$location = Location::fromObject($leaderMapConfig);
$request = new UserRequest($location, $id);
$result = $connection->send($request);
$user = $result["user"];
var_dump($user);
