<?php
include 'database.php';
class Account
{
    private $database_connect;
    private $error_logs;
    public function __construct($db)
    {
        $this->database_connect = $db;
    }

    protected function create_account($query)
    {
        return 'Hello';
    }

    protected function update_account($query)
    {
        return 'Hello';
    }

    public function show_account_list()
    {
        $sql = "SELECT id,username,access,account FROM accounts";
        $stmt = $this->database_connect->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetch(PDO::FETCH_ASSOC);
        return $users;
    }
    public function show_account($username)
    {
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = $this->database_connect->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        return $user;
    }

    protected function delete_account($query)
    {
        return 'Hello';
    }
}
