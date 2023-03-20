<?php

namespace Url;

use Stringable;

class Origin implements Stringable {

    private string $value;

    function __construct(string $origin) {
        $origin = explode("?", $origin)[0];
        $this->value = trim($origin, "/");
    }

    public function __toString(): string {
        return $this->value;
    }
}
