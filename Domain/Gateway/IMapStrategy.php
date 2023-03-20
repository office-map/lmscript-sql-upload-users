<?php

namespace Lmscript\UploadUsers\Domain\Gateway;

interface IMapStrategy {
    public function map(array $entity): array;
}
