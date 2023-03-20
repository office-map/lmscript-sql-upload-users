<?php

namespace LeaderMapConnection;

use LeaderMapConnection\Exception\HTTPException;
use Url\URL;

class Connection {

    private ConnectionOptions $options;
    private ?string $token;

    function __construct(ConnectionOptions $options) {
        $this->options = $options;
        $this->token = null;
    }

    public function send(Request $request) {
        if (!$this->token) $this->auth();
        $url = $this->url($request->path, $request->query);
        $headers = $this->options->use_ntlm_auth ? [] : [$this->authHeader()];
        return $this->sendPOSTRequest($url, $request->body, $headers);
    }

    private function auth() {
        if ($this->options->use_ntlm_auth) return;
        $result = $this->sendPOSTRequest($this->url("/App/Auth/API?action=auth"), $this->authBody());
        $this->token = $result["ws_auth"]["wst"];
    }

    private function authHeader(): string {
        return "x-ws-common-auth: " . $this->token;
    }

    private function authBody(): array {
        return [
            "login" => $this->options->login,
            "password" => $this->options->password,
            "workspace_id" => $this->options->workspace_id,
        ];
    }

    private function url(string $path, $query = []): URL {
        return new URL($this->options->url, $path, $query);
    }

    private function sendPOSTRequest(URL $url, array $body = [], array $headers = []): array {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if ($this->options->use_ntlm_auth) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC | CURLAUTH_NTLM);
            curl_setopt($ch, CURLOPT_USERPWD, sprintf('%s:%s', $this->options->login, $this->options->password));
        }
        $primaryResult = curl_exec($ch);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) >= 400) {
            curl_close($ch);
            throw new HTTPException($url, $body, $primaryResult);
        }
        curl_close($ch);

        $result = json_decode($primaryResult, true);

        if ($result["status"] != "ok")
            throw new HTTPException($url, $body, $primaryResult);

        return $result;
    }
}
