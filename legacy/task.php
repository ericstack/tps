<<<<<<< HEAD
<?php include 'includes/header.php';?>
    <section class="content">
          	<div class="box">
						  <div class="box-header with-border">
						    <h3 class="box-title">Task</h3>
						  </div>
						  <div class="box-body">
                <?php if($_SESSION["access"]==1){
                  ?>
						  <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">
							  Add Task
							</button>
              <?php }?>
						    	<table id="task_data" class="table table-striped table-bordered">

                    <?php if($_SESSION["access"]==1){
                      ?>
                      <thead>
                      <tr>
                        <td>Task #</td>
                        <td>Subject</td>
                        <td>Description</td>
                        <td>Date Assigned</td>
                        <td>Due Date:</td>
                        <td>Employee</td>
                        <td>Status</td>
                        <td>Command</td>
                      </tr>
                    </thead>
						    		<tbody >
						    			<?php
                       $query ="SELECT * FROM task t JOIN employees e USING (employee_id)";
                                             $result = mysqli_query($object->connect, $query);
                                              while($row = mysqli_fetch_object($result))
                                                  {
                                                     if($row->status==0){
                                                      $status = 'Pending';
                                                    }else{
                                                      $status = 'Completed';
                                                    }

                                                       echo '
                                                       <tr>
                                                            <td>'.$row->task_id.'</td>
                                                            <td>'.$row->subject.'</td>
                                                            <td>'.$row->description.'</td>
                                                            <td>'.$row->assigned.'</td>
                                                            <td>'.$row->due.'</td>
						    			   <td>'.$row->employee_name.'</td>
                         <td>'.$status.'</td>
                                              <td><button type="button" name="update" id="'.$row->task_id.'" class="btn btn-success btn-xs updateTask">Update</button></td>
                                                       </tr>
                                                       ';
                                                  }
                                        ?>
						    		</tbody>
                    <?php }else{ ?>
                    <thead>
                      <tr>
                        <td>Task #</td>
                        <td>Subject</td>
                        <td>Description</td>
                        <td>Date Assigned</td>
                        <td>Due Date:</td>
                        <td>Status</td>
                        <td>Command</td>
                      </tr>
                    </thead>
                    <?php
                       $query ="SELECT * FROM task t JOIN employees e USING (employee_id) WHERE employee_id='".$_SESSION['assign']."'";
                           $result = mysqli_query($object->connect, $query);
                                              while($row = mysqli_fetch_object($result))
                                                  {
                                                    if($row->status==0){
                                                      $status = 'Pending';
                                                    }else{
                                                      $status = 'Completed';
                                                    }
                                                       echo '
                                                       <tr>
                                                            <td>'.$row->task_id.'</td>
                                                            <td>'.$row->subject.'</td>
                                                            <td>'.$row->description.'</td>
                                                            <td>'.$row->assigned.'</td>
                                                            <td>'.$row->due.'</td>
                                                            <td>'.$status.'</td>
                                              <td><button type="button" name="update" id="'.$row->task_id.'" class="btn btn-success btn-xs updateTask">Update</button></td>
                                                       </tr>
                                                       ';
                                                  }
                                        ?>
                    </tbody>
                    <?php } ?>
						    	</table>
						  </div>
						</div>
</section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Assign Task</h4>
      </div>
      <div class="modal-body">
       			<form class="form-horizontal" id="taskform" method="Post" class="collapse">
      <div class="modal-body">


        <?php if($_SESSION["access"]==1){
                      ?>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Task ID</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="taskID" id="taskID" readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Subject</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="subject" id="subject" placeholder="Subject" required="true">
          </div>
        </div>
         <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Description</label>
          <div class="col-sm-9">
           <textarea class="form-control" name="description" id="description" cols="10" rows="10"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Date Assigned</label>
          <div class="col-sm-9">
            <input type="date" class="form-control"  name="date_assigned" id="date_assigned" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Due Date</label>
          <div class="col-sm-9">
            <input type="date" class="form-control"  name="due_date" id="due_date" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Employees:</label>
          <div class="col-sm-9">
	           <select class="selectpicker" name="employees" id="employees" data-live-search="true">
	              <option value="">Please Select</option>
	                  <?php
	                      $query ="SELECT * FROM employees";
	                       $result = mysqli_query($object->connect, $query);
	                        while($row = mysqli_fetch_object($result))
	                            {
	                              echo '<option value="'.$row->employee_id.'">'.$row->employee_name.'</option>

	                                 ';
	                            }
	                  ?>

	               <!--  <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option> -->

	              </select>
          </div>
        </div>
        <?php }elseif($_SESSION["access"]==2){?>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Task ID</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="taskID" id="taskID" readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Subject</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="subject" id="subject" readonly="true" placeholder="Subject" required="true">
          </div>
        </div>
         <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Description</label>
          <div class="col-sm-9">
           <textarea class="form-control" name="description" id="description" readonly="true" cols="10" rows="10"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Date Assigned</label>
          <div class="col-sm-9">
            <input type="date" class="form-control"  name="date_assigned" readonly="true" id="date_assigned" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Due Date</label>
          <div class="col-sm-9">
            <input type="date" class="form-control"  name="due_date" readonly="true" id="due_date" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Employees:</label>
          <div class="col-sm-9">
             <select class="form-control" name="status" id="status"  data-live-search="true">
                <option value="0">Pending</option>
                <option value="1">Completed</option>
                </select>
          </div>
        </div>
        <?php } ?>

        <input type="hidden" name="action" id="action" value="addTask" />
        <input type="hidden" name="task_id" id="task_id" />

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
          	<div class="box">
						  <div class="box-header with-border">                <?php if($_SESSION["access"]==1 || $_SESSION["access"]==0){

                  ?>

                <button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#myModal">

                Add Task

                </button>

                <?php }?>
						    <h3 class="box-title">Task</h3>                <br />
						  </div>
						  <div class="box-body">

						    	<table id="task_data" class="table table-striped table-bordered">

                    <?php if($_SESSION["access"]==1 || $_SESSION["access"]==0){
                      ?>
                      <thead>
                      <tr>
                        <td>Task #</td>
                        <td>Subject</td>
                        <td>Description</td>
                        <td>Date Assigned</td>
                        <td>Due Date:</td>
                        <td>Employee</td>
                        <td>Status</td>
                        <td>Command</td>
                      </tr>
                    </thead>
						    		<tbody >
						    			<?php
                       $query ="SELECT * FROM task t JOIN employees e USING (employee_id)";
                                             $result = mysqli_query($object->connect, $query);
                                              while($row = mysqli_fetch_object($result))
                                                  {
                                                     if($row->status==0){
                                                      $status = 'Pending';
                                                    }else{
                                                      $status = 'Completed';
                                                    }

                                                       echo '
                                                       <tr>
                                                            <td>'.$row->task_id.'</td>
                                                            <td>'.$row->subject.'</td>
                                                            <td>'.$row->description.'</td>
                                                            <td>'.$row->assigned.'</td>
                                                            <td>'.$row->due.'</td>
						    			   <td>'.$row->employee_name.'</td>
                         <td>'.$status.'</td>
                                              <td><button type="button" name="update" id="'.$row->task_id.'" class="btn btn-success btn-xs updateTask">Update</button></td>
                                                       </tr>
                                                       ';
                                                  }
                                        ?>
						    		</tbody>
                    <?php }else{ ?>
                    <thead>
                      <tr>
                        <td>Task #</td>
                        <td>Subject</td>
                        <td>Description</td>
                        <td>Date Assigned</td>
                        <td>Due Date:</td>
                        <td>Status</td>
                        <td>Command</td>
                      </tr>
                    </thead>
                    <?php
                       $query ="SELECT * FROM task t JOIN employees e USING (employee_id) WHERE employee_id='".$_SESSION['assign']."'";
                           $result = mysqli_query($object->connect, $query);
                                              while($row = mysqli_fetch_object($result))
                                                  {
                                                    if($row->status==0){
                                                      $status = 'Pending';
                                                    }else{
                                                      $status = 'Completed';
                                                    }
                                                       echo '
                                                       <tr>
                                                            <td>'.$row->task_id.'</td>
                                                            <td>'.$row->subject.'</td>
                                                            <td>'.$row->description.'</td>
                                                            <td>'.$row->assigned.'</td>
                                                            <td>'.$row->due.'</td>
                                                            <td>'.$status.'</td>
                                              <td><button type="button" name="update" id="'.$row->task_id.'" class="btn btn-success btn-xs updateTask">Update</button></td>
                                                       </tr>
                                                       ';
                                                  }
                                        ?>
                    </tbody>
                    <?php } ?>
						    	</table>
						  </div>
						</div>
</section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Task</h4>
      </div>
      <div class="modal-body">
       			<form class="form-horizontal" id="taskform" method="Post" class="collapse">
      <div class="modal-body">


        <?php if($_SESSION["access"]==1 || $_SESSION["access"]==0 ){
                      ?>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Task ID</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="taskID" id="taskID" readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Subject</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="subject" id="subject" placeholder="Subject" required="true">
          </div>
        </div>
         <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Description</label>
          <div class="col-sm-9">
           <textarea class="form-control" name="description" id="description" cols="10" rows="10"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Date Assigned</label>
          <div class="col-sm-9">
            <input type="date" class="form-control"  name="date_assigned" id="date_assigned" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Due Date</label>
          <div class="col-sm-9">
            <input type="date" class="form-control"  name="due_date" id="due_date" />            <input type="hidden" class="form-control"  name="status" id="status" value="pending" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Employees:</label>
          <div class="col-sm-9">
	           <select class="form-control" name="employees" id="employees" >
	              <option value="">Please Select</option>
	                  <?php
	                      $query ="SELECT * FROM employees";
	                       $result = mysqli_query($object->connect, $query);
	                        while($row = mysqli_fetch_object($result))
	                            {
	                              echo '<option value="'.$row->employee_id.'">'.$row->employee_name.'</option>

	                                 ';
	                            }
	                  ?>

	               <!--  <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option> -->

	              </select>
          </div>
        </div>
        <?php }elseif($_SESSION["access"]==2){?>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Task ID</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="taskID" id="taskID" readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Subject</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="subject" id="subject" readonly="true" placeholder="Subject" required="true">
          </div>
        </div>
         <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Description</label>
          <div class="col-sm-9">
           <textarea class="form-control" name="description" id="description" readonly="true" cols="10" rows="10"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Date Assigned</label>
          <div class="col-sm-9">
            <input type="date" class="form-control"  name="date_assigned" readonly="true" id="date_assigned" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Due Date</label>
          <div class="col-sm-9">
            <input type="date" class="form-control"  name="due_date" readonly="true" id="due_date" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Employees:</label>
          <div class="col-sm-9">
             <select class="form-control" name="status" id="status"  data-live-search="true">
                <option value="0">Pending</option>
                <option value="1">Completed</option>
                </select>
          </div>
        </div>
        <?php } ?>

        <input type="hidden" name="action" id="action" value="addTask" />
        <input type="hidden" name="task_id" id="task_id" />

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
