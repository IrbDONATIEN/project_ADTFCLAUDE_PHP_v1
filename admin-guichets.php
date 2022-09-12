<?php
    require_once 'php/admin-header.php';
    require_once 'php/connexion.php';

    //Création matricule
    $mois = (int)(date("m"));
    $sec1 = date("s");
    $sec2 = (int)(date("s"));
    $code1 = $sec2 + $sec1 + $mois+$sec2;
    $code2 = $code1 + $sec2 + $mois+$sec1; 
    $code="G"; 
    $codeGu =$code.$code1.''.$code2 ;
?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card my-2 border-secondary">
                    <div class="card-header bg-success text-white">
                        <h4 class="m-0"><i class="fa fa-handshake"></i>&nbsp;&nbsp;Total Guichets
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addGuichetModal"><i class="fas fa-plus-circle fa-lg"></i>
                        &nbsp;Ajouter Guichets
                        </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="showAllGuichets">
                            <p class="text-center align-self-center lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>&nbsp;&nbsp;Veuillez patienter...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Start Add New Role Modal-->
        <div class="modal fade" id="addGuichetModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title text-light"><i class="fas fa-book fa-fw"></i>&nbsp;&nbsp;Ajouter Guichet</h4>
                        <button  type="button" class="close text-light" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="admin-guichets.php" method="post" id="add-guichet-form" class="px-3">
                            <div class="form-group">
                            <input type="hidden" name="codeGuichet" id="codeGuichet" value="<?php echo $codeGu;?>">
                                <input type="text" name="nomGuichet" class="form-control form-control-lg" placeholder="Écrivez votre guichet ici..." required>
                            </div>
                            <div class="form-group">
                                <label for="idAg" class="m-2">Agence:</label>
                                <select name="idAg" id="idAg" class="form-control" required>
                                    <?php $req=$db->query("SELECT * FROM agence");
                                    while ($tab=$req->fetch()){?>
                                    <option value="<?php echo $tab['idag'];?>"><?php echo $tab['nomAg'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>       
                            </div>
                            <div class="form-group">
                                <input type="submit" name="addGuichet" id="addGuichetBtn" value="Ajouter Guichet" class="btn btn-primary btn-block btn-lg">
                            </div>
                            <div id="guichetAlert">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End Add New Role Modal-->

        <!--Footer Area-->
            </div>
        </div>
     </div>
     <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
     <script type="text/javascript">
        $(document).ready(function(){

            //Deleted Guichet Ajax Request
            $("body").on("click", ".deleteGuichetsIcon", function(e){
                e.preventDefault();
                del_guichet=$(this).attr('id');

                Swal.fire({
                    title:'Etes-vous sûr de supprimer ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d8',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-le !'
                }).then((result)=>{
                    if(result.value){
                        $.ajax({
                            url:'php/admin-action.php',
                            method: 'post',
                            data:{del_guichet:del_guichet},
                            success:function(response){
                                Swal.fire(
                                    'Guichet Supprimé!',
                                    'Guichet supprimé avec succès!',
                                    'success'
                                )
                                fetchAllGuichets();
                            }
                        });
                    }
                })
            });

            //Ajout de guichet avec Ajax
            $("#addGuichetBtn").click(function(e){
            if($("#add-guichet-form")[0].checkValidity()){
                e.preventDefault();

                $("#addGuichetBtn").val('Veuillez patienter...');

                $.ajax({
                    url : 'php/admin-process.php',
                    method : 'post',
                    data : $("#add-guichet-form").serialize()+'&action=add_guichet',
                    success:function(response){
                        //console.log(response);
                        $("#addGuichetBtn").val('Ajouter Guichet');
                        $("#add-guichet-form")[0].reset();
                        $("#addGuichetModal").modal('hide');
                        Swal.fire({
                            title:'Guichet Ajouté avec succès!',
                            type:'success'
                        });
                        fetchAllGuichets();
                    }
                });
            }
            });

            //Affichage des guichets
            fetchAllGuichets();

            function fetchAllGuichets(){
                $.ajax({
                    url:'php/admin-action.php',
                    method: 'post',
                    data:{action: 'fetchAllGuichets'},
                    success:function(response){
                        $("#showAllGuichets").html(response);
                        $("table").DataTable({
                            order:[0, 'desc']
                        });
                    }
                });
            }

        });
     </script>
</body>
</html>