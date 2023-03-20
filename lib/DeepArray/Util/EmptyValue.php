<?php

namespace DeepArray\Util;

use DeepArray\Exception\UndefinedPathException;
use DeepArray\Path\Path;

class EmptyValue implements IReadable {

    private static ?EmptyValue $instance = null;

    public function has(Path $path): bool {
        return false;
    }

    public function get(Path $path) {
        throw new UndefinedPathException($path);
    }

    public static function instance(): EmptyValue {
        if (!self::$instance) self::$instance = new EmptyValue();
        return self::$instance;
    }
}
