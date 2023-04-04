<?php

namespace Lmscript\UploadUsers\Services;

use CURLStringFile;
use Lmscript\UploadUsers\Domain\Gateway\IMapStrategy;

class HexImgToCURLFile implements IMapStrategy {

    private string $imgKey;

    function __construct(string $imgKey = "default_image_data") {
        $this->imgKey = $imgKey;
    }

    public function map(array $entity): array {
        if (!array_key_exists($this->imgKey, $entity)) return $entity;
        $hex = $entity[$this->imgKey];
        $hex = substr($hex, 2);
        $bin = hex2bin($hex);
        $entity[$this->imgKey] = new CURLStringFile($bin, "img.png");
        return $entity;
    }
}
