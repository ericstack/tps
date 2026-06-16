<<<<<<< HEAD
<?php include 'includes/header.php';?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
          <button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#myModal">
            Add Order
          </button>
          <h3 class="box-title">Orders</h3>
        </div>
        <div class="box-body">
		            <table id="employee_data" class="table table-bordered table-striped">
			                <thead>
                          <tr>
                             <th width="14%">Order ID</th>
                             <th width="14%">Product Name</th>
                             <th width="14%">Customer Name</th>
                             <th width="14%">Address</th>
                             <th width="14%">Contact Number</th>
                             <th width="14%">Quantity</th>
                             <th width="14%">Command</th>
                        </tr>
                      </thead>

			                <tbody >
                             <?php
                                   $query ="SELECT * FROM orders o JOIN products i USING (product_id) JOIN customer c USING (customer_id) WHERE status = 0 ";
                                   $result = mysqli_query($object->connect, $query);
                                    while($row = mysqli_fetch_object($result))
                                        {
                                             echo '
                                             <tr>
                                                  <td>'.$row->order_id.'</td>
                                                  <td>'.$row->product_name.'</td>
                                                  <td>'.$row->name.'</td>
                                                  <td>'.$row->address.'</td>
                                                  <td>'.$row->contact_number.'</td>
                                                   <td>'.$row->order_quantity.'</td>
                                                  <td><button type="button" name="update" id="'.$row->order_id.'" class="btn btn-success btn-xs updateOrder">Update</button></td>
                                             </tr>
                                             ';
                                        }
                              ?>
                      </tbody>
			        </table>
      </section>
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Add Order</h4>
            </div>
            <div class="modal-body">
             			<form class="form-horizontal" id="orderform" method="Post" class="collapse">
            <div class="modal-body">

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Order ID</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  name="orderID" id="orderID"  readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Product ID</label>
                <div class="col-sm-9">
                    <select class="selectpicker" name="product" id="product" data-live-search="true">
                    <option value="">Please Select</option>
                        <?php
                            $query ="SELECT * FROM products";
                             $result = mysqli_query($object->connect, $query);
                              while($row = mysqli_fetch_object($result))
                                  {
                                    echo '<option value="'.$row->product_id.'">'.$row->product_name.'</option>

                                       ';
                                  }
                        ?>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Customer</label>
                <div class="col-sm-9">
                    <select class="selectpicker" name="customer" id="customer" data-live-search="true">
                        <option value="">Please Select</option>
                        <?php
                            $query ="SELECT * FROM customer";
                             $result = mysqli_query($object->connect, $query);
                              while($row = mysqli_fetch_object($result))
                                  {
                                    echo '<option value="'.$row->customer_id.'">'.$row->name.'</option>

                                       ';
                                  }
                        ?>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Address</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  name="address" id="address" required="true" placeholder="Address">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Contact Number</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control"  name="number" id="number" placeholder="Contact Number">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Quantity</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control"  name="quantity" id="quantity" required="true" placeholder="Quantity">
                </div>
              </div>
              <input type="hidden" name="action" id="action" value="addOrder" />
              <input type="hidden" name="order_id" id="order_id" />

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
        <div class="box-header with-border">
          <button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#myModal">
            Add Order
          </button>
          <h3 class="box-title">Orders</h3>
        </div>
        <div class="box-body">
		            <table id="employee_data" class="table table-bordered table-striped">
			                <thead>
                          <tr>
                             <th width="14%">Order ID</th>
                             <th width="14%">Product Name</th>
                             <th width="14%">Customer Name</th>
                             <th width="14%">Address</th>
                             <th width="14%">Contact Number</th>
                             <th width="14%">Quantity</th>
                             <th width="14%">Command</th>
                        </tr>
                      </thead>

			                <tbody >
                             <?php
                                   $query ="SELECT * FROM orders o JOIN products i USING (product_id) JOIN customer c USING (customer_id) WHERE status = 0 ";
                                   $result = mysqli_query($object->connect, $query);
                                    while($row = mysqli_fetch_object($result))
                                        {
                                             echo '
                                             <tr>
                                                  <td>'.$row->order_id.'</td>
                                                  <td>'.$row->product_name.'</td>
                                                  <td>'.$row->name.'</td>
                                                  <td>'.$row->address.'</td>
                                                  <td>'.$row->contact_number.'</td>
                                                   <td>'.$row->order_quantity.'</td>
                                                  <td><button type="button" name="update" id="'.$row->order_id.'" class="btn btn-success btn-xs updateOrder">Update</button></td>
                                             </tr>
                                             ';
                                        }
                              ?>
                      </tbody>
			        </table>
      </section>
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Order</h4>
            </div>
            <div class="modal-body">
             			<form class="form-horizontal" id="orderform" method="Post" class="collapse">
            <div class="modal-body">

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Order ID</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  name="orderID" id="orderID"  readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Product ID</label>
                <div class="col-sm-9">
                    <select class="form-control" name="product" id="product" data-live-search="true">
                    <option value="">Please Select</option>
                        <?php
                            $query ="SELECT * FROM products";
                             $result = mysqli_query($object->connect, $query);
                              while($row = mysqli_fetch_object($result))
                                  {
                                    echo '<option value="'.$row->product_id.'">'.$row->product_name.'</option>

                                       ';
                                  }
                        ?>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Customer</label>
                <div class="col-sm-9">
                    <select class="form-control" name="customer" id="customer" data-live-search="true">
                        <option value="">Please Select</option>
                        <?php
                            $query ="SELECT * FROM customer";
                             $result = mysqli_query($object->connect, $query);
                              while($row = mysqli_fetch_object($result))
                                  {
                                    echo '<option value="'.$row->customer_id.'">'.$row->name.'</option>

                                       ';
                                  }
                        ?>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Address</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  name="address" id="address" required="true" placeholder="Address">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Contact Number</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control"  name="number" id="number" placeholder="Contact Number">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label text-left">Quantity</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control"  name="quantity" id="quantity" required="true" placeholder="Quantity">
                </div>
              </div>
              <input type="hidden" name="action" id="action" value="addOrder" />
              <input type="hidden" name="order_id" id="order_id" />

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
