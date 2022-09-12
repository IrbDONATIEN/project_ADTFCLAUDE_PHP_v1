<?php
    session_start();
    require_once 'php/connexion.php';
    if(isset($_POST['user'])){
        header('location:agence/agences.php');
        exit();
    }

    if(isset($_POST['username'])){
        header('location:admin-dashboard.php');
        exit();
    }
   
?>
<!DOCTYPE html>
<html lang="fr">
    
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Setiawan">
        <meta http-equiv="x-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width-device-width, initial-scale=1, shrink-to-fit=no">
        <title>ADTFCLAUDE | Utilisateur</title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <style type="text/css">
            html,body{
                height:100%;
            }
        </style>
    </head>
    <body class="bg-success">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-lg-5">
                    <div class="card border-primary shadow-lg">
                        <div class="card-header bg-primary">
                            <h3 class="m-0 text-white"><i class="fas fa-user"></i>&nbsp;ADTFCLAUDE|Utilisateur</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" class="px-3" id="admin-login-form">
                                <div id="adminLoginAlert"></div>
                                <div class="form-group">
                                    <input type="text" name="login" id="login" class="form-control form-control-lg rounded-0" placeholder="Login Utilisateur" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg rounded-0" placeholder="Mot de passe Utilisateur" required>
                                </div>
                                <div class="form-group">
                                    <label for="idrole">Sélectionner le rôle:</label>
                                    <select name="idrole" id="idrole" class="form-control  form-control-lg" required>
                                            <?php $req=$db->query("SELECT * FROM roles");
                                                while ($tab=$req->fetch()){?>
                                                    <option value="<?php echo $tab['id'];?>"><?php echo $tab['nomRole'];?></option>
                                            <?php
                                                }
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="admin-login" class="btn btn-dark btn-block btn-lg rounded-0" value="Login" id="adminLoginBtn" required>
                                </div>
                                <a href="index.php">Retour</a>
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
                  data : $("#admin-login-form").serialize()+'&action=agenceLogin',
                  success:function(response){
                      if(response === 'agence_login'){
                          window.location = 'agence/agences.php';
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