<?php

namespace Url;

use Stringable;

class URL implements Stringable {

    private string $value;

    function __construct(string $origin, string $path = "", $query = []) {
        $query = new Query($origin, $path, $query);
        $origin = new Origin($origin);
        $path = new Path($path);
        $this->value =  $origin . $path . $query;
    }

    public function __toString(): string {
        return $this->value;
    }
}
