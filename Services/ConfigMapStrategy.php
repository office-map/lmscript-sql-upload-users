<?php

namespace Lmscript\UploadUsers\Services;

use DeepArray\DeepArray;
use DeepArray\Path\PathFactory;
use Exception;
use Lmscript\UploadUsers\Domain\Gateway\IMapStrategy;

class ConfigMapStrategy implements IMapStrategy {

    private array $config;
    private PathFactory $pathFactory;

    function __construct(array $config) {
        $this->config = $config;
        $this->pathFactory = new PathFactory(".");
    }

    public function map(array $entity): array {
        $entity = new DeepArray($entity);
        $result = new DeepArray();
        foreach ($this->config as $entityKey => $resultKey) {
            $entityKey = $this->pathFactory->get($entityKey);
            $resultKey = $this->pathFactory->get($resultKey);
            if (!$entity->has($entityKey)) continue;
            $result->set($resultKey, $entity->get($entityKey));
        }
        return $result->get();
    }
}
