<?
require 'inc/inc.funcs.php';
$db = new db(); //new database connection
session_start();
if ($_SESSION['log'] <> 1) { header('location: login.php'); exit; }
$token = new token();
$user = $_SESSION['user'];

// get unread notifications
$notifications = $db->select('spGetRecentNotifications');

/*print_r($user);
exit;*/
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">

    <link href='assets/vendor/full-calendar/css/fullcalendar.css' rel='stylesheet' />
    <link href='assets/vendor/full-calendar/css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <? incFavIcon(); ?>
    <title>JRV - Admin</title>
</head>

<body>

<!--prevent CSRF-->
<? $token->field(); ?>
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-main-wrapper">
    <!-- ============================================================== -->
    <!-- navbar -->
    <!-- ============================================================== -->
    <div class="dashboard-header">
        <nav class="navbar navbar-expand-lg bg-white fixed-top">
            <a class="navbar-brand" href="index.php">Jake Russell Valet</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-right-top">
                    <li class="nav-item dropdown notification">
                        <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                        <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                            <li>
                                <div class="notification-title"> Notification</div>
                                <!--notification panel-->
                                <div class="notification-list">
                                    <div class="list-group">
                                        <?
                                        // loop through notifications displaying the message and date since
                                        $x = 1;
                                        foreach ($notifications as $n) {
                                        ?>
                                            <a href="#" class="list-group-item list-group-item-action<? if ($x == 1 ) { echo ' active'; $x = 0; } ?>">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/notification.png" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><?=$n['message'] ?>
                                                        <div class="notification-date"><?=Since(time()-$n['date'] , $n['date']) ?></div>
                                                    </div>
                                                </div>
                                            </a>
                                        <?
                                        }
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="list-footer"> <a href="#">View all notifications</a></div>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown nav-user">
                        <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/person-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name"><?=$user->fullName ?></h5>
                                <span class="status"></span><span class="ml-2">Available</span>
                            </div>
                            <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                            <a class="dropdown-item" href="do.php?z=doLogout"><i class="fas fa-power-off mr-2"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!--left sidebar-->
    <div class="nav-left-sidebar sidebar-dark">
        <div class="menu-list">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-divider">
                            Menu
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link active" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fa fa-fw fa-calendar"></i>Calendar <span class="badge badge-success">6</span></a>
                            <div id="submenu-1" class="collapse submenu show" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?z=edit-calendar">Set Availability</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?z=check-bookings">Check Bookings</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link active" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fa fa-fw far fa-sticky-note"></i>Portfolio <span class="badge badge-success">6</span></a>
                            <div id="submenu-4" class="collapse submenu show" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?z=add-new-portfolio">Add New</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?z=portfolio">View Portfolio Items</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link active" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fa fa-fw fas fa-shopping-basket"></i>Shop <span class="badge badge-success">6</span></a>
                            <div id="submenu-3" class="collapse submenu show" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Edit Items</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">View Orders</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link active" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fas fa-cog"></i>Site Settings <span class="badge badge-success">6</span></a>
                            <div id="submenu-2" class="collapse submenu show" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?z=site-settings">Site Settings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?z=change-password">Change Password</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?z=statistics">Statistics</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end left sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <!-- Header -->
            <?
            switch ($_GET['z']) {

                default:
                    /*print_r($_SESSION);
                    exit;*/
                ?>
                    <div class="jumbotron bg-primary-light">
                        <h2>Admins Only</h2>
                        <div class="card">
                            <div class="card-body text-black-50">Welcome <?=split_name($user->fullName)['first_name'] ?>, last login: <?=date('d-m-Y @ H:i', $user->lastLogin) ?></div>
                        </div>
                    </div>
                <?
                    break;

                case 'check-bookings':

                    $bookings = $db->select('spGetAllBookings');

                    ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Check Bookings</h2>
                                <p class="pageheader-text"></p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Portfolio</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Check Bookings</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <!-- portfolio table -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Booked Appointments</h5>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Number</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">date</th>
                                                <th scope="col" class="text-center">Confirmed</th>
                                                <th scope="col" class="text-center">Sent Reminder</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                            foreach ($bookings as $i) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?=$i['name'] ?></th>
                                                    <td><?=$i['number'] ?></td>
                                                    <td><?=$i['email'] ?></td>
                                                    <td><?=$i['date'] ?></td>
                                                    <!--<td style="background-color: <?/* echo ($i['isConfirmed'] == 1) ? 'green' : 'red' */?>;">&nbsp;</td>-->
                                                    <td><img style="height: 20px; width: 20px;" class="mx-auto d-block" src="img/<? echo ($i['isConfirmed'] == 1) ? 'tick' : 'cross' ?>.png" class="rounded" alt="Booking Confirmation" /></td>
                                                    <td><img style="height: 20px; width: 20px;" class="mx-auto d-block" src="img/<? echo ($i['isSentSMSReminder'] == 1) ? 'tick' : 'cross' ?>.png" class="rounded" alt="Sent Confirmation" /></td>
                                                </tr>
                                                <?
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                    break;

                case 'portfolio':

                    $items = $db->select('spGetAllPortfolioItems');

                    ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Edit Portfolio Items</h2>
                                <p class="pageheader-text"></p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Portfolio</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Edit Portfolio Items</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <!-- portfolio table -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Portfolio Items</h5>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Caption</th>
                                                <th scope="col">Images</th>
                                                <th scope="col">Edit</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                foreach ($items as $i) {
                                                ?>
                                                    <tr<? if ($i['isDeleted'] == 1) { ?> bgcolor="silver"<? } ?>>
                                                        <th scope="row"><?=$i['id'] ?></th>
                                                        <td><?=$i['name'] ?></td>
                                                        <td><?=date("d-m-Y", $i['date']) ?></td>
                                                        <td><?=$i['title'] ?></td>
                                                        <td>
                                                            <img style="height: 60px; width: 60px;" class="img-thumbnail" src="../img/portfolio/<?=$i['thumbnail'] ?>" alt="Thumbnail">
                                                            <img style="height: 60px; width: 60px;" class="img-thumbnail" src="../img/portfolio/<?=$i['mainImage'] ?>" alt="Thumbnail">
                                                        </td>
                                                        <td>
                                                            <?
                                                            if ($i['isDeleted'] == 0) {
                                                                ?>
                                                                <button type="button" data-portfolioid="<?= $i['id'] ?>" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                                                                    edit
                                                                </button> |
                                                                <?
                                                            }
                                                            ?>
                                                            <button type="button" id="toggle-delete-portfolio" data-portfolioid="<?=$i['id'] ?>" class="btn <? echo ($i['isDeleted'] == 0) ? 'btn-danger' : 'btn-success' ?> btn-sm">
                                                                X
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                    break;

                case 'add-new-portfolio':
                    ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Add New Portfolio Item</h2>
                                <p class="pageheader-text"></p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Portfolio</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Add New Portfolio Item</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content -->
                    <form action="do.php?z=AdminAddNewPortfolioItem" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <h3 class="card-header">Text Details</h3>
                        <!--<-->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="custName" class="col-form-label">Name</label>
                                    <input id="custName" name="custName" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="caption" class="col-form-label">Portfolio Caption</label>
                                    <input id="caption" name="caption" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="body">Portfolio Body</label>
                                    <textarea class="form-control" id="body" name="body" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="card-body border-top">
                                <h3>Images</h3>
                                <div class="custom-file mb-3">
                                    <input type="file" name="file" class="custom-file-input" id="file" />
                                    <label class="custom-file-label" for="file">Thumbnail</label>
                                </div>
                                <div class="custom-file mb-3">
                                    <input type="file" name="file2" class="custom-file-input" id="file2" />
                                    <label class="custom-file-label" for="file2">Main Image</label>
                                </div>
                            </div>
                            <div class="card-body border-top">
                                <button type="submit" id="btn-do-login" class="btn btn-primary btn-lg float-right">Add New Item</button>
                            </div>
                        <!---->
                    </div>
                </form>
                    <?
                    break;

                case 'change-password':
                    ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Change Admin Password</h2>
                                <p class="pageheader-text"></p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Settings</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <!--<h3 class="text-center">Change the password here!!</h3>-->
                            <div class="splash-container">
                                <div class="card">
                                    <div class="card-header text-center"><span class="splash-description">Change Password</span></div>
                                    <div class="card-body">
                                        <form>
                                            <p>Please use a secure password and do not share with anyone else!</p>
                                            <div class="form-group">
                                                <input class="form-control form-control-lg" type="password" id="currentPass" name="currentPass" required="" placeholder="Current Password" autocomplete="off">
                                                <hr />
                                                <input class="form-control form-control-lg" type="password" id="newPass1" name="newPass1" required="" placeholder="New Password" autocomplete="off">
                                                <input class="form-control form-control-lg" type="password" id="newPass2" name="newPass2" required="" placeholder="Confirm" autocomplete="off">
                                            </div>
                                            <div class="form-group pt-1"><a class="btn btn-block btn-primary btn-xl" id="btn-change-pass" href="#">Change Password</a></div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <span id="feedback"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                    break;

                case 'edit-calendar':
                    ?>
                    <div class="container-fluid  dashboard-content">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="page-header">
                                    <h2 class="pageheader-title">Calendar </h2>
                                    <p class="pageheader-text"></p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Pages</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Calendar</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                    <!--<div id='external-events'>-->
                                        <?
                                        $shifts = $db->select('spGetAvailableShifts');
                                        foreach ($shifts as $s) {
                                        ?>
                                            <div class="fc-event mr-2" style="float: left !important; width: 100px; cursor: move; background-color: #2f8aca"><?=$s['shift'] ?></div>
                                        <?
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div id='calendar1'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                    break;

                case 'site-settings':
                ?>
                    <div class="container-fluid  dashboard-content">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="page-header">
                                    <h2 class="pageheader-title">Site Settings</h2>
                                    <p class="pageheader-text"></p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Pages</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Site Settings</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?
                            $email = $db->select('spGetSettingByCode', array('CEML'));
                            $em = $email[0]['settingValue'];

                            $about1 = $db->select('spGetSettingByCode', array('ABT1'));
                            $a1 = $about1[0]['settingValue'];

                            $about2 = $db->select('spGetSettingByCode', array('ABT2'));
                            $a2 = $about2[0]['settingValue'];

                            $instagram = $db->select('spGetSettingByCode', array('SMIN'));
                            $in = $instagram[0]['settingValue'];

                            $twitter = $db->select('spGetSettingByCode', array('SMTW'));
                            $tw = $twitter[0]['settingValue'];

                            $linkedin = $db->select('spGetSettingByCode', array('SMLI'));
                            $li = $linkedin[0]['settingValue'];

                            $facebook = $db->select('spGetSettingByCode', array('SMFB'));
                            $fb = $facebook[0]['settingValue'];

                            $other = $db->select('spGetSettingByCode', array('SMOT'));
                            $ot = $other[0]['settingValue'];

                            $othericon = $db->select('spGetSettingByCode', array('SMOI'));
                            $oti = $othericon[0]['settingValue'];

                            /////////////////////////////////////////////

                            $gae = $db->select('spGetSettingByCode', array('GAEM'))[0]['settingValue'];
                            $gp = $db->select('spGetSettingByCode', array('GAPA'))[0]['settingValue'];
                            $gid = $db->select('spGetSettingByCode', array('GAID'))[0]['settingValue'];

                            $othl = $db->select('spGetSettingByCode', array('OTHL'))[0]['settingValue'];
                            $otht = $db->select('spGetSettingByCode', array('OTHT'))[0]['settingValue'];
                            ?>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                <?
                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == 0) {
                                        echo '<div class="card"><span class="bg-success-light text-center">Setting updated successfully.</span></div>';
                                    }
                                    else {
                                        echo '<div class="card"><span style="color: red;" class="text-center">There was an error saving the setting.  Please try again.</span></div>';
                                    }
                                }
                                ?>
                                <form action="do.php?z=SaveSetting&setting=contact" method="post">
                                    <div class="card">
                                        <h3 class="card-header">Contact Details</h3>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="edit-settings-email" class="col-form-label">Contact Email Address</label>
                                                <input id="edit-settings-email" name="CEML" type="text" class="form-control" value="<?=$em ?>" />
                                            </div>
                                            <input type="submit" class="btn bg-primary btn-sm btn-outline-light" value="Save" />
                                        </div>
                                    </div>
                                </form>
                                <form action="do.php?z=SaveSetting&setting=about" method="post">
                                    <div class="card">
                                        <h3 class="card-header">About Me Texts</h3>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="edit-settings-about1" class="col-form-label">About Text #1</label>
                                                <input id="edit-settings-about1" name="ABT1" type="text" class="form-control" value="<?=$a1 ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-settings-about2" class="col-form-label">About Text #2</label>
                                                <input id="edit-settings-about2" name="ABT2" type="text" class="form-control" value="<?=$a2 ?>" />
                                            </div>
                                            <input type="submit" class="btn bg-primary btn-sm btn-outline-light" value="Save" />
                                        </div>
                                    </div>
                                </form>
                                <form action="do.php?z=SaveSetting&setting=socialmedia" method="post">
                                    <div class="card">
                                        <h3 class="card-header">Social Media</h3>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="edit-settings-instagram" class="col-form-label">Instagram</label>
                                                <input id="edit-settings-instagram" name="SMIN" type="text" class="form-control" value="<?=$in ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-settings-twitter" class="col-form-label">Twitter</label>
                                                <input id="edit-settings-twitter" name="SMTW" type="text" class="form-control" value="<?=$tw ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-settings-facebook" class="col-form-label">Facebook</label>
                                                <input id="edit-settings-facebook" name="SMFB" type="text" class="form-control" value="<?=$fb ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-settings-linkedin" class="col-form-label">Linked In</label>
                                                <input id="edit-settings-linkedin" name="SMLI" type="text" class="form-control" value="<?=$li ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-settings-other" class="col-form-label">Other</label>
                                                <input id="edit-settings-other" name="SMOT" type="text" class="form-control" value="<?=$ot ?>" />
                                                <input id="edit-settings-otherlogo" name="SMOI" type="text" class="form-control mt-1" value="<?=$oti ?>" placeholder="Font Awesome Icon (eg: fas fa-address-card)" />
                                            </div>
                                            <input type="submit" class="btn bg-primary btn-sm btn-outline-light" value="Save" />
                                        </div>
                                    </div>
                                </form>
                                <form action="do.php?z=SaveSetting&setting=google" method="post">
                                    <div class="card">
                                        <h3 class="card-header">Google Analytics</h3>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="edit-settings-googleEmail" class="col-form-label">Google Email</label>
                                                <input id="edit-settings-googleEmail" name="GAEM" type="text" class="form-control" value="<?=$gae ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-settings-googlepass" class="col-form-label">Google Pass</label>
                                                <input id="edit-settings-googlepass" name="GAPA" type="password" class="form-control" value="<?=$gp ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-settings-googleId" class="col-form-label">Site UIX</label>
                                                <input id="edit-settings-googleId" name="GAID" type="text" class="form-control" value="<?=$gid ?>" />
                                            </div>
                                            <input type="submit" class="btn bg-primary btn-sm btn-outline-light" value="Save" />
                                        </div>
                                    </div>
                                </form>
                                <form action="do.php?z=SaveSetting&setting=other" method="post">
                                    <div class="card">
                                        <h3 class="card-header">Other Link (bottom right index page)</h3>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="edit-settings-othertitle" class="col-form-label">Other Text Title</label>
                                                <input id="edit-settings-othertitle" name="OTHL" type="text" class="form-control" value="<?=$othl ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-settings-othertext" class="col-form-label">Other Text Text</label>
                                                <input id="edit-settings-othertext" name="OTHT" type="text" class="form-control" value="<?=$otht ?>" />
                                            </div>
                                            <input type="submit" class="btn bg-primary btn-sm btn-outline-light" value="Save" />
                                        </div>
                                    </div>
                                </form>
                                <div class="card">
                                    <h3 class="card-header">Default Shifts</h3>
                                    <div class="card-body">
                                        <span>text</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?
                    break;

                case 'statistics':
                    ?>
                    <div class="card">
                        <div class="card-body">To view statistics, login to Google Analytics</div>
                    </div>
                    <?
                    break;
            }
            ?>
        </div>
        <div class="footer fixed-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        Copyright © 2019 Jake Russell Valet. All rights reserved. Dashboard by <a href="http://www.zinqcreative.co.uk">zinQ</a>.
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="javascript: void(0);">About</a>
                            <a href="javascript: void(0);">Support</a>
                            <a href="javascript: void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end main wrapper  -->
<!-- ============================================================== -->


<!-- Modal -->
<div class="modal fade bd-example-modal-sm" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Portfolio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <input type="hidden" id="portfolio-id" />
                    <h3 class="card-header">Text Details</h3>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="custName" class="col-form-label">Name</label>
                            <input id="edit-portfolio-custName" name="custName" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="caption" class="col-form-label">Portfolio Caption</label>
                            <input id="edit-portfolio-caption" name="caption" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="body">Portfolio Body</label>
                            <textarea class="form-control" id="edit-portfolio-body" name="body" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h3>Images</h3>
                        <div class="custom-file mb-3">
                            <input type="file" name="file" class="custom-file-input" id="file" />
                            <label class="custom-file-label" for="file">Thumbnail</label>
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" name="file2" class="custom-file-input" id="file2" />
                            <label class="custom-file-label" for="file2">Main Image</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="edit-portfolio-save" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- jquery 3.3.1 -->
<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<!-- bootstap bundle js -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<!-- slimscroll js -->
<script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<!-- main js -->
<script src="assets/libs/js/main-js.js"></script>
<script src="assets/libs/js/custom.js"></script>

<script src='assets/vendor/full-calendar/js/moment.min.js'></script>
<script src='assets/vendor/full-calendar/js/fullcalendar.js'></script>
<script src='assets/vendor/full-calendar/js/jquery-ui.min.js'></script>
<script src='assets/vendor/full-calendar/js/calendar.js'></script>
<script src="assets/libs/js/main-js.js"></script>

</body>

</html>