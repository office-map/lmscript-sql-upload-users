<?php

namespace DeepArray\Path;

class EmptyPath extends Path {

    private static ?EmptyPath $instance = null;

    public static function instance(): EmptyPath {
        if (!self::$instance) self::$instance = new EmptyPath([]);
        return self::$instance;
    }
}
