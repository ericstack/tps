<<<<<<< HEAD
<?php include 'includes/header.php';?>
<section class="content">
  <div class="row">
  <div class="col-xs-12">
  	<div class="box">
        <div class="box-header with-border">
          <button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#myModal">
            Add Employee
          </button>
          <h3 class="box-title">Employees</h3>
          <br />
        </div>
          <div class="box-body">
                <table id="employee_data" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                             <th width="14%">Employee ID</th>
                             <th width="14%">Employee Name</th>
                             <th width="14%">Address</th>
                             <th width="14%">Gender</th>
                             <th width="14%">Birthday</th>
                             <th width="14%">Command</th>
                        </tr>
                      </thead>

                      <tbody  >
                             <?php

                                   $query ="SELECT * FROM employees";
                                   $result = mysqli_query($object->connect, $query);
                                    while($row = mysqli_fetch_object($result))
                                        {
                                           if($row->gender== 'M'){
                                                $gender = 'Male';
                                              }else{
                                                $gender = 'Female';
                                              }
                                             echo '
                                             <tr>
                                                  <td>'.$row->employee_id.'</td>
                                                  <td>'.$row->employee_name.'</td>
                                                  <td>'.$row->address.'</td>
                                                  <td>'.$gender.'</td>
                                                  <td>'.$row->birthday.'</td>
                                                  <td><button type="button" name="update" id="'.$row->id.'" class="btn btn-success btn-xs updateEmployee">Update</button></td>
                                             </tr>
                                             ';
                                        }
                              ?>
                      </tbody>
              </table>
        </div>
    </div>
 </section>
 </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Employee</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" id="employeeform" method="Post" class="collapse">
              <div class="modal-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label text-left">Employee ID</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  name="employeeID" id="employeeID" placeholder="Employee ID" readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label text-left">Employee Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  name="employee_name" id="employee_name" placeholder="Last Name" required="true">
                      </div>
                    </div>
                     <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label text-left">Complete Address</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  name="address" id="address"  placeholder="Complete Address">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label text-left">Gender</label>
                      <div class="col-sm-9">
                        <select name="gender" id="gender" class="form-control" required="true">
                          <option value="">Please Select</option>
                          <option value="M">Male</option>
                          <option value="F">Female</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label text-left">Birthday</label>
                      <div class="col-sm-9">
                        <input type="date" class="form-control" name="bday" id="bday"  placeholder="Birthday">
                      </div>
                    </div>
                    <input type="hidden" name="action" id="action" value="addEmployee" />
                    <input type="hidden" name="employee_id" id="employee_id" />

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" id="button_action" value="Save" />
                  </div>
          </form>
      </div>
    </div>
  </div>
</div>
<?php
include 'includes/footer.php';
?>
=======
<?php include 'includes/header.php';?>
<section class="content">
  <div class="row">
  <div class="col-xs-12">
  	<div class="box">
        <div class="box-header with-border">
          <button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#myModal">
            Add Employee
          </button>
          <h3 class="box-title">Employees</h3>
          <br />
        </div>
          <div class="box-body">
                <table id="employee_data" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                             <th width="14%">Employee ID</th>
                             <th width="14%">Employee Name</th>
                             <th width="14%">Address</th>
                             <th width="14%">Gender</th>
                             <th width="14%">Birthday</th>
                             <th width="14%">Command</th>
                        </tr>
                      </thead>

                      <tbody  >
                             <?php

                                   $query ="SELECT * FROM employees";
                                   $result = mysqli_query($object->connect, $query);
                                    while($row = mysqli_fetch_object($result))
                                        {
                                           if($row->gender== 'M'){
                                                $gender = 'Male';
                                              }else{
                                                $gender = 'Female';
                                              }
                                             echo '
                                             <tr>
                                                  <td>'.$row->employee_id.'</td>
                                                  <td>'.$row->employee_name.'</td>
                                                  <td>'.$row->address.'</td>
                                                  <td>'.$gender.'</td>
                                                  <td>'.$row->birthday.'</td>
                                                  <td><button type="button" name="update" id="'.$row->id.'" class="btn btn-success btn-xs updateEmployee">Update</button></td>
                                             </tr>
                                             ';
                                        }
                              ?>
                      </tbody>
              </table>
        </div>
    </div>
 </section>
 </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Employee</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" id="employeeform" method="Post" class="collapse">
              <div class="modal-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label text-left">Employee ID</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  name="employeeID" id="employeeID" placeholder="Employee ID" readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label text-left">Employee Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  name="employee_name" id="employee_name" placeholder="Last Name" required="true">
                      </div>
                    </div>
                     <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label text-left">Complete Address</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  name="address" id="address"  placeholder="Complete Address">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label text-left">Gender</label>
                      <div class="col-sm-9">
                        <select name="gender" id="gender" class="form-control" required="true">
                          <option value="">Please Select</option>
                          <option value="M">Male</option>
                          <option value="F">Female</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label text-left">Birthday</label>
                      <div class="col-sm-9">
                        <input type="date" class="form-control" name="bday" id="bday"  placeholder="Birthday">
                      </div>
                    </div>
                    <input type="hidden" name="action" id="action" value="addEmployee" />
                    <input type="hidden" name="employee_id" id="employee_id" />

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" id="button_action" value="Save" />
                  </div>
          </form>
      </div>
    </div>
  </div>
</div>
<?php
include 'includes/footer.php';
?>
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
