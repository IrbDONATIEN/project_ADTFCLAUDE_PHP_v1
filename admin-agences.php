<?php
    require_once 'php/admin-header.php';
    require_once 'php/connexion.php';

    //Création matricule
    $mois = (int)(date("m"));
    $sec1 = date("s");
    $sec2 = (int)(date("s"));
    $code1 = $sec2 + $sec1 + $mois+$sec2;
    $code2 = $code1 + $sec2 + $mois+$sec1; 
    $code="A"; 
    $codeAg =$code.$code1.''.$code2 ;
?>

         <!--Début de la section 1-->
         <div class="row justify-content-center">
           <div class="col-lg-12">
                <div class="card rounded-0 mt-3 border-primary">
                    <!--Début d'onglets-->
                    <div class="card-header border-primary"> 
                        <ul class="nav nav-tabs card-header-tabs">
                            <i class="fa fa-building"></i>&nbsp;&nbsp;
                            <li class="nav-item">
                                <a href="#ajoutagence" class="nav-link active font-weight-bold" data-toggle="tab">Nouvel Agence</a>
                            </li>
                            <li class="nav-item">
                                <a href="#agence" class="nav-link font-weight-bold" data-toggle="tab"><i class="fa fa-building"></i>&nbsp;&nbsp;Liste d'agences </a>
                            </li>
                        </ul>
                    </div>
                    <!--Fin d'onglets-->

                    <!--Début du corps d'onglets-->
                    <div class="card-body">
                        <div class="tab-content">

                            <!--Début du premier corps d'onglet-->
                            <div class="tab-pane container active" id="ajoutagence">
                                <div class="card-deck">
                                    <div class="card border-primary align-self-center">
                                    <form action="php/agence.php" method="post" class="px-3 mt-2" id="agence-form">
                                        <div class="form-group">
                                            <input type="hidden" name="codAg" id="codAg" value="<?php echo $codeAg;?>">
                                            <label for="nomAg" class="m-1">Nom Agence :</label>
                                            <input type="text" name="nomAg" id="nomAg" class="form-control rounded-0" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="matriculeFiscale" class="m-1">Matricule Fiscale :</label>
                                            <input type="text" name="matriculeFiscale" id="matriculeFiscale" class="form-control rounded-0" required >
                                        </div>
                                        <div class="form-group">
                                            <label for="adresseAg" class="m-2">Adresse:</label>
                                            <textarea name="adresseAg" id="adresseAg" cols="3" rows="2" class="form-control rounded-0" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="telephone" class="m-2">Téléphone:</label>
                                            <input type="text" name="telephone" id="telephone" class="form-control rounded-0" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="idprov" class="m-2">Province:</label>
                                            <select name="idprov" id="idprov" class="form-control" required>
                                                <?php $req=$db->query("SELECT * FROM provinces");
                                                while ($tab=$req->fetch()){?>
                                                <option value="<?php echo $tab['id'];?>"><?php echo $tab['nomProvince'];?></option>
                                                <?php
                                                   }
                                                ?>
                                            </select>
                                       </div>
                                       <div class="form-group">
                                            <label for="emailAg" class="m-2">E-mail:</label>
                                            <input type="email" name="emailAg" id="emailAg" class="form-control rounded-0" required>
                                        </div>
                                        <div id="agAlert"></div>
                                        <div class="form-group">
                                           <input type="submit" name="submit" value="Confirmer Agence" id="agence-btn" class="btn btn-primary btn-lg btn-block myBtn">
                                        </div>
                                       <div class="form-group">
                                           <input type="reset" value="Annuler Agence" class="btn btn-danger btn-lg btn-block">
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <!--Fin du premier corps d'onglet-->

                            <!--Début de deuxieme corps d'onglet-->
                            <div class="tab-pane container fade " id="agence">
                                <div class="card-deck">
                                    <div class="table-responsive" id="showAllAgences">
                                        <p class="text-center align-self-center lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>&nbsp;&nbsp;Veuillez patienter...</p>
                                    </div>
                                </div>
                            </div>
                            <!--Fin de deuxieme corps d'onglet-->
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

            
            //Deleted Agence Ajax Request
            $("body").on("click", ".deleteAgencesIcon", function(e){
                e.preventDefault();
                del_agence=$(this).attr('id');

                Swal.fire({
                    title:'Etes-vous sûr de supprimer ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d8',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-la !'
                }).then((result)=>{
                    if(result.value){
                        $.ajax({
                            url:'php/admin-action.php',
                            method: 'post',
                            data:{del_agence:del_agence},
                            success:function(response){
                                Swal.fire(
                                    'Agence Supprimée!',
                                    'Agence supprimée avec succès!',
                                    'success'
                                )
                                fetchAllAgences();
                            }
                        });
                    }
                })
            });

            //Affichage d'agences
            fetchAllAgences();

            function fetchAllAgences(){
                $.ajax({
                    url:'php/admin-action.php',
                    method: 'post',
                    data:{action: 'fetchAllAgences'},
                    success:function(response){
                        $("#showAllAgences").html(response);
                        $("table").DataTable({
                            language:{
                                "lengthMenu":"Afficher Agence",
                                "zeroRecords":"Pas d'agences enregistrée",
                                "info":"",
                                "infoEmpty":"Le code Agence non trouvé",
                                "infoFiltered":"Filtrer le Total d'agences",
                                "sSearch":"Rechercher",
                                "oPaginate":{
                                    "sFirst":"",
                                    "sLast":"",
                                    "sNext":"",
                                    "sPrevious":""
                                },
                                "sProcessing":"",
                            },
                            order:[0, 'desc']
                        });
                    }
                });
            }

            //Ajout d'agence avec Ajax
            $("#agence-btn").click(function(e){
            if($("#agence-form")[0].checkValidity()){
                e.preventDefault();

                $("#agence-btn").val('Veuillez patienter...');

                $.ajax({
                    url : 'php/admin-process.php',
                    method : 'post',
                    data : $("#agence-form").serialize()+'&action=add_agence',
                    success:function(response){
                        //console.log(response);
                        $("#agence-btn").val('Confirmer Agence');
                        $("#agence-form")[0].reset();
                        Swal.fire({
                            title:'Agence Ajoutée avec succès!',
                            type:'success'
                        });
                         //Affichage d'agences
                         fetchAllAgences();
                    }
                });
            }
            });

        });
     </script>
</body>
</html>