<?php
    session_start();
    unset($_POST['username']);
    unset($_POST['user']);
    header('location:index.php');
?>