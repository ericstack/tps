<<<<<<< HEAD
<?php include 'includes/header.php';?>
    <section class="content">
				 <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Products</h3>

            </div>
                  <div class="box-body">
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">
          Add Product
        </button>
							            <table id="product_data" class="table table-bordered table-striped">
								                <thead>
                                    <tr>
                                       <th width="14%">Product ID</th>
                                       <th width="14%">Product Name</th>
                                       <th width="14%">Description</th>

                                       <th width="14%">Quantity</th>
                                       <th width="14%">Command</th>
                                  </tr>
                                </thead>

								                <tbody >
                                       <?php

                                             $query ="SELECT * FROM products";
                                             $result = mysqli_query($object->connect, $query);
                                              while($row = mysqli_fetch_object($result))
                                                  {
                                                       echo '
                                                       <tr>

                                                            <td>'.$row->product_id.'</td>
                                                            <td>'.$row->product_name.'</td>
                                                            <td>'.$row->description.'</td>
                                                            <td>'.$row->quantity.'</td>
                                                            <td><button type="button" name="update" id="'.$row->product_id.'" class="btn btn-success btn-xs updateProduct">Update</button></td>
                                                       </tr>
                                                       ';
                                                  }
                                        ?>
                                </tbody>
								          </table>
                        </div>
                  </div>
       </section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Order</h4>
      </div>
      <div class="modal-body">
       			<form class="form-horizontal" id="employeeform" method="Post" class="collapse">
      <div class="modal-body">

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Product ID</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="productID" id="productID"  readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Product Name</label>
          <div class="col-sm-9">
              <input type="text" class="form-control"  name="product_name" id="product_name" required="true" placeholder="Product Name" />
          </div>
        </div>
         <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Description</label>
          <div class="col-sm-9">
          <textarea name="description" class="form-control" id="description" required="true" cols="20" rows="10" placeholder="Description"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Quantity</label>
          <div class="col-sm-9">
              <input type="number" min="0" class="form-control"  name="product_qty" id="product_qty" required="true" placeholder="Product Quantity" />
          </div>
        </div>
        <input type="hidden" name="action" id="action" value="addProduct" />
        <input type="hidden" name="product_id" id="product_id" />

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
            <div class="box-header with-border">              <button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#myModal">

              Add Product

              </button>
              <h3 class="box-title">Products</h3>

            </div>
                  <div class="box-body">

							            <table id="product_data" class="table table-bordered table-striped">
								                <thead>
                                    <tr>
                                       <th width="14%">Product ID</th>
                                       <th width="14%">Product Name</th>
                                       <th width="14%">Description</th>

                                       <th width="14%">Quantity</th>
                                       <th width="14%">Command</th>
                                  </tr>
                                </thead>

								                <tbody >
                                       <?php

                                             $query ="SELECT * FROM products";
                                             $result = mysqli_query($object->connect, $query);
                                              while($row = mysqli_fetch_object($result))
                                                  {
                                                       echo '
                                                       <tr>

                                                            <td>'.$row->product_id.'</td>
                                                            <td>'.$row->product_name.'</td>
                                                            <td>'.$row->description.'</td>
                                                            <td>'.$row->quantity.'</td>
                                                            <td><button type="button" name="update" id="'.$row->product_id.'" class="btn btn-success btn-xs updateProduct">Update</button></td>
                                                       </tr>
                                                       ';
                                                  }
                                        ?>
                                </tbody>
								          </table>
                        </div>
                  </div>
       </section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Product</h4>
      </div>
      <div class="modal-body">
       			<form class="form-horizontal" id="employeeform" method="Post" class="collapse">
      <div class="modal-body">

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Product ID</label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="productID" id="productID"  readonly="true" value="<?php echo $num = substr(str_shuffle("0123456789"), -4);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Product Name</label>
          <div class="col-sm-9">
              <input type="text" class="form-control"  name="product_name" id="product_name" required="true" placeholder="Product Name" />
          </div>
        </div>
         <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Description</label>
          <div class="col-sm-9">
          <textarea name="description" class="form-control" id="description" required="true" cols="20" rows="10" placeholder="Description"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label text-left">Quantity</label>
          <div class="col-sm-9">
              <input type="number" min="0" class="form-control"  name="product_qty" id="product_qty" required="true" placeholder="Product Quantity" />
          </div>
        </div>
        <input type="hidden" name="action" id="action" value="addProduct" />
        <input type="hidden" name="product_id" id="product_id" />

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
