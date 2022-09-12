<?php
    require_once '../php/agence-header.php';
    require_once '../php/connexion.php';

     //Création code Transaction de Fonds
     $mois = (int)(date("m"));
     $sec1 = date("s");
     $sec2 = (int)(date("s"));
     $code1 = $mois+$sec2 + $sec1+$sec2;
     $code2 = $code1 +$sec1+$sec2+ $mois;  
     $codeTrans= $code1.''.$code2 ;
?>
<div class="container mt-2">
    <div class="alert alert-info bg-info alert-dismissible text-center text-white mt-2 m-0">
        <div class="col-lg-16">
            <strong>Bienvenu(e) dans le système de Transaction de Fonds Agence:&nbsp;<?=$cagence;?> &nbsp;Fonction:<?=$croles;?>&nbsp;</strong>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card rounded-0 mt-3 border-success">
                <div class="card-header border-success">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a href="#LTransaction" class="nav-link active font-weight-bold" data-toggle="tab">Liste des Transactions de Fonds</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane container active" id="LTransaction">
                            <div class="card border-info">
                                    <h5 class="card-header bg-info d-flex justify-content-between">
                                        <span class="text-light lead align-self-center"><i class="fa fa-handshake"></i>&nbsp;Toutes les Transactions de Fonds</span>
                                        <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addTransactionModal"><i class="fa fa-handshake"></i>&nbsp;Ajouter Transaction de Fonds</a>
                                    </h5>
                                <div class="card-body">
                                    <div class="table-responsive" id="afficherTransactions">
                                        <p class="text-center lead mt-5">Veuillez patienter...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Début d'Ajout Transaction de Fonds -->
<div class="modal fade" id="addTransactionModal">
    <div class="modal-dialog modal-dialog-justify">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-light"><i class="fa fa-handshake"></i>&nbsp;Ajouter Transaction de Fonds</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form  action="#" method="post" id="add-transaction-form" class="px-3">
            <div class="form-group">  
                <input type="hidden" name="codeTrans" id="codeTrans" value="<?php echo $codeTrans;?>">          
                <input type="number" name="montantTrans" id="montantTrans" class="form-control form-control-lg" placeholder="Entrer montant transaction" required autofocus>
            </div>
            <div class="form-group">            
                <input type="number" name="pourcentage" id="pourcentage" class="form-control form-control-lg" placeholder="Entrer pourcentage de transaction" required>
            </div>
            <div class="form-group">
                <label for="client_id">Sélectionner client :</label>
                <select name="client_id" id="client_id" class="form-control form-control-lg" required>
                    <?php $req=$db->query("SELECT * FROM client WHERE etat=0 AND agence_id='".$data['id_ag']."'");
                        while ($tab=$req->fetch()){?>
                            <option value="<?php echo $tab['id'];?>"><?php echo $tab['nom'];?></option>
                    <?php
                        }
                        ?>
                </select>
            </div>
            <div class="form-group">
                <label for="agence_dest_id">Sélectionner Agence de destination :</label>
                <select name="agence_dest_id" id="agence_dest_id" class="form-control form-control-lg" required>
                    <?php $req=$db->query("SELECT * FROM agence WHERE idag!='".$data['id_ag']."'");
                        while ($tab=$req->fetch()){?>
                           <option value="<?php echo $tab['idag'];?>"><?php echo $tab['nomAg'];?></option>
                    <?php
                        }
                    ?>
                </select>                  
            </div>
            <div class="form-group">
                <input type="submit" name="addTransactions" class="btn btn-info btn-block btn-lg" id="addTransactionBtn" value="Ajouter Transaction de Fonds" >
            </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Fin d'Ajout Transaction de Fonds-->
<?php
    require_once '../php/footer.php';
?>
<script type="text/javascript">
 $(document).ready(function(){

     //Ajouter Transaction de Fonds Ajax Request
     $("#addTransactionBtn").click(function(e){
            if($("#add-transaction-form")[0].checkValidity()){
                e.preventDefault();
                $("#addTransactionBtn").val('Veuillez patienter...');
                $.ajax({
                    url:'../php/agence-process.php',
                    method:'post',
                    data:$("#add-transaction-form").serialize()+'&action=add_transaction',
                    success:function(response){
                        $("#addTransactionBtn").val('Ajouter Transaction de Fonds');
                        $("#add-transaction-form")[0].reset();
                        $("#addTransactionModal").modal('hide');
                        Swal.fire({
                            title:'Transaction Fonds ajoutée avec succès !',
                            type:'success'
                        });
                        fetchAllTransactions();
                        //console.log(response);
                    }
                });
            }
        });

        //Delete une transaction
        $("body").on("click", ".deletetransactionBtn", function(e){
                e.preventDefault();

                del_trans_id=$(this).attr('id');

                Swal.fire({
                    title: 'Etes-vous sûr de supprimer ?',
                    text: "Vous ne pourrez pas revenir en arrière !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-la!'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'../php/agence-process.php',
                            method:'post',
                            data:{del_trans_id:del_trans_id},
                            success:function(response){
                                Swal.fire(
                                    'Supprimer Transaction Fonds !',
                                    'Transaction Fonds supprimée avec succès.',
                                    'success'
                                )
                                fetchAllTransactions();
                            }
                        });
                        
                    }
                })

        });

        //Fetch All Transactions Ajax Request
        fetchAllTransactions();

        function fetchAllTransactions(){
            $.ajax({
                url:'../php/agence-process.php',
                method: 'post',
                data:{action: 'fetchAllTransactions'},
                success:function(response){
                    $("#afficherTransactions").html(response);
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