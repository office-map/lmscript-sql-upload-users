<?php

namespace Lmscript\UploadUsers\Domain\Gateway;

interface ISaveStrategy {
    public function save(array $entity): void;
}
