<?php

namespace SQLIterator;

use Iterator;

class SQLIterator implements Iterator {

    private \PDOStatement $pdoStatement;
    private int $fetchMode;
    private int $key = 0;
    private bool $valid = true;
    private $result;

    function __construct(\PDOStatement $PDOStatement, int $fetchMode = \PDO::FETCH_BOTH) {
        $this->pdoStatement = $PDOStatement;
        $this->fetchMode = $fetchMode;
    }

    public function current(): mixed {
        return $this->result;
    }

    public function next(): void {
        $this->key++;
        $this->load();
    }

    public function key(): mixed {
        return $this->key;
    }

    public function valid(): bool {
        return $this->valid;
    }

    public function rewind(): void {
        $this->valid = true;
        $this->key = 0;
        $this->load();
    }

    private function load() {
        $this->result = $this->pdoStatement->fetch(
            $this->fetchMode,
            \PDO::FETCH_ORI_ABS,
            $this->key
        );
        if ($this->result === false) $this->valid = false;
    }
}
