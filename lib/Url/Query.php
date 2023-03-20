<?php

namespace Url;

use Stringable;
use TypeError;

class Query implements Stringable {
    private array $data;

    function __construct(...$args) {
        $data = [];
        foreach ($args as $arg) {
            $value = [];
            if ($arg instanceof Query) $value = $arg->array();
            else if (is_array($arg)) $value = $arg;
            elseif (is_string($arg)) $value = $this->fromString($arg);
            else throw new TypeError("Argument cannot be Query");
            $data = array_merge($data, $value);
        }
        $this->data = $data;
    }

    public function array(): array {
        return $this->data;
    }

    public function __toString(): string {
        $result = $this->implodeQuery($this->data);
        if ($result) return "?" . $result;
        return "";
    }

    private function fromString(string $string): array {
        $string = explode("#", $string)[0];
        if (strpos($string, "?") === false) return [];
        $exploded = explode("?", $string);
        $string = end($exploded);
        $result = [];
        foreach (explode("&", $string) as $pair) {
            $entry = explode("=", $pair);
            if (!$entry[0]) continue;
            if (count($entry) < 2) $entry[] = "";
            $result[$entry[0]] = $entry[1];
        }
        return $result;
    }

    private function implodeQuery(array $query): string {
        $result = [];
        foreach ($query as $key => $value) {
            $result[] = $key . "=" . urlencode($value);
        }
        return implode("&", $result);
    }
}
