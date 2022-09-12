<?php
session_start();
require_once 'agence-db.php';
$cuser=new Agence();

//Session Agence
if(!isset($_SESSION['user'])){
    header('location:../utilisateur.php');
    die;
}
    $clogin=$_SESSION['user'];
        
    $data=$cuser->currentUser($clogin);

    $cid=$data['id'];
    $crole=$data['idrole'];
    $croles=$data['nomRole'];
    $cid_ag=$data['id_ag'];
    $cagence=$data['nomAg'];
    $ccodeagence=$data['codAg'];
    if($crole==1){
        $crole='Operateur';
    }
    else if($crole==2){
        $crole='Caissier 1';
    }
    else{
        $crole='Caissier 2';
    }
    
?>