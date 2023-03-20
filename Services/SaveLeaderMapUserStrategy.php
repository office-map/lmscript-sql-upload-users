<?php

namespace Lmscript\UploadUsers\Services;

use DeepArray\MergedDeepArray;
use LeaderMapConnection\Collection;
use LeaderMapConnection\Connection;
use LeaderMapRequests\Command\Meta\SaveUserRequest;
use LeaderMapRequests\Query\Meta\UsersListRequest;
use Lmscript\UploadUsers\Domain\Gateway\ISaveStrategy;
use LeaderMapRequests\Options\Location;
use LeaderMapRequests\Query\Meta\UserRequest;

class SaveLeaderMapUserStrategy implements ISaveStrategy {

    private Connection $connection;
    private Location $location;
    private bool $insert;
    private bool $update;
    private array $defaultNewUser;

    function __construct(
        Connection $connection,
        Location $location,
        bool $insert,
        bool $update,
        array $defaultNewUser
    ) {
        $this->connection = $connection;
        $this->location = $location;
        $this->insert = $insert;
        $this->update = $update;
        $this->defaultNewUser = $defaultNewUser;
    }

    public function save(array $entity): void {
        $insert = $this->insert;
        $update = $this->update;
        $userID = $this->userIDByLogin($entity["login"]);
        if ($userID == -1 && !$insert) return;
        if ($userID != -1 && !$update) return;
        $data = $userID == -1 ? $this->insertData($entity) : $this->updateData($this->user($userID), $entity);
        $request = new SaveUserRequest($this->location, $data);
        $result = $this->connection->send($request);
    }

    private function insertData(array $entity): array {
        $data = new MergedDeepArray($this->defaultNewUser, $entity);
        return $data->get();
    }

    private function updateData(array $user, array $entity): array {
        $data = new MergedDeepArray($user, $entity);
        return $data->get();
    }

    private function user($id): array {
        $request = new UserRequest($this->location, $id);
        $result = $this->connection->send($request);
        return $result["user"];
    }

    private function userIDByLogin(string $login): int {
        $request = new UsersListRequest($this->location, ["filters[login]" => $login]);
        $collection = new Collection($this->connection, $request);
        return count($collection) ? $collection->current()["id"] : -1;
    }
}
