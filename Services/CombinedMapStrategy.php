<?php

namespace Lmscript\UploadUsers\Services;

use Lmscript\UploadUsers\Domain\Gateway\IMapStrategy;

class CombinedMapStrategy implements IMapStrategy {

    /** @var IMapStrategy[] */
    private array $strategies;

    function __construct(...$strategies) {
        $this->strategies = $strategies;
    }

    public function map(array $entity): array {
        return array_reduce($this->strategies, function (array $entity, IMapStrategy $strategy) {
            return $strategy->map($entity);
        }, $entity);
    }
}
