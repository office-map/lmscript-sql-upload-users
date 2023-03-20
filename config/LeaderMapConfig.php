<?php

namespace Lmscript\UploadUsers\config;

use LeaderMapConnection\ConnectionOptions;

class LeaderMapConfig extends ConnectionOptions {

    public string $url = "";

    public int $workspace_id = 2;

    public int $project_id = 2;

    public bool $use_ntlm_auth = false;

    public string $login = "";

    public string $password = "";
}
