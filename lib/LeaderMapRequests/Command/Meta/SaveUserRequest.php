<?php

namespace LeaderMapRequests\Command\Meta;

use LeaderMapConnection\Request;
use LeaderMapRequests\Options\Location;

class SaveUserRequest extends Request {

    function __construct(Location $location, array $data) {
        $query = $location->array();
        $body = $this->imgBody($data);
        if (array_key_exists("default_image_data", $data)) unset($data["default_image_data"]);
        $body["data"] = json_encode($data);
        parent::__construct("/Meta/Users/API?action=put_user", $query, $body);
    }

    private function imgBody(array $data): array {
        if (!array_key_exists("default_image_data", $data)) return [];
        return [
            "default_image_method" => "formdata",
            "default_image_data" => $data["default_image_data"]
        ];
    }
}
