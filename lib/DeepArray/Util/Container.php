<?php

namespace DeepArray\Util;

use DeepArray\Exception\UndefinedPathException;
use DeepArray\Path\EmptyPath;
use DeepArray\Path\Path;

class Container implements IReadable {

    /** @var IReadable[] */
    private array $data;

    function __construct(array $data = []) {
        $this->data = $data;
    }

    public function has(Path $path): bool {
        if ($path->empty()) return true;
        return $this->readableValue($path->head())->has($path->tail());
    }

    public function get(Path $path) {
        if ($path->empty()) return $this->array();
        try {
            return $this->readableValue($path->head())->get($path->tail());
        } catch (UndefinedPathException $e) {
            throw new UndefinedPathException($path, $e);
        }
    }

    public function set(Path $path, IReadable $value) {
        if ($path->empty()) return $this->data[] = $value;
        if ($path->tail()->empty()) return $this->data[$path->head()] = $value;
        $this->writableValue($path->head())->set($path->tail(), $value);
    }

    public function delete(Path $path) {
        $this->get($path);
        if ($path->empty()) $this->data = [];
        else if ($path->tail()->empty()) unset($this->data[$path->head()]);
        else $this->writableValue($path->head())->delete($path->tail());
    }

    private function array(): array {
        return array_map(function (IReadable $value) {
            return $value->get(EmptyPath::instance());
        }, $this->data);
    }

    private function readableValue($key): IReadable {
        if (array_key_exists($key, $this->data)) return $this->data[$key];
        return EmptyValue::instance();
    }

    private function writableValue($key): Container {
        $value = array_key_exists($key, $this->data) ? $this->data[$key] : new Container();
        $value = ($value instanceof Container) ? $value : new Container();
        $this->data[$key] = $value;
        return $value;
    }
}
