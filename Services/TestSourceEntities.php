<?php

namespace Lmscript\UploadUsers\Services;

use ArrayIterator;
use Lmscript\UploadUsers\Domain\Gateway\ISourceEntities;

class TestSourceEntities extends ArrayIterator implements ISourceEntities {
    function __construct() {
        parent::__construct([
            ["Email" => "aa@test.com", "Login" => "test-aa", "Name" => "test aa2"]
        ]);
    }
}
