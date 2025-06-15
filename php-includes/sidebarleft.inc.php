<?php
// Browser Session Start here
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    $user = $_SESSION['user_name'];

    //Select the user and assign permission...  (ON/OFF Customer Menu)        
    $stmt_pid_1111 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1111");
    $stmt_pid_1111->bind_result($cp_users_id1111, $cp_users_firstname1111, $cp_users_lastname1111, $cp_userpermission_permission_id1111, $cp_userpermission_uid1111, $cp_userpermission_OnOff1111);
    $stmt_pid_1111->execute();

    while ($stmt_pid_1111->fetch()) {

        if ($cp_userpermission_OnOff1111 == 0) {

            $style_pid_1111 = "display: none;";
        }
    }


    //Select the user and assign permission...  (ON/OFF Items Menu)        
    $stmt_pid_1112 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1112");
    $stmt_pid_1112->bind_result($cp_users_id1112, $cp_users_firstname1112, $cp_users_lastname1112, $cp_userpermission_permission_id1112, $cp_userpermission_uid1112, $cp_userpermission_OnOff1112);
    $stmt_pid_1112->execute();

    while ($stmt_pid_1112->fetch()) {

        if ($cp_userpermission_OnOff1112 == 0) {

            $style_pid_1112 = "display: none;";
        }
    }


    //Select the user and assign permission...  (ON/OFF Sales Reps Menu)        
    $stmt_pid_1113 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1113");
    $stmt_pid_1113->bind_result($cp_users_id1113, $cp_users_firstname1113, $cp_users_lastname1113, $cp_userpermission_permission_id1113, $cp_userpermission_uid1113, $cp_userpermission_OnOff1113);
    $stmt_pid_1113->execute();

    while ($stmt_pid_1113->fetch()) {

        if ($cp_userpermission_OnOff1113 == 0) {

            $style_pid_1113 = "display: none;";
        }
    }


    //Select the user and assign permission...  (ON/OFF Roots Menu)        
    $stmt_pid_1114 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1114");
    $stmt_pid_1114->bind_result($cp_users_id1114, $cp_users_firstname1114, $cp_users_lastname1114, $cp_userpermission_permission_id1114, $cp_userpermission_uid1114, $cp_userpermission_OnOff1114);
    $stmt_pid_1114->execute();

    while ($stmt_pid_1114->fetch()) {

        if ($cp_userpermission_OnOff1114 == 0) {

            $style_pid_1114 = "display: none;";
        }
    }

    //Select the user and assign permission...  (ON/OFF Report Dashboard)        
    $stmt_pid_1122 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1122");
    $stmt_pid_1122->bind_result($cp_users_id1122, $cp_users_firstname1122, $cp_users_lastname1122, $cp_userpermission_permission_id1122, $cp_userpermission_uid1122, $cp_userpermission_OnOff1122);
    $stmt_pid_1122->execute();

    while ($stmt_pid_1122->fetch()) {

        if ($cp_userpermission_OnOff1122 == 0) {

            $style_pid_1122 = "display: none;";
        }
    }

    //Select the user and assign permission...  (ON/OFF User Menu)        
    $stmt_pid_1124 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1124");
    $stmt_pid_1124->bind_result($cp_users_id1124, $cp_users_firstname1124, $cp_users_lastname1124, $cp_userpermission_permission_id1124, $cp_userpermission_uid1124, $cp_userpermission_OnOff1124);
    $stmt_pid_1124->execute();

    while ($stmt_pid_1124->fetch()) {

        if ($cp_userpermission_OnOff1124 == 0) {

            $style_pid_1124 = "display: none;";
        }
    }
    ?>



    <?php
    // If page name is set on URL, Nav bar will forcus on the to the page....
    if (isset($_GET['page'])) {
        $setpage = $_GET['page'];

        if ($setpage == "Customers") {
            $active1 = "active";
        }

        if ($setpage == "Rep") {
            $active3 = "active";
        }

        if ($setpage == "Invoice") {
            $active4 = "active";
        }

        if ($setpage == "Roots") {
            $active5 = "active";
        }

        if ($setpage == "ViewSubjectAllocations") {
            $active6 = "active";
        }

        if ($setpage == "AddUser") {
            $active7 = "active";
        }

        if ($setpage == "ViewAllUsers") {
            $active8 = "active";
        }

        if ($setpage == "AddAnnouncement") {
            $active9 = "active";
        }


        if ($setpage == "Reports") {
            $active11 = "active";
        }

        if ($setpage == "Items") {
            $active17_items = "active";
        }
    }
    ?>



    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="dist/img/user1.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">

                    <?php
                    $stmt = $db->prepare("SELECT id, firstname, lastname FROM `cp_users` WHERE id= {$_SESSION['user_id']}");
                    $stmt->bind_result($id, $FirstName, $LastName);
                    $stmt->execute();
                    while ($stmt->fetch()) {
                        
                    }
                    ?>
                    <p><?php echo $FirstName . " " . $LastName; ?></p>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <li class="treeview">
                    <a href="dash.php">
                        <i class="glyphicon glyphicon-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>


                <li style="<?php echo $style_pid_1111; ?>"  class="treeview <?php echo $active1; ?>">
                    <a href="index.php?page=Customers&PageNo=1">
                        <i class="glyphicon glyphicon-user" <?php echo $active1; ?>"></i>
                        <span>Customers</span>

                    </a>

                </li>

                <li style="<?php echo $style_pid_1112; ?> " class="treeview <?php echo $active17_items; ?>">
                    <a href="index.php?page=Items&PageNo=1">
                        <i class="glyphicon glyphicon-th-large" <?php echo $active17_items; ?>"></i>
                        <span>Items</span>

                    </a>

                </li>


                <li style="<?php echo $style_pid_1113; ?> " class="treeview <?php echo $active3 ?>">
                    <a href="index.php?page=Rep&PageNo=1">
                        <i class="glyphicon glyphicon-apple <?php echo $active3; ?>"></i>
                        <span>Sales Reps</span>

                    </a>
                </li>

                <li style="<?php echo $style_pid_1114; ?> " class="treeview <?php echo $active5 ?>">
                    <a href="index.php?page=Roots&PageNo=1">
                        <i class="glyphicon glyphicon-road <?php echo $active5; ?>"></i>
                        <span>Roots</span>

                    </a>
                </li>

                <li class="treeview <?php echo $active4; ?>">
                    <a href="index.php?page=Invoice&PageNo=1">
                        <i class="glyphicon glyphicon-list-alt <?php echo $active4; ?>"></i>
                        <span>Invoices</span>

                    </a>
                </li>


                <li style="<?php echo $style_pid_1122; ?> " class="<?php echo $active11 ?>">
                    <a href="index.php?page=Reports">
                        <i class="glyphicon glyphicon-stats"></i> <span>Reports</span>
                    </a>
                </li>


                <li style="<?php echo $style_pid_1124; ?> " class="treeview <?php echo $active7 . $active8; ?>">
                    <a href="#">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <span>Users</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo $active7; ?>"><a href="index.php?page=AddUser"><i class="glyphicon glyphicon-forward"></i>Add User</a></li>
                        <li class="<?php echo $active8; ?>"><a href="index.php?page=ViewAllUsers&PageNo=1"><i class="glyphicon glyphicon-forward"></i>View All Users</a></li>
                    </ul>
                </li>

                <li>
                    <a href="logout.php">
                        <i class="glyphicon glyphicon-off"></i> <span>Sign Out</span>
                    </a>
                </li>

        </section>

        <!-- /.sidebar -->
    </aside>
    <?php
    // If session isn't meet, user will redirect to login page
} else {
    header('Location: login.php');
}
?>