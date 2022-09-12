<?php
    require_once 'php/admin-header.php';
?>
        <!--Début de la section 1-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card my-2 border-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="m-0"><i class="fas fa-pen"></i>&nbsp;&nbsp;Total Provinces
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addProvinceModal"><i class="fas fa-plus-circle fa-lg"></i>
                        &nbsp;Ajouter Province
                        </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="showAllProvinces">
                            <p class="text-center align-self-center lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>&nbsp;&nbsp;Veuillez patienter...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Début de la section 1-->

        <!--Start Editer Province Modal-->
        <div class="modal fade" id="editProvinceModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title text-light">Editer Province</h4>
                        <button  type="button" class="close text-light" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="edit-province-form" class="px-3">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <input type="text" name="eprovince" id="eprovince" class="form-control form-control-lg" placeholder="Modifier votre province ici" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="editProvince" id="editProvinceBtn" value="Modifier Province" class="btn btn-info btn-block btn-lg">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End Editer Province Modal-->


        <!--Start Add New Province Modal-->
        <div class="modal fade" id="addProvinceModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title text-light">Ajouter Province</h4>
                        <button  type="button" class="close text-light" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="add-province-form" class="px-3">
                            <div id="provAlert">
                            <div class="form-group">
                                <input type="text" name="province" class="form-control form-control-lg" placeholder="Écrivez votre province ici..." required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="addProvince" id="addProvinceBtn" value="Ajouter Province" class="btn btn-success btn-block btn-lg">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End Add New Province Modal-->
        
        <!--Footer Area-->
            </div>
        </div>
     </div>
     <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

     <script type="text/javascript">
        $(document).ready(function(){
            
            //Ajout de la province avec Ajax
            $("#addProvinceBtn").click(function(e){
            if($("#add-province-form")[0].checkValidity()){
                e.preventDefault();

                $("#addProvinceBtn").val('Veuillez patienter...');

                $.ajax({
                    url : 'php/admin-action.php',
                    method : 'post',
                    data : $("#add-province-form").serialize()+'&action=add_province',
                    success:function(response){
                        $("#addProvinceBtn").val('Ajouter Province');
                        $("#add-province-form")[0].reset();
                        $("#addProvinceModal").modal('hide');
                        Swal.fire({
                            title:'Province Ajoutée avec succès!',
                            type:'success'
                        });
                        fetchAllProvinces();
                    }
                });
            }
            });

            //Préparation d'édition de la province en affichant dans le formulaire avec Ajax Request
            $("body").on("click", ".editerProvinceIcon", function(e){
                editprovince_id=$(this).attr('id');
                
                $.ajax({
                    url:'php/admin-action.php',
                    method:'post',
                    data:{editprovince_id:editprovince_id},
                    success:function(response){
                        data=JSON.parse(response);
                        $("#id").val(data.id);
                        $("#eprovince").val(data.nomProvince);
                    }
                });

            });

            //Edition proprement dite  de la province sélectionnée par l'utilisateur
            $("#editProvinceBtn").click(function(e){
                if($("#edit-province-form")[0].checkValidity()){
                    e.preventDefault();

                    $.ajax({
                        url:'php/admin-action.php',
                        method:'post',
                        data:$("#edit-province-form").serialize()+"&action=update_province",
                        success:function(response){
                            Swal.fire({
                                title:'Province mise à jour avec succès!',
                                type:'success'
                            });
                            $("#edit-province-form")[0].reset();
                            $("#editProvinceModal").modal('hide');

                             //Fetch All Provinces Ajax Request
                             fetchAllProvinces();
                        }
                    });
                }
            });

            //Afficher la province d'un utilisateur dans les détails Demande Ajax
            $("body").on("click", ".infoProvinceBtn", function(e){
                e.preventDefault();

                infoprovince_id=$(this).attr('id');

                $.ajax({
                    url:'php/admin-action.php',
                    method:'post',
                    data:{infoprovince_id:infoprovince_id},
                    success:function(response){
                        data=JSON.parse(response);
                        Swal.fire({
                            title:'<strong>Province : ID('+data.id+')</strong>',
                            type:'info',
                            html:'<b>Province :</b>'+data.nomProvince,
                            showCloseButton:true,
                        });
                    }
                });
            });

            //Fetch All Provinces Ajax Request
            fetchAllProvinces();

            function fetchAllProvinces(){
                $.ajax({
                    url:'php/admin-action.php',
                    method: 'post',
                    data:{action: 'fetchAllProvinces'},
                    success:function(response){
                        $("#showAllProvinces").html(response);
                        $("table").DataTable({
                            order:[0, 'desc']
                        });
                    }
                });
            }

            //Delete Province Ajax Request
            $("body").on("click", ".deleteProvinceIcon", function(e){
                e.preventDefault();
                province_id=$(this).attr('id');

                Swal.fire({
                    title:'Etes-vous sûr de supprimer ?',
                    text: "Vous ne pourrez pas revenir en arrière!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3225d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Annuler',
                    confirmButtonText: 'Oui, supprimez-la!'
                }).then((result)=>{
                    if(result.value){
                        $.ajax({
                            url:'php/admin-action.php',
                            method: 'post',
                            data:{province_id:province_id},
                            success:function(response){
                                Swal.fire(
                                    'Supprimé Province !',
                                    'Province supprimée avec succès!',
                                    'success'
                                )
                                fetchAllProvinces();
                            }
                        });
                    }
                })
            });


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

        });
     </script>
</body>
</html>