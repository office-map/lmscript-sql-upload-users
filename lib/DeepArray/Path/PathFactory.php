<?php

namespace DeepArray\Path;

class PathFactory {

    private string $separator;

    function __construct(string $separator = "") {
        $this->separator = $separator;
    }

    public function get($path): Path {
        return new Path($this->data($path));
    }

    private function data($path): array {
        if (!$path) return [];
        if ($path instanceof Path) return $path->array();
        if (is_array($path)) return $this->arrayData($path);
        if (is_int($path) || is_string($path)) return $this->primitiveData($path);
        throw new \TypeError("Incorrect path"); // @todo
    }

    private function primitiveData($value): array {
        if (is_int($value) || !$this->separator) return [$value];
        return explode($this->separator, $value);
    }

    private function arrayData(array $data): array {
        return array_reduce($data, function (array $acc, $value) {
            return array_merge($acc, $this->data($value));
        }, []);
    }
}
