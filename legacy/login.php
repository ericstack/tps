<?php
include "includes/head.php";

?>
<div class="login-box">
  <div class="login-logo">
    <b>Transaction Processing System</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <form method="post">
      <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-info"></i> Alert!</h4>
          <?php echo $_GET['msg']; ?>
        </div>
      <?php } ?>
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php
// include "includes/footer.php";
?>