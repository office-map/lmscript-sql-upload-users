<?php

namespace LeaderMapConnection;

class Request {
    public string $path;
    public array $query = [];
    public array $body = [];

    function __construct(string $path, array $query = [], array $body = []) {
        $this->path = $path;
        $this->query = $query;
        $this->body = $body;
    }
}
