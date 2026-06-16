<?php require '../../includes/header.php'; ?>
<section class="content">
    <div class="alert alert-success alert-dismissible " id="alert-msg" role="alert" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 id="msg"></h3>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                Inventory</h3>
            <br />
            <button type="button" class="btn btn-info pull-right" id="addProd">
                <i class='fa fa-plus'></i> Add New Product
            </button>
        </div>
        <div class="box-body">
            <table id="inventory_data" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="14%">Serial No</th>
                        <th width="14%">Product Name</th>
                        <th width="14%">Description</th>
                        <th width="14%">Quantity</th>
                        <th width="14%">Category</th>
                        <th width="14%">Command</th>

                    </tr>
                </thead>

            </table>
        </div>
    </div>
</section>
<div class="modal fade" id="productModal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <form class="form-horizontal" id="product_form">
                <div class="modal-body ">
                    <div class="box-body ">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 text-left control-label">Product Name</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 text-left control-label">Description</label>

                            <div class="col-sm-9">
                                <textarea class="form-control" name="product_description" id="product_description" placeholder="Description" id="desc" cols="20" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 text-left control-label">Initial Quantity</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Initial Quantity">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 text-left control-label">Category</label>

                            <div class="col-sm-9">
                                <select class="form-control" name="category" id="category" required>

                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="action" id="action" value="add">
                    <input type="hidden" name="id" id="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="productbtn">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php require '../../includes/footer.php'; ?>