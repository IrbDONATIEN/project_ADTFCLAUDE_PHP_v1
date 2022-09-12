<?php
    require_once 'php/admin-header.php';
?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card my-2 border-danger">
                    <div class="card-header bg-danger text-white">
                        <h4 class="m-0"><i class="fa fa-fire"></i>&nbsp;&nbsp;Total Agences Supprimées</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="showAllAgences">
                            <p class="text-center align-self-center lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>&nbsp;&nbsp;Veuillez patienter...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Footer Area-->
            </div>
        </div>
     </div>
     <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
     <script type="text/javascript">
        $(document).ready(function(){

            //Restore Deleted Agence Ajax Request
            $("body").on("click", ".restoreAgnecesDelIcon", function(e){
                e.preventDefault();
                rest_agence=$(this).attr('id');

                Swal.fire({
                    title:'Etes-vous sûr de restaurer ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d7',
                    cancelButtonColor: '#d35',
                    confirmButtonText: 'Oui, restaurez-la !'
                }).then((result)=>{
                    if(result.value){
                        $.ajax({
                            url:'php/admin-action.php',
                            method: 'post',
                            data:{rest_agence:rest_agence},
                            success:function(response){
                                Swal.fire(
                                    'Agence Restaurée!',
                                    'Agence restaurée avec succès!',
                                    'success'
                                )
                                fetchAllAgencesDel();
                            }
                        });
                    }
                })
            });

            //Affichage d'agences supprimées
            fetchAllAgencesDel();

            function fetchAllAgencesDel(){
                $.ajax({
                    url:'php/admin-action.php',
                    method: 'post',
                    data:{action: 'fetchAllAgencesDel'},
                    success:function(response){
                        $("#showAllAgences").html(response);
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