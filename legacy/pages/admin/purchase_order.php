<?php require '../../includes/header.php'; ?>
<section class="content">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                Purchase Order</h3>
            <br />
            <button type="button" class="btn btn-info pull-right" id="addPO">
                <i class='fa fa-plus'></i> Add Purchase Order
            </button>
        </div>
        <div class="box-body">
            <table id="employee_data" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="14%">#</th>
                        <th width="14%">Company</th>
                        <th width="14%">Description</th>
                        <th width="14%">Quantity</th>
                        <th width="14%">Category</th>
                        <th width="14%">Command</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // foreach ($purchasestmt->fetchAll(PDO::FETCH_CLASS) as $purchases) {
                    // }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<div id="orderModal" class="modal fade">

    <div class="modal-dialog modal-lg">
        <form method="post" id="order_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3>Company Name</h3>
                                <p>[Street Address]</p>
                                <p>[City, ST Zip]</p>
                                <p>Phone: (000) 000-0000</p>
                                <p>Fax: (000) 000-0000</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-2 control-label">Date</label>
                                <div class="col-xs-10">
                                    <input type="date" class="form-control" id="inputEmail3" placeholder="Date">
                                </div>
                            </div>
                            <br />
                            <br />
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-2 control-label">PO#</label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Purchase Order NO#">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Vendor</h3>
                            <br />
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-4 control-label">Company Name</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Company Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-4 control-label">Contact No</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Contact No">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-4 control-label">Address</label>
                                <div class="col-xs-8">
                                    <textarea name="address" class="form-control" id="address" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>Ship to</h3>
                            <br />
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-4 control-label">Company Name</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Company Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-4 control-label">Contact No</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Contact No">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-4 control-label">Address</label>
                                <div class="col-xs-8">
                                    <textarea name="address" class="form-control" id="address" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-4 control-label">SHIP VIA</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="SHIP VIA">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-4 control-label">SHIPPING TERMS</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="SHIPPING TERMS">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label>Enter Product Details</label>
                        <table class='table table-stripped' id="purchaseTable">
                            <thead>
                                <td>
                                    Item #
                                </td>
                                <td>
                                    Description
                                </td>
                                <td>
                                    Quantity
                                </td>
                                <td>
                                    Unit Price
                                </td>
                                <td>
                                    Total
                                </td>
                            </thead>
                            <tbody>
                                <hr />
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label>Select Payment Status</label>
                        <select name="payment_status" id="payment_status" class="form-control">
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="inventory_order_id" id="inventory_order_id" />
                    <input type="hidden" name="btn_action" id="btn_action" />
                    <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                </div>
            </div>
        </form>
    </div>

</div>



<?php require '../../includes/footer.php'; ?>