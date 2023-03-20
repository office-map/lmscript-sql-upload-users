<?php

namespace DeepArray;

class MergedDeepArray extends DeepArray {

    function __construct(...$arrays) {
        $arrays = array_map(function ($array) {
            return new DeepArray($array);
        }, $arrays);
        $data = array_reduce($arrays, function (DeepArray $acc, DeepArray $array) {
            foreach ($this->paths($array->get()) as $path) {
                $acc->set($path, $array->get($path));
            }
            return $acc;
        }, new DeepArray());
        parent::__construct($data);
    }

    private function paths(array $array, array $path = []): array {
        $result = [];
        foreach ($array as $key => $value) {
            $valuePath = array_merge($path, [$key]);
            $nestedPaths = is_array($value) ? $this->paths($value, $valuePath) : [$valuePath];
            $result = array_merge($result, $nestedPaths);
        }
        return $result;
    }
}
