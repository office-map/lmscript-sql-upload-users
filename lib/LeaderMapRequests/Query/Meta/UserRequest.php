<?php

namespace LeaderMapRequests\Query\Meta;

use LeaderMapConnection\Request;
use LeaderMapRequests\Options\Location;

class UserRequest extends Request {

    function __construct(Location $location, int $user_id) {
        $query = array_merge($location->array(), ["id" => $user_id]);
        parent::__construct("/Meta/Users/API?action=get_user", $query);
    }
}
