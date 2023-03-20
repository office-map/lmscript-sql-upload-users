<?php

namespace LeaderMapConnection;

use LeaderMapConnection\Connection;
use LeaderMapConnection\Request;

class Collection implements \Iterator, \Countable {

    private Connection $connection;
    private Request $request;
    private int $pageSize;
    private int $position = 0;
    private int $total = -1;
    private int $cachedPage = -1;
    private array $cache = [];

    function __construct(Connection $connection, Request $request) {
        $this->connection = $connection;
        $request = new Request($request->path, $request->query, $request->body);
        $this->request = $request;
        $this->pageSize = array_key_exists("perpage", $request->query) ? $request->query["perpage"] : 100;
        $this->request->query["perpage"] = $this->pageSize;
    }

    public function count(): int {
        if ($this->total < 0) $this->load();
        return $this->total;
    }

    public function current(): mixed {
        if ($this->cachedPage != $this->page()) $this->load();
        return $this->cache[$this->position % $this->pageSize];
    }

    public function key(): mixed {
        return $this->position;
    }

    public function next(): void {
        ++$this->position;
    }

    public function rewind(): void {
        $this->position = 0;
        $this->total = -1;
        $this->cachedPage = -1;
        $this->cache = [];
    }

    public function valid(): bool {
        return $this->position < $this->count();
    }

    private function load() {
        $page = $this->page();
        $this->request->query["page"] = $page;
        $result = $this->connection->send($this->request);
        $this->total = $result["total"];
        $this->cache = $result["items"];
        $this->cachedPage = $page;
    }

    private function page() {
        return (int)($this->position / $this->pageSize);
    }
}
