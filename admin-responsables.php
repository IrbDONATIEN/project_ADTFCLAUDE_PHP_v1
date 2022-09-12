<?php
    require_once 'php/admin-header.php';
    require_once 'php/connexion.php';

    //Création matricule
    $mois = (int)(date("m"));
    $sec1 = date("s");
    $sec2 = (int)(date("s"));
    $code1 = $sec2 + $sec1 + $mois+$sec2;
    $code2 = $code1 + $sec2 + $mois+$sec1;  
    $codemat = $code1.''.$code2 ;

?>
        <!--Début de la section 1-->
        <div class="row justify-content-center">
           <div class="col-lg-12">
                <div class="card rounded-0 mt-3 border-primary">
                    <!--Début d'onglets-->
                    <div class="card-header border-primary"> 
                        <ul class="nav nav-tabs card-header-tabs">
                            <i class="fas fa-user"></i>&nbsp;&nbsp;
                            <li class="nav-item">
                                <a href="#ajoutresponsable" class="nav-link active font-weight-bold" data-toggle="tab">Nouveau Responsable</a>
                            </li>
                            <li class="nav-item">
                                <a href="#responsable" class="nav-link font-weight-bold" data-toggle="tab">Liste des Responsables </a>
                            </li>
                            <li class="nav-item">
                                <a href="#deletedresponsable" class="nav-link  font-weight-bold" data-toggle="tab"><i class="fas fa-user-slash"></i>&nbsp;&nbsp;Liste des Responsables Supprimés</a>
                            </li>
                        </ul>
                    </div>
                    <!--Fin d'onglets-->

                    <!--Début du corps d'onglets-->
                    <div class="card-body">
                        <div class="tab-content">

                            <!--Début du premier corps d'onglet-->
                            <div class="tab-pane container active" id="ajoutresponsable">
                                <div class="card-deck">
                                    <div class="card border-primary align-self-center">
                                    <form action="#" method="post" class="px-3 mt-2" id="register-form">
                                        <div class="form-group">
                                            <input type="hidden" name="matricule" id="matricule" value="<?php echo $codemat;?>">
                                            <label for="nom" class="m-1">Nom Responsable:</label>
                                            <input type="text" name="nom" id="nom" class="form-control rounded-0" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="postnom" class="m-1">Post-nom Responsable :</label>
                                            <input type="text" name="postnom" id="postnom" class="form-control rounded-0" required >
                                        </div>
                                        <div class="form-group">
                                            <label for="prenom" class="m-1">Prénom Responsable:</label>
                                            <input type="text" name="prenom" id="prenom" class="form-control rounded-0" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="adresse" class="m-2">Adresse Responsable:</label>
                                            <textarea name="adresse" id="adresse" cols="3" rows="2" class="form-control rounded-0" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="telephone" class="m-2">Téléphone Responsable:</label>
                                            <input type="text" name="telephone" id="telephone" class="form-control rounded-0" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="idrole" class="m-2">Rôle Responsable:</label>
                                            <select name="idrole" id="idrole" class="form-control" required>
                                                <?php $req=$db->query("SELECT * FROM roles");
                                                while ($tab=$req->fetch()){?>
                                                <option value="<?php echo $tab['id'];?>"><?php echo $tab['nomRole'];?></option>
                                                <?php
                                                   }
                                                ?>
                                            </select>
                                            
                                       </div>
                                       <div class="form-group">
                                           <input type="reset" value="Annuler Responsable" class="btn btn-danger btn-lg btn-block">
                                        </div>
                                    </div>
                                    <div class="card border-primary">
                                        <div class="form-group">
                                            <label for="email" class="m-2">E-mail Responsable:</label>
                                            <input type="email" name="email" id="email" class="form-control rounded-0" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="sexe" class="m-2">Sexe:</label>
                                            <select name="sexe" id="sexe" class="form-control rounded-0">
                                                <option value="" disabled>Select</option>
                                                <option value="Masculin" required>Masculin</option>
                                                <option value="Feminin" required>Feminin</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="loginU" class="m-2">Login:</label>
                                            <input type="text" name="loginU" id="loginU" class="form-control rounded-0" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="passwordU" class="m-2">Mot de passe:</label>
                                            <input type="password" name="passwordU" id="passwordU" class="form-control rounded-0" required minLength="5">
                                        </div>
                                        <div class="form-group">
                                            <label for="cpasswordU" class="m-2">Confirmer mot de passe:</label>
                                            <input type="password" name="cpasswordU" id="cpasswordU" class="form-control rounded-0" required minLength="5">
                                        </div>
                                           <div id="passError" class="text-danger font-weight-bold"></div>
                                           <div class="form-group">
                                            <label for="id_ag" class="m-2">Sélectionner l'agence:</label>
                                            <select name="id_ag" id="id_ag" class="form-control" required>
                                                <?php $req=$db->query("SELECT * FROM agence");
                                                while ($tab=$req->fetch()){?>
                                                <option value="<?php echo $tab['idag'];?>"><?php echo $tab['nomAg'];?></option>
                                                <?php
                                                   }
                                                ?>
                                            </select>
                                       </div>
                                        <div id="regAlert"></div>
                                        <div class="form-group">
                                           <input type="submit" value="Confirmer Responsable" id="register-btn" class="btn btn-primary btn-lg btn-block myBtn">
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <!--Fin du premier corps d'onglet-->

                            <!--Début de deuxieme corps d'onglet-->
                            <div class="tab-pane container fade " id="responsable">
                                <div class="card-deck">
                                    <div class="table-responsive" id="showAllResponsables">
                                        <p class="text-center align-self-center lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>&nbsp;&nbsp;Veuillez patienter...</p>
                                    </div>
                                </div>
                            </div>
                            <!--Fin de deuxieme corps d'onglet-->

                            <!--Début du troisieme corps d'onglet-->
                            <div class="tab-pane container fade" id="deletedresponsable">
                                <div class="card-deck">
                                    <div class="table-responsive" id="showAllDeletedResponsables">
                                        <p class="text-center align-self-center lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>&nbsp;&nbsp;Veuillez patienter...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fin de troisieme corps d'onglet-->
                    </div>
                    <!--Fin du corps d'onglets-->

                </div>
           </div>
        </div>
        <!--Fin de la section 1-->

       

        <!--Footer Area-->
            </div>
        </div>
     </div>
     <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
     <script type="text/javascript">
        $(document).ready(function(){

            //Check Notification
            checkNotification();

            function checkNotification(){
                $.ajax({
                    url:'php/admin-action.php',
                    method:'post',
                    data:{action:'checkNotification'},
                    success:function(response){
                        $("#checkNotification").html(response);
                    }
                });
            }

            //Affichage des responsables
            fetchAllResponsables();

            function fetchAllResponsables(){
                $.ajax({
                    url:'php/admin-action.php',
                    method: 'post',
                    data:{action: 'fetchAllResponsables'},
                    success:function(response){
                        $("#showAllResponsables").html(response);
                        $("table").DataTable({
                            order:[0, 'desc']
                        });
                    }
                });
            }

            //Afficher le responsable dans les détails Demande Ajax
            $("body").on("click", ".infoResponsablesBtn", function(e){
                e.preventDefault();

                inforespo_matr=$(this).attr('matricule');

                $.ajax({
                    url:'php/admin-action.php',
                    method:'post',
                    data:{inforespo_matr:inforespo_matr},
                    success:function(response){
                        data=JSON.parse(response);
                        Swal.fire({
                            title:'<strong>Responsable : Matricule('+data.matricule+')</strong>',
                            type:'info',
                            html:'<b>Nom :</b>'+data.nom+'</br></br><b>Post-nom :</b>'+data.postnom+'</br></br><b>Prénom :</b>'+data.prenom+'</br></br><b>Genre :</b>'+data.sexe+'</br></br><b>E-Mail :</b>'+data.email+'</br></br><b>Adresse :</b>'+data.adresse+'</br></br><b>Téléphone :</b>'+data.telephone+'</br></br><b>Date Création :</b>'+data.dateCreation+'</br></br><b>Rôle:</b>'+data.nomRole,
                            showCloseButton:true,
                        });
                    }
                });
            });

            //Delete An Responsable Ajax Request
            $("body").on("click", ".deleteResponsablesIcon", function(e){
                e.preventDefault();
                del_matr=$(this).attr('matricule');

                Swal.fire({
                    title:'Etes-vous sûr de supprimer ?',
                    text: "Vous ne pourrez pas revenir en arrière !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-le !'
                }).then((result)=>{
                    if(result.value){
                        $.ajax({
                            url:'php/admin-action.php',
                            method: 'post',
                            data:{del_matr:del_matr},
                            success:function(response){
                                Swal.fire(
                                    'Supprimé Responsable !',
                                    'Responsable supprimé avec succès!',
                                    'success'
                                )

                                //Affichage des responsables
                                fetchAllResponsables();

                                //Affichage des responsables supprimés
                                fetchAllDeletedResponsables();
                            }
                        });
                    }
                })
            });

            //Affichage des responsables supprimés
            fetchAllDeletedResponsables();

            function fetchAllDeletedResponsables(){
                $.ajax({
                    url:'php/admin-action.php',
                    method: 'post',
                    data:{action: 'fetchAllDeletedResponsables'},
                    success:function(response){
                        $("#showAllDeletedResponsables").html(response);
                        $("table").DataTable({
                            order:[0, 'desc']
                        });
                    }
                });
            }

            //Restore Deleted Responsable Ajax Request
            $("body").on("click", ".restoreResponsablesIcon", function(e){
                e.preventDefault();
                resp_matr=$(this).attr('matricule');

                Swal.fire({
                    title:'Etes-vous sûr de restaurer ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, restaurez-le !'
                }).then((result)=>{
                    if(result.value){
                        $.ajax({
                            url:'php/admin-action.php',
                            method: 'post',
                            data:{resp_matr:resp_matr},
                            success:function(response){
                                Swal.fire(
                                    'Responsable Restauré!',
                                    'Responsable restauré avec succès!',
                                    'success'
                                )
                                //Affichage des responsables supprimés
                                fetchAllDeletedResponsables();
                                
                                //Affichage des responsables
                                fetchAllResponsables();

                            }
                        });
                    }
                })
            });
            

            // Ajouter un nouveau Responsable avec la requête d'ajax
            $("#register-btn").click(function(e){
                if($("#register-form")[0].checkValidity()){
                    e.preventDefault();
                $("#register-btn").val('Veuillez patienter...');
                    if($("#passwordU").val() != $("#cpasswordU").val()){
                        $("#passError").text('* Mot de passe non prise en charge !');
                        $("#register-btn").val('Confirmer Responsable');
                    }
                    else{
                        $("#passError").text('');

                        $.ajax({
                            url:'php/admin-process.php',
                            method:'post',
                            data: $("#register-form").serialize()+'&action=register',
                            success:function(response){
                                //console.log(response);
                                $("#register-btn").val('Confirmer Responsable');
                                if(response==='register'){   
                                }
                                else{
                                    $("#register-btn").val('Confirmer Responsable');
                                    $("#register-form")[0].reset();
                                    Swal.fire({
                                      title:'Responsable Ajouté avec succès!',
                                      type:'success'
                                    });
                                    //Affichage des responsables
                                    fetchAllResponsables();
                                    $("#regAlert").html(response);
                                }
                            }
                        });

                    }
                }
            });

            


        });
     </script>
</body>
</html>