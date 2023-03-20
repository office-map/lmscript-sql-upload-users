<?php

namespace LeaderMapRequests\Options;

class Location {
    public int $workspace_id;
    public int $project_id;

    public function array(): array {
        return [
            "workspace_id" => $this->workspace_id,
            "project_id" => $this->project_id
        ];
    }

    public static function fromObject($object): Location {
        $result = new Location();
        $result->workspace_id = $object->workspace_id;
        $result->project_id = $object->project_id;
        return $result;
    }

    public static function fromArray(array $array): Location {
        return self::fromObject(json_decode(json_encode($array)));
    }
}
