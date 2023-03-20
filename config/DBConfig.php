<?php

namespace Lmscript\UploadUsers\config;

class DBConfig {

    public string $dsn = "mysql:host=localhost:8889;dbname=lights-on";
    public ?string $username = "root";
    public ?string $password = "root";

    public string $sql = "SELECT Login, Email, Name, Division, Boss, Parent FROM users";
}
