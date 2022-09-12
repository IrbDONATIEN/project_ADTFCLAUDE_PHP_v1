<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Donatien">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <?php
        $title=basename($_SERVER['PHP_SELF'], '.php');
        $title=explode('-',$title);
        $title=ucfirst($title[1]);
    ?>
    <title><?= $title; ?>|Espace Admin</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js" defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#open-nav").click(function(){
            $(".admin-nav").toggleClass('animate');
        });
    });
 </script>
    <style type="text/css">
        .admin-nav{
            width:220px;
            min-height:100vh;
            overflow:hidden;
            background-color:#477674;
            transition:0.3s all ease-in-out;
        }
        .admin-link{
            background-color:#477674;
        }
        .admin-link:hover, .nav-active{
            background-color:#222579;
            text-decoration:none;
        }
        .animate{
            width:0;
            transition: 0.3s all ease-in-out;
        }
    </style>
</head>
<body>
     <div class="container-fluid">

        <div class="row">

            <div class="admin-nav p-0">
                <h4 class="text-light text-center p-2">Administration</h4>
                <div class="list-group list-group-flush">
                    <a href="admin-dashboard.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-dashboard.php')? "nav-active":"";?>"> <i class="fas fa-home"></i>&nbsp;&nbsp;Tableau de Bord</a>
                    <a href="admin-agences.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-agences.php')? "nav-active":"";?>"> <i class="fa fa-building"></i>&nbsp;&nbsp;Agence</a>
                    <a href="admin-guichets.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-guichets.php')? "nav-active":"";?>"> <i class="fa fa-handshake"></i>&nbsp;&nbsp;Guichet</a>
                    <a href="admin-responsables.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-responsables.php')? "nav-active":"";?>"> <i class="fas fa-user"></i>&nbsp;&nbsp;Responsable</a>
                    <a href="admin-agences_supprimer.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-agences_supprimer.php')? "nav-active":"";?>"> <i class="fas fa-fire"></i>&nbsp;&nbsp;Agence Supprimer</a>
                    <a href="admin-notification.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-notification.php')? "nav-active":"";?>"> <i class="fas fa-bell"></i>&nbsp;&nbsp;Notification <span id="checkNotification"></span></a>
                    <a href="admin-horaires.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-horaires.php')? "nav-active":"";?>"> <i class="fa fa-calendar-minus"></i>&nbsp;&nbsp;Horaire</a>
                    <a href="admin-provinces.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-provinces.php')? "nav-active":"";?>"> <i class="fas fa-pen"></i>&nbsp;&nbsp;Province</a>
                    <a href="admin-roles.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-roles.php')? "nav-active":"";?>"> <i class="fas fa-book fa-fw"></i>&nbsp;&nbsp;Roles</a>


                    <a href="#" class="list-group-item text-light admin-link"> <i class="fas fa-id-card"></i>&nbsp;&nbsp;Profile</a>
                    <a href="#" class="list-group-item text-light admin-link"> <i class="fas fa-cog"></i>&nbsp;&nbsp;Setting</a>
                </div>
            </div>

            <div class="col">
                <div class="row">
                    <div class="col-lg-12 bg-info pt-2 justify-content-between d-flex">
                        <a href="#" class="text-white" id="open-nav"><h3><i class="fas fa-bars"></i></h3></a>
                        <h4 class="text-light"><?=$title;?></h4>

                        <a href="logout.php" class="text-light mt-1"><i class="fas fa-sign-out-alt"></i>&nbsp;Déconnexion</a>
                    </div>
                </div>