<?php
include_once 'php-includes/connect.inc.php';

// Browser Session Start here
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    $user = $_SESSION['user_name'];

    $stmt = $db->prepare("SELECT id, firstname, lastname FROM `cp_users` WHERE id= {$_SESSION['user_id']}");
    $stmt->bind_result($id, $FirstName, $LastName);
    $stmt->execute();
    ?>


    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="dist/img/user1.png" class="user-image" alt="User Image">
    <?php
    
    while ($stmt->fetch()) {
     
     ?>

                            <span class="hidden-xs"><?php echo $FirstName . " " . $LastName; ?></span>
                            <?php
                        }
                        ?>

                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="dist/img/user1.png" class="img-circle" alt="User Image">
                            <p>
                                Hello...!! <br>
                               <?php echo $FirstName . " " . $LastName; ?>
                                <small></small>

                            </p>
                            <br>
                            <br>
                        </li>
                        <!-- Menu Footer-->


                        <li class="user-footer">
                            <div class="pull-left">
                                <!-- <a href="#" class="btn btn-default btn-flat">Profile</a>-->
                            </div>
                            <div class="pull-right">
                                <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>

    </nav>
    </header>


    <?php
    // If session isn't meet, user will redirect to login page
} else {
    header('Location: login.php');
}
?>