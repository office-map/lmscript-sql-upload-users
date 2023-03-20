<?php

namespace LeaderMapRequests\Command\Meta;

use LeaderMapConnection\Request;
use LeaderMapRequests\Options\Location;

class SaveUserRequest extends Request {

    function __construct(Location $location, array $data) {
        $query = $location->array();
        $body = ["data" => json_encode($data)];
        parent::__construct("/Meta/Users/API?action=put_user", $query, $body);
    }
}
