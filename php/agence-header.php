<?php
    require_once 'session.php';
?>
<!DOCTYPE html>
<html lang="fr">
    
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Ir Donatien">
        <meta http-equiv="x-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width-device-width, initial-scale=1, shrink-to-fit=no">
        <title>ADTFCLAUDE|<?=ucfirst(basename($_SERVER['PHP_SELF'],'.php')); ?></title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
        <style type="text/css">
            @import url("https://fonts.googleapis.com/css?family=Maven+Pro:400,500,600,700,800,900&display=swap");
            *{
                font-family:'Maven Pro', sans-serif;
                font-size:18px;
            }
        </style>
    </head>
    <body class="bg-white">

    <nav class="navbar navbar-expand-md bg-info navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="agences.php"><strong>ADFTCLAUDE</strong></a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                
                <li class="nav-item">
                    <a class="nav-link <?=(basename($_SERVER['PHP_SELF'])=="agences.php")?"active":"";?>" href="agences.php"><i class="fa fa-home"></i>&nbsp;Accueil</a>
                </li>
                <?php if($crole=='Operateur' || $crole=='Caissier 1'):?>     
                <li class="nav-item">
                    <a class="nav-link <?=(basename($_SERVER['PHP_SELF'])=="envoie.php")?"active":"";?>" href="envoie.php"><i class="fa fa-handshake"></i>&nbsp;Envoie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=(basename($_SERVER['PHP_SELF'])=="client.php")?"active":"";?>" href="client.php"><i class="fa fa-male"></i>&nbsp;Client</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=(basename($_SERVER['PHP_SELF'])=="beneficiaire.php")?"active":"";?>" href="beneficiaire.php"><i class="fas fa-hiking"></i>&nbsp;Bénéficiaire</a>
                </li>
                <?php endif;?>
                <?php if($crole=='Operateur' || $crole=='Caissier 2'):?>     
                <li class="nav-item">
                    <a class="nav-link <?=(basename($_SERVER['PHP_SELF'])=="reception.php")?"active":"";?>" href="reception.php"><i class="fas fa-business-time"></i>&nbsp;Réception</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=(basename($_SERVER['PHP_SELF'])=="bon_retrait.php")?"active":"";?>" href="bon_retrait.php"><i class="fab fa-buffer"></i>&nbsp;Bon Retrait</a>
                </li>
                <?php endif;?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-cog"></i>&nbsp;Bienvenu(e)!&nbsp;<?=$clogin;?>
                    </a>
                    <div class="dropdown-menu">
                        <a href="../logout.php" class="dropdown-item"> <i class="fas fa-sign-out-alt"></i>&nbsp;Déconnexion</a>
                    </div>
                </li>
                </ul>
            </div> 
        </nav>