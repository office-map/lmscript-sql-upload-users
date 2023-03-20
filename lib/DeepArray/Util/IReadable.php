<?php

namespace DeepArray\Util;

use DeepArray\Path\Path;

interface IReadable {

    public function has(Path $path): bool;

    public function get(Path $path);
}
