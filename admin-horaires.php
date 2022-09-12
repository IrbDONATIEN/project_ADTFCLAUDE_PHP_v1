<?php
    require_once 'php/admin-header.php';
?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card my-2 border-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="m-0"><i class="fa fa-calendar-minus"></i>&nbsp;&nbsp;Total Horaire
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addHoraireModal"><i class="fas fa-plus-circle fa-lg"></i>
                        &nbsp;Ajouter Horaire
                        </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="showAllHoraires">
                            <p class="text-center align-self-center lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>&nbsp;&nbsp;Veuillez patienter...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Start Add New Horaire Modal-->
        <div class="modal fade" id="addHoraireModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-secondary">
                        <h4 class="modal-title text-light"><i class="fa fa-calendar-minus"></i>&nbsp;&nbsp;Ajouter Horaire</h4>
                        <button  type="button" class="close text-light" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="add-horaire-form" class="px-3">
                            <div class="form-group">
                                <label for="heure_debut">Sélectionner Heure du début :</label>
                                <input type="time" name="heure_debut" class="form-control form-control-lg" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="heure_fin">Sélectionner Heure de la fin:</label>
                                <input type="time" name="heure_fin" class="form-control form-control-lg" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="addHoraire" id="addHoraireBtn" value="Ajouter Horaire" class="btn btn-primary btn-block btn-lg">
                            </div>
                            <div id="horaireAlert">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End Add New Horaire Modal-->
        
        <!--Footer Area-->
            </div>
        </div>
     </div>
     <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
     <script type="text/javascript">
        $(document).ready(function(){

            //Ajout Horaire avec Ajax
            $("#addHoraireBtn").click(function(e){
            if($("#add-horaire-form")[0].checkValidity()){
                e.preventDefault();

                $("#addGuichetBtn").val('Veuillez patienter...');

                $.ajax({
                    url : 'php/admin-process.php',
                    method : 'post',
                    data : $("#add-horaire-form").serialize()+'&action=add_horaire',
                    success:function(response){
                        //console.log(response);
                        $("#addHoraireBtn").val('Ajouter Horaire');
                        $("#add-horaire-form")[0].reset();
                        $("#addHoraireModal").modal('hide');
                        Swal.fire({
                            title:'Horaire Ajouté avec succès!',
                            type:'success'
                        });
                        fetchAllHoraires();
                    }
                });
            }
            });

            //Deleted Horaire Ajax Request
            $("body").on("click", ".deleteHorairesIcon", function(e){
                e.preventDefault();
                del_horaire=$(this).attr('id');

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
                            data:{del_horaire:del_horaire},
                            success:function(response){
                                Swal.fire(
                                    'Horaire Supprimé!',
                                    'Horaire supprimé avec succès!',
                                    'success'
                                )
                                fetchAllHoraires();
                            }
                        });
                    }
                })
            });

            //Fetch All Horaire de travail Ajax Request
            fetchAllHoraires();

            function fetchAllHoraires(){
                $.ajax({
                    url:'php/admin-action.php',
                    method: 'post',
                    data:{action: 'fetchAllHoraires'},
                    success:function(response){
                        $("#showAllHoraires").html(response);
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