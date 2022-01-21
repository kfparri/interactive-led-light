<?php
require_once PROJECT_ROOT_PATH . "Model\Database.php";

class CommandModel extends Database
{
    // Available requests
    // getcommands(number) - last x number of requests
    // getUnprocessedCommands - Get all commands with a status of NEW
    // 
    public function getCommands($limit)
    {
        return $this->select("SELECT * FROM Command ORDER BY TIMESTAMP DESC LIMIT 10"); //?", ["i", $limit]);
    }

    public function getUnproccesdCommands()
    {
        return $this->select("SELECT * FROM Command WHERE ProcessStatus = 'NEW' ORDER BY TIMESTAMP ASC");
    }

    public function insertCommand($command)
    {
        $this->executeStatement("insert into led_lights.Command(Timestamp, Command, ProcessStatus) VALUES (Now(), ?, 'NEW');", ["s", $command]);
        return [];
    }

    public function updateCommand($id)
    {
        $this->executeStatement("Update led_lights.Command SET ProcessStatus = 'COMPLETE' where ID = ?;", ["i", $id]);
        return [];
    }

    public function isAuthorized($apiKey)
    {
        $sql = "SELECT COUNT(*) AS apiKeyCount FROM api_keys WHERE active = 1 AND api_key = ?";

        $result = $this->select($sql, ["s", $apiKey]);

        if(isset($result[0]['apiKeyCount']) && $result[0]['apiKeyCount'] > 0)
        {
            return true;
        }

        return false;
    }

    public function updateApiKeyUsed($apiKey)
    {
        $sql = "UPDATE api_keys set last_used = NOW() where api_key = ?";

        $this->executeStatement($sql, ["s", $apiKey]);
    }
}