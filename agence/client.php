<?php
    require_once '../php/agence-header.php';
?>
<div class="container mt-2">
    <div class="alert alert-info bg-info alert-dismissible text-center text-white mt-2 m-0">
        <div class="col-lg-16">
            <strong>Bienvenu(e) dans le système de Transaction de Fonds Agence:&nbsp;<?=$cagence;?> &nbsp;Fonction:<?=$croles;?>&nbsp;</strong>
        </div>
    </div>
    <hr>
    <div class="card border-info mt-2">
            <h5 class="card-header bg-info d-flex justify-content-between">
                <span class="text-light lead align-self-center"><i class="fa fa-male"></i>&nbsp;Tous les clients</span>
                <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addClientModal"><i class="fa fa-male"></i>&nbsp;Ajouter Client</a>
            </h5>
        <div class="card-body">
            <div class="table-responsive" id="afficherClients">
                <p class="text-center lead mt-5">Veuillez patienter...</p>
            </div>
        </div>
    </div>
</div>
<!--Début d'Ajout client -->
<div class="modal fade" id="addClientModal">
    <div class="modal-dialog modal-dialog-justify">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-light"><i class="fa fa-male"></i>&nbsp;Ajouter Client</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form  action="#" method="post" id="add-client-form" class="px-3">
            <div class="form-group">  
                <input type="text" name="nom" id="nom" class="form-control form-control-lg" placeholder="Entrer nom client" required autofocus>
            </div>
            <div class="form-group">            
                <input type="text" name="prenom" id="prenom" class="form-control form-control-lg" placeholder="Entrer prénom client" required>
            </div>
            <div class="form-group">            
                <input type="text" name="telephone" id="telephone" class="form-control form-control-lg" placeholder="Entrer téléphone client" required>
            </div>
            <div class="form-group">
                <input type="submit" name="addClients" class="btn btn-info btn-block btn-lg" id="addClientBtn" value="Ajouter Client" >
            </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Fin d'Ajout client-->

<!--Début d'édition client -->
<div class="modal fade" id="editClientModal">
    <div class="modal-dialog modal-dialog-justify">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title text-light"><i class="fa fa-male"></i>&nbsp;Ajouter Client</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form  action="#" method="post" id="edit-client-form" class="px-3">
            <div class="form-group">  
                <input type="text" name="enom" id="enom" class="form-control form-control-lg" placeholder="Entrer nom client" required autofocus>
            </div>
            <div class="form-group">            
                <input type="text" name="eprenom" id="eprenom" class="form-control form-control-lg" placeholder="Entrer prénom client" required>
            </div>
            <div class="form-group">            
                <input type="text" name="etelephone" id="etelephone" class="form-control form-control-lg" placeholder="Entrer téléphone client" required>
            </div>
            <div class="form-group">
                <input type="submit" name="editClients" class="btn btn-info btn-block btn-lg" id="editClientBtn" value="Modifier Client" >
            </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Fin d'édition client-->

<?php
    require_once '../php/footer.php';
?>
<script type="text/javascript">
 $(document).ready(function(){
       
    //Ajouter client Ajax Request
        $("#addClientBtn").click(function(e){
            if($("#add-client-form")[0].checkValidity()){
                e.preventDefault();
                $("#addClientBtn").val('Veuillez patienter...');
                $.ajax({
                    url:'../php/agence-process.php',
                    method:'post',
                    data:$("#add-client-form").serialize()+'&action=add_client',
                    success:function(response){
                        $("#addClientBtn").val('Ajouter Client');
                        $("#add-client-form")[0].reset();
                        $("#addClientModal").modal('hide');
                        Swal.fire({
                            title:'Client ajouté avec succès !',
                            type:'success'
                        });
                        fetchAllClients();
                        //console.log(response);
                    }
                });
            }
        });

        //Delete un client
        $("body").on("click", ".deleteclientBtn", function(e){
                e.preventDefault();

                del_client_id=$(this).attr('id');

                Swal.fire({
                    title: 'Etes-vous sûr de supprimer ?',
                    text: "Vous ne pourrez pas revenir en arrière !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-le!'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'../php/agence-process.php',
                            method:'post',
                            data:{del_client_id:del_client_id},
                            success:function(response){
                                Swal.fire(
                                    'Supprimer Client !',
                                    'Client supprimé avec succès.',
                                    'success'
                                )
                                fetchAllClients();
                            }
                        });
                        
                    }
                })

            });

        //Fetch All Clients Ajax Request
        fetchAllClients();

        function fetchAllClients(){
            $.ajax({
                url:'../php/agence-process.php',
                method: 'post',
                data:{action: 'fetchAllClients'},
                success:function(response){
                    $("#afficherClients").html(response);
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