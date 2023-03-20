<?php

namespace DeepArray;

use DeepArray\Util\Container;
use DeepArray\Util\IReadable;
use DeepArray\Path\Path;
use DeepArray\Path\PathFactory;
use DeepArray\Util\Value;

class DeepArray {

    private Container $container;
    private PathFactory $pathFactory;

    function __construct($data = []) {
        if ($data instanceof DeepArray) $data = $data->get();
        $this->container = $this->arrayValue($data);
        $this->pathFactory = new PathFactory();
    }

    public function has($path): bool {
        $path = $this->pathFactory->get($path);
        return $this->container->has($path);
    }

    public function get($path = []) {
        $path = $this->pathFactory->get($path);
        return $this->container->get($path);
    }

    public function set($path, $value) {
        $path = $this->pathFactory->get($path);
        $value = $this->value($value);
        $this->container->set($path, $value);
    }

    public function delete($path) {
        $path = $this->pathFactory->get($path);
        $this->container->delete($path);
    }

    private function value($value): IReadable {
        return is_array($value) ? $this->arrayValue($value) : new Value($value);
    }

    private function arrayValue(array $data): Container {
        return new Container(array_map(function ($value) {
            return $this->value($value);
        }, $data));
    }
}
