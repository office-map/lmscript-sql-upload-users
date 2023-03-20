<?php

namespace DeepArray\Path;

use Stringable;

class Path implements Stringable {

    private array $data;

    function __construct(array $path) {
        $this->data = $path;
    }

    public function empty(): bool {
        return !count($this->data);
    }

    public function head() {
        if ($this->empty()) throw new \Exception("Empty path");
        return $this->data[0];
    }

    public function tail(): Path {
        return new Path(array_slice($this->data, 1), $this);
    }

    public function array(): array {
        return $this->data;
    }

    public function __toString(): string {
        $separator = ".";
        return join($separator, $this->data);
    }
}
