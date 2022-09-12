<?php
    session_start();
    if(isset($_POST['username'])){
        header('location:admin-dashboard.php');
        exit();
    }
    if(isset($_POST['user'])){
        header('location:agence/agences.php');
        exit();
    }
     //Nombre de visiteur
     include_once 'php/config.php';
     $db=new Database();
     $sql="UPDATE visitors SET hits=hits+1 WHERE id=0";
     $stmt=$db->conn->prepare($sql);
     $stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Setiawan">
        <meta http-equiv="x-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width-device-width, initial-scale=1, shrink-to-fit=no">
        <title>ADTFCLAUDE | Authentification</title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <style type="text/css">
            html,body{
                height:100%;
            }
        </style>
    </head>
    <body class="bg-dark">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-lg-5">
                    <div class="card border-primary shadow-lg">
                        <div class="card-header bg-primary">
                            <h3 class="m-0 text-white"><i class="fas fa-user-cog"></i>&nbsp;ADTFCLAUDE | Login </h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" class="px-3" id="admin-login-form">
                                <div id="adminLoginAlert"></div>
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-lg rounded-0" placeholder="Username" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg rounded-0" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="admin-login" class="btn btn-success btn-block btn-lg rounded-0" value="Login" id="adminLoginBtn" required>
                                </div>
                                <a href="utilisateur.php">Connexion Utilisateur</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
 <script type="text/javascript">
     $(document).ready(function(){
        $("#adminLoginBtn").click(function(e){
          if($("#admin-login-form")[0].checkValidity()){
              e.preventDefault();
              
              $(this).val('Veuillez patientier...');
              $.ajax({
                  url : 'php/admin-action.php',
                  method : 'post',
                  data : $("#admin-login-form").serialize()+'&action=adminLogin',
                  success:function(response){
                      if(response === 'admin_login'){
                          window.location = 'admin-dashboard.php';
                      }
                      else{
                          $("#adminLoginAlert").html(response);
                      }
                      $("#adminLoginBtn").val('Login');
                  }
              });
          }  
        });
     });
 </script>
</body>
</html>