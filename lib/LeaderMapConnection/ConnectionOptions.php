<?php

namespace LeaderMapConnection;

class ConnectionOptions {

    public string $url;

    public int $workspace_id;

    public int $project_id;

    public bool $use_ntlm_auth;

    public string $login;

    public string $password;

    public static function fromArray(array $state): ConnectionOptions {
        $result = new ConnectionOptions();
        $result->url = $state["url"];
        $result->workspace_id = $state["workspace_id"];
        $result->project_id = $state["project_id"];
        $result->use_ntlm_auth = $state["use_ntlm_auth"];
        $result->login = $state["login"];
        $result->password = $state["password"];
        return $result;
    }
}
