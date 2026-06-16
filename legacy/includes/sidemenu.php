<!-- Left side column. contains the sidebar -->

<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu " data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <?php if ($_SESSION["access"] == 1) { ?>
        <!-- <li><a href="customer.php"><i class="fa fa-users"></i>  <span>Customer </span></a></li>
       <li><a href="employee.php"><i class="fa  fa-male"></i>  <span>Employee </span></a></li> -->
        <!-- <li><a href="delivery.php"><i class="fa fa-truck"></i>  <span>Delivery </span></a></li> -->

        <li><a href="warehouse.php"><span class="glyphicon glyphicon-home"></span><span> Warehouse </span></a></li>
        <li><a href="inventory.php"><i class="fa fa-cubes"></i><span> Inventory </span></a></li>
        <li><a href="orders.php"><i class="fa  fa-opencart"></i><span> Orders </span></a></li>
        <li><a href="purchase_order.php"><i class="fa   fa-file"></i><span> Purchase </span></a></li>
        <!-- <li><a href="task.php"><i class="fa fa-tasks"></i>  <span>Task</a> </span></li> -->
        <li><a href="reports.php"><i class="fa fa-folder"></i><span> Reports</a> </span></li>
        <li><a href="users.php"><i class="fa fa-user"></i> <span> Users </span></a></li>

      <?php } elseif ($_SESSION["access"] == 2) {
      ?>
        <li><a href="task.php"><i class="fa fa-tasks"></i> <span>Task</a> </span></li>

      <?php } elseif ($_SESSION["access"] == 3) { ?>
        <li><a href="delivery.php"><i class="fa fa-truck"></i> <span>Delivery </span></a></li>
        <li><a href="task.php"><i class="fa fa-tasks"></i> <span>Task </span></a></li>


      <?php } else { ?>
        <li><a href="customer.php"><i class="fa fa-users"></i> <span>Customer </span></a></li>
        <li><a href="employee.php"><i class="fa  fa-male"></i> <span>Employee </span></a></li>
        <li><a href="delivery.php"><i class="fa fa-truck"></i> <span>Delivery </span></a></li>
        <li><a href="products.php"><i class="fa fa-cubes"></i> <span>Products </span></a></li>
        <li><a href="orders.php"><i class="fa  fa-opencart"></i> <span>Orders </span></a></li>
        <li><a href="task.php"><i class="fa fa-tasks"></i> <span>Task </span></a></li>
        <li><a href="reports.php"><i class="fa fa-folder"></i> <span>Reports </span></a></li>
        <li><a href="users.php"><i class="fa fa-user"></i> <span>Users </span></a></li>

      <?php } ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>