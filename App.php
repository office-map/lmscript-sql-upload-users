<?php

namespace Lmscript\UploadUsers;

use Lmscript\UploadUsers\Domain\Gateway\IMapStrategy;
use Lmscript\UploadUsers\Domain\Gateway\ISaveStrategy;
use Lmscript\UploadUsers\Domain\Gateway\ISourceEntities;

class App {

    private ISourceEntities $sourceEntities;
    private IMapStrategy $mapStrategy;
    private ISaveStrategy $saveStrategy;

    function __construct(
        ISourceEntities $sourceEntities,
        IMapStrategy $mapStrategy,
        ISaveStrategy $saveStrategy
    ) {
        $this->sourceEntities = $sourceEntities;
        $this->mapStrategy = $mapStrategy;
        $this->saveStrategy = $saveStrategy;
    }

    public function run() {
        foreach ($this->sourceEntities as $entity) {
            $mapped = $this->mapStrategy->map($entity);
            // var_dump($mapped);
            try {
                $this->saveStrategy->save($mapped);
            } catch (\Throwable $e) {
                var_dump([
                    "status" => "error",
                    "error" => $e
                ]);
            }
        }
    }
}
