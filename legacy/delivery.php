 <?php include 'includes/header.php';?> <section class="content">
   <div class="row">
     <div class="col-xs-12">
          				<div class="box">

						  <div class="box-header with-border">
						    	<button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#myModal">
							  Make Delivery
							</button>
						    <h3 class="box-title" align="left">Delivery</h3>
                <br />
						  </div>
						  <div class="box-body">
						    	<table id="delivery_data" class="table table-striped table-bordered">
						    		<thead>
						    			<tr>
						    				<td>Delivery #</td>
						    				<td>Order #</td>
						    				<td>Customer Name</td>
						    				<td>Location</td>
						    				<td>Delivery By:</td>
                        <td>Date of Delivery:</td>
						    				<td>Date of Deliveried:</td>
						    				<td>Status</td>
						    				<td>Command</td>
						    			</tr>
						    		</thead>
						    		<tbody>
						    				<?php                             $query ="SELECT * FROM deliveries LEFT JOIN employees e USING (employee_id)";
                                             $result = mysqli_query($object->connect, $query);
                                              while($row = mysqli_fetch_object($result))
                                                  {

                                                  	if($row->status == 0) {
                                                  		$status = 'Pending';
                                                  	}elseif($row->status == 1){
                                                  		$status = 'Out for Delivery';
                                                  	}else{
                                                      $status = 'Deliveried';
                                                    }

                                                       echo '
                                                       <tr>
                                                            <td>'.$row->delivery_id.'</td>
                                                            <td>'.$row->order_id.'</td>
                                                            <td>'.$row->customer_name.'</td>
                                                            <td>'.$row->address.'</td>
                                                            <td>'.$row->employee_name.'</td>
                                                            <td>'.$row->date_delivered.'</td>
                                                            <td>'.$row->dateofdelivery.'</td>
                                                            <td>'.$status.'</td>
                                                            <td><button type="button" name="update" id="'.$row->delivery_id.'" class="btn btn-success btn-xs updateDelivery">Update</button></td>
                                                       </tr>
                                                       ';
                                                  }
                                        ?>
						    		</tbody>
						    	</table>
						  </div>
						</div>
           </div>     </div></section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="makeDelivery" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delivery</h4>
      </div>
      <div class="modal-body">
       			<form class="form-horizontal" id="deliveryform" method="Post" class="collapse">
      <div class="modal-body">

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Delivery ID</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="deliveryID" id="deliveryID" placeholder="Delivery ID" readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Order ID</label>
          <div class="col-sm-9">
          		 <select class="form-control select2" readonly="true" name="orderID" id="orderID">
              <option value="">Please Select</option>
                  <?php
                      $query ="SELECT * FROM orders";
                       $result = mysqli_query($object->connect, $query);
                        while($row = mysqli_fetch_object($result))
                            {
                              echo '<option value="'.$row->order_id.'">'.$row->order_id.'</option>

                                 ';
                            }
                  ?>
              </select>
          </div>
        </div>
  		<div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Customer Name</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" readonly="true"  name="customerName" id="customerName" placeholder="Customer Name">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Customer Location</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" readonly="true" name="customerLocation" id="customerLocation" placeholder="Customer Location">
          </div>
        </div>
        <?php if($_SESSION["access"]==3){?>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label text-left">Status</label>
          <div class="col-sm-9">
               <select class="selectpicker" readonly="true" name="status" id="status" data-live-search="true">
              <option value="">Please Select</option>
              <option value="1">Out For Delivery</option>
              <option value="2">Deliveried</option>

              </select>
          </div>
        </div>
          <?php } ?>
        <input type="hidden" name="action" id="action" value="addDelivery" />
        <input type="hidden" name="delivery_id" id="delivery_id" />

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
include 'includes/footer.php'
?>
 <script>

 </script>
