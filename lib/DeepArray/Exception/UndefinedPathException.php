<?php

namespace DeepArray\Exception;

use DeepArray\Path\Path;

class UndefinedPathException extends \OutOfBoundsException {

    function __construct(Path $path, ?\Throwable $previous = null) {
        parent::__construct("Undefined path: $path", 0, $previous);
    }
}
