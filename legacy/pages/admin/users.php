<?php require '../../includes/header.php'; ?>
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#myModal">
        Add Users
      </button>
      <h3 class="box-title">
        Users</h3>
      <br />
    </div>
    <div class="box-body">
      <table id="employee_data" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="14%">Username</th>
            <th width="14%">Access</th>
            <th width="14%">Account</th>
            <th width="14%">Command</th>

          </tr>
        </thead>
        <tbody>
          <?php
          var_dump($users);
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<div class="modal fade" id="myModal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Users</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="userform" method="Post" class="collapse">
          <div class="modal-body">
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 control-label text-left">Username</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required="true">
              </div>
            </div>
            <div class="form-group" id="assignto">
              <label class="col-sm-3 control-label text-left">Assign to</label>
              <div class="col-sm-9">
                <select class="form-control" name="assign" id="assign" required>
                  <option value="">Please Select</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 control-label text-left">Employee Password</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="password" id="password" value="<?php echo $num = substr(str_shuffle("0123456789"), -4); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 control-label text-left">User Access</label>
              <div class="col-sm-9">
                <select class="form-control" name="access" id="access">
                  <option value="">Please Select</option>
                  <option value="1">Secretary</option>
                  <option value="2">Employee</option>
                  <option value="3">Delivery Man</option>
                </select>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="users_id" id="users_id" />
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php require '../../includes/footer.php'; ?>