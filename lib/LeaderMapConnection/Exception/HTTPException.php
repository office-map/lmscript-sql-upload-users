<?php

namespace LeaderMapConnection\Exception;

class HTTPException extends \Exception {

    protected string $url;
    protected array $body;
    protected string $result;

    function __construct(
        string $url,
        array $body,
        string $result
    ) {
        $this->url = $url;
        $this->body = $body;
        $this->result = $result;
        parent::__construct("LeaderMap Error. Reponse: " . var_export($result, true));
    }

    public function getURL(): string {
        return $this->url;
    }
    public function getBody(): array {
        return $this->body;
    }

    public function getResult(): string {
        return $this->result;
    }
}
