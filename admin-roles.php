<?php
    require_once 'php/admin-header.php';
?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card my-2 border-secondary">
                    <div class="card-header bg-danger text-white">
                        <h4 class="m-0"><i class="fas fa-book fa-fw"></i>&nbsp;&nbsp;Total Rôles
                        <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#addRolesModal"><i class="fas fa-plus-circle fa-lg"></i>
                        &nbsp;Ajouter Rôles
                        </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="showAllRoles">
                            <p class="text-center align-self-center lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>&nbsp;&nbsp;Veuillez patienter...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!--Start Editer Roles Modal-->
         <div class="modal fade" id="editRolesModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-light">Editer Rôle</h4>
                        <button  type="button" class="close text-light" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="edit-role-form" class="px-3">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <input type="text" name="erole" id="erole" class="form-control form-control-lg" placeholder="Modifier votre rôle ici" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="editRole" id="editRoleBtn" value="Modifier Rôle" class="btn btn-info btn-block btn-lg">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End Editer Roles Modal-->

        <!--Start Add New Role Modal-->
        <div class="modal fade" id="addRolesModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-secondary">
                        <h4 class="modal-title text-light"><i class="fas fa-book fa-fw"></i>&nbsp;&nbsp;Ajouter Rôle</h4>
                        <button  type="button" class="close text-light" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="add-role-form" class="px-3">
                            <div class="form-group">
                                <input type="text" name="role" class="form-control form-control-lg" placeholder="Écrivez votre rôle ici..." required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="addRole" id="addRoleBtn" value="Ajouter Rôle" class="btn btn-success btn-block btn-lg">
                            </div>
                            <div id="roleAlert">
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
            
            //Affichage des rôles
            fetchAllRoles();

            function fetchAllRoles(){
                $.ajax({
                    url:'php/admin-action.php',
                    method: 'post',
                    data:{action: 'fetchAllRoles'},
                    success:function(response){
                        $("#showAllRoles").html(response);
                        $("table").DataTable({
                            order:[0, 'desc']
                        });
                    }
                });
            }

            //Delete Rôle Ajax Request
            $("body").on("click", ".deleteRolesIcon", function(e){
                e.preventDefault();
                role_id=$(this).attr('id');

                Swal.fire({
                    title:'Etes-vous sûr de supprimer ?',
                    text: "Vous ne pourrez pas revenir en arrière!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3225d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Annuler',
                    confirmButtonText: 'Oui, supprimez-le!'
                }).then((result)=>{
                    if(result.value){
                        $.ajax({
                            url:'php/admin-action.php',
                            method: 'post',
                            data:{role_id:role_id},
                            success:function(response){
                                Swal.fire(
                                    'Supprimer Rôle !',
                                    'Rôle supprimé avec succès!',
                                    'success'
                                )
                                fetchAllRoles();
                            }
                        });
                    }
                })
            });

            //Afficher le rôle d'un utilisateur dans les détails Demande Ajax
            $("body").on("click", ".infoRolesBtn", function(e){
                e.preventDefault();

                inforole_id=$(this).attr('id');

                $.ajax({
                    url:'php/admin-action.php',
                    method:'post',
                    data:{inforole_id:inforole_id},
                    success:function(response){
                        data=JSON.parse(response);
                        Swal.fire({
                            title:'<strong>Rôle : ID('+data.id+')</strong>',
                            type:'info',
                            html:'<b>Rôle :</b>'+data.nomRole,
                            showCloseButton:true,
                        });
                    }
                });
            });

            //Préparation d'édition de rôle en affichant dans le formulaire avec Ajax Request
            $("body").on("click", ".editerRolesIcon", function(e){
                editrole_id=$(this).attr('id');
                
                $.ajax({
                    url:'php/admin-action.php',
                    method:'post',
                    data:{editrole_id:editrole_id},
                    success:function(response){
                        data=JSON.parse(response);
                        $("#id").val(data.id);
                        $("#erole").val(data.nomRole);
                    }
                });

            });

            //Edition proprement dite  de rôle sélectionnée par l'utilisateur
            $("#editRoleBtn").click(function(e){
                if($("#edit-role-form")[0].checkValidity()){
                    e.preventDefault();

                    $.ajax({
                        url:'php/admin-action.php',
                        method:'post',
                        data:$("#edit-role-form").serialize()+"&action=update_role",
                        success:function(response){
                            Swal.fire({
                                title:'Province mise à jour avec succès!',
                                type:'success'
                            });
                            $("#edit-role-form")[0].reset();
                            $("#editRolesModal").modal('hide');

                              //Actualiser l'affichage des rôles
                              fetchAllRoles();
                        }
                    });
                }
            });

            //Ajout de rôle avec Ajax
            $("#addRoleBtn").click(function(e){
            if($("#add-role-form")[0].checkValidity()){
                e.preventDefault();

                $("#addRoleBtn").val('Veuillez patienter...');

                $.ajax({
                    url : 'php/admin-action.php',
                    method : 'post',
                    data : $("#add-role-form").serialize()+'&action=add_role',
                    success:function(response){
                        $("#addRoleBtn").val('Ajouter Rôle');
                        $("#add-role-form")[0].reset();
                        $("#addRolesModal").modal('hide');
                        Swal.fire({
                            title:'Rôle Ajouté avec succès!',
                            type:'success'
                        });
                        //Actualiser l'affichage des rôles
                        fetchAllRoles();
                    }
                });
            }
            });


            
        });
     </script>
</body>
</html>