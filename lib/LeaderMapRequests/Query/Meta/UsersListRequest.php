<?php

namespace LeaderMapRequests\Query\Meta;

use LeaderMapConnection\Request;
use LeaderMapRequests\Options\Location;

class UsersListRequest extends Request {

    function __construct(Location $location, array $query = []) {
        $query = array_merge($location->array(), $query);
        parent::__construct("/Meta/Users/API?action=list", $query);
    }
}
