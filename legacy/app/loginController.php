<?php

class LoginController
{
   private $database_connect;
   public function __construct($db)
   {
      $this->database_connect = $db;
   }
   public function login_account($fields)
   {
      $sql = "SELECT * FROM accounts WHERE username = :username";
      $stmt = $this->database_connect->prepare($sql);
      $stmt->execute([
         'username' => $fields['username'],
      ]);
      $count = $stmt->rowCount();
      $users = $stmt->fetchAll();
      if ($count > 0) {
         foreach ($users as $user) {
            if (password_verify($fields['password'], $user['password'])) {

               $_SESSION['username'] = $user['username'];
               $_SESSION['id'] = $user['username'];
               $_SESSION['access'] = $user['access'];
               switch ($user['access']) {
                  case 1:
                     header('location:pages/admin/dashboard.php');
                     break;
                  case 2:
                     header('location:/index.php');
                     break;
                  default:
                     header('location:login.php?msg=msg');
               }
            } else {
               $this->error_logs('Login', "Invalid Password for:" . $user['username']);
            }
         }
      } else {
         $this->error_logs('Login', "Username doesn\'t exist");
      }
   }
   public function error_logs($errorType, $log)
   {
      $sql = "INSERT INTO logs(`type`,`msg`)VALUES(?,?)";
      $stmt = $this->database_connect->prepare($sql);
      $stmt->execute([
         $errorType, $log
      ]);
   }
}
