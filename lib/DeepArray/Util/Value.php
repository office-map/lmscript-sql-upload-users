<?php

namespace DeepArray\Util;

use DeepArray\Exception\UndefinedPathException;
use DeepArray\Path\Path;

class Value implements IReadable {

    private $value;

    function __construct($value) {
        $this->value = $value;
    }

    public function has(Path $path): bool {
        return $path->empty();
    }

    public function get(Path $path) {
        if (!$this->has($path)) throw new UndefinedPathException($path);
        return $this->value;
    }
}
