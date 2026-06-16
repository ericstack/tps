<?php
// include 'core/database.php';
include 'app/database.php';
include 'app/loginController.php';

$db = new Database();
$dbconnection = $db->database_connect();
$login = new LoginController($dbconnection);
if (isset($_POST['login'])) {
     $fields = array(
          'username' => $_POST['username'],
          'password' => $_POST['password']
     );
     // echo password_hash('test', PASSWORD_BCRYPT); 
     $login->login_account($fields);
}

?>

<html>

<head>

     <title>Transaction Processing System</title>

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

     <!-- Font Awesome -->

     <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">

     <!-- Ionicons -->

     <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">

     <!-- jvectormap -->

     <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">

     <!-- Theme style -->

     <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

     <!-- AdminLTE Skins. Choose a skin from the css/skins

          folder instead of downloading all of them to reduce the load. -->

     <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">



</head>

<body class="hold-transition login-page">