<?php

namespace Lmscript\UploadUsers\Services;

use Lmscript\UploadUsers\Domain\Gateway\IMapStrategy;

class DeleteNullMapStrategy implements IMapStrategy {

    public function map(array $entity): array {
        $result = [];
        foreach ($entity as $key => $value) {
            if (is_null($value)) continue;
            $result[$key] = $value;
        }
        return $result;
    }
}
