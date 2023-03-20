<?php

namespace Url;

use Stringable;

class Path implements Stringable {

    private string $value;

    function __construct(string $path) {
        $value = explode("?", $path)[0];
        $value = trim($value, "/");
        if ($value) $value = "/" . $value;
        $this->value = $value;
    }

    public function __toString(): string {
        return $this->value;
    }
}
