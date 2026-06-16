<!-- Developed by: ERIC PAUL JAUCIAN -->
<?php
// include '../../app/database.php';
// include '../../app/dashboard.php';
// include '../../app/inventory.php';
include '../../app/notification.php';
// include '../../app/purchase.php';
// $db = new Database();
// $dbconnection = $db->database_connect();
// $dashboard = new Dashboard($dbconnection);
// $inventory = new Inventory($dbconnection);
$notification = new Notification();
// $purchase = new Purchase($dbconnection);
// $purchasestmt = $purchase->display_purchase();
// if(!isset($_SESSION["access"])){
//   header('location:../login.php');
// }
?>
<html>

<head>
  <title>Transaction Processing System</title>
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
  <!-- Font Awesome -->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../../bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="../../dist/css/general.css">

</head>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <?php include '../../includes/nav.php'; ?>
    <?php include '../../includes/sidemenu.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->