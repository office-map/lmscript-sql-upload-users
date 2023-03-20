<?php

namespace Lmscript\UploadUsers\config;

class SaveLeaderMapUserConfig {

    public bool $insert = true;
    public bool $update = true;

    public array $defaultNewUser = [
        "role" => "client",
        "password" => "1",
        "enabled" => "true",
        "plugin_data" => [
            "d56e0e5438ea4f7e81c820fdd380ef4e" => [
                "fieldc41a337d00b34b178a3c16e1eea4baf7" => "empty"
            ]
        ]
    ];
}
