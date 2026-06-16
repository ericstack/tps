<header class="main-header">
  <a href="#" class="logo">
    <span class="logo-mini"><b>T</b>PS</span>
    <span class="logo-lg"><b>Trans </b>Proc Sys</span>

  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning"><?php
                                              if (empty($notification->stock_notification())) {
                                                echo '0';
                                              } else {
                                                echo count($notification->stock_notification());
                                              }
                                              ?></span>
          </a>
          <ul class="dropdown-menu">

            <li class="header"> <?php
                                if (empty($notification->stock_notification())) {
                                  echo ' You have 0 notification';
                                } else {
                                  echo ' You have ' . count($notification->stock_notification()) . ' notification';
                                }
                                ?></li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <?php foreach ($notification->stock_notification() as $key => $notif) {

                  echo " <li>
                  <a href='#'>
                    <i class='fa fa-shopping-cart text-aqua'></i> $notif
                  </a>
                </li>"
                ?>
                <?php
                }
                ?>
                <!-- <li>
                  <a href="#">
                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                    page and may cause design problems
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-users text-red"></i> 5 new members joined
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-user text-red"></i> You changed your username
                  </a>
                </li> -->
              </ul>
            </li>
            <!-- <li class="footer"><a href="#">View all</a></li> -->
          </ul>
        </li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="../../images/default-user.png" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $_SESSION["username"]; ?></span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="../../images/default-user.png" class="img-circle" alt="User Image">
              <p>
                <?php echo $_SESSION["username"]; ?>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="../logout_parse.php" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>