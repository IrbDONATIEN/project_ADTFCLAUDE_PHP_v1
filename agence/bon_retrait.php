<?php
    require_once '../php/agence-header.php';
    require_once '../php/connexion.php';
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
                <span class="text-light lead align-self-center"><i class="fab fa-buffer"></i>&nbsp;Tous les bons des Retraits</span>
                <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addBonModal"><i class="fab fa-buffer"></i>&nbsp;Ajouter Bon Retrait</a>
            </h5>
        <div class="card-body">
            <div class="table-responsive" id="afficherBonsRetraits">
                <p class="text-center lead mt-5">Veuillez patienter...</p>
            </div>
        </div>
    </div>
</div>
<!--Début d'Ajout Bon Retrait -->
<div class="modal fade" id="addBonModal">
    <div class="modal-dialog modal-dialog-justify">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-light"><i class="fab fa-buffer"></i>&nbsp;Ajouter Bon Retrait de Fonds</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form  action="#" method="post" id="add-bon-form" class="px-3">
            <div class="form-group">  
                <input type="text" name="motif" id="motif" class="form-control form-control-lg" placeholder="Entrer motif bon retrait" required autofocus>
            </div>
            <div class="form-group"> 
                <label for="date_create">Sélectionner Date Etablissement Bon Retrait:</label>           
                <input type="date" name="date_create" id="date_create" class="form-control form-control-lg" required>
            </div>
            <div class="form-group">
                <label for="beneficiaire_id">Sélectionner Bénéficiaire :</label>
                <select name="beneficiaire_id" id="beneficiaire_id" class="form-control form-control-lg" required>
                    <?php $req=$db->query("SELECT beneficiaire.id,nomBen,postnomBen,prenomBen,telephoneBen,adresseBen,client_ben_id,client.nom,client.prenom,client.telephone,etat_ben,dateCreation, agence_ben_id,agence.nomAg FROM beneficiaire INNER JOIN agence ON agence.idag=beneficiaire.agence_ben_id INNER JOIN client ON client.id=beneficiaire.client_ben_id WHERE etat_ben=0 AND agence_ben_id!='".$data['id_ag']."'");
                        while ($tab=$req->fetch()){?>
                            <option value="<?php echo $tab['id'];?>"><?php echo $tab['nom'];?>&nbsp;|<?php echo $tab['nomBen'];?>&nbsp;|<?php echo $tab['nomAg'];?></option>
                    <?php
                        }
                        ?>
                </select>
            </div>
            <div class="form-group">
                <label for="etat_transaction">Sélectionner Transaction Fonds Bénéficiaire:</label>
                <select name="etat_transaction" id="etat_transaction" class="form-control form-control-lg" required>
                    <?php $req=$db->query("SELECT transfert.id,codeTrans,montantTrans,pourcentage,etat_transfert,date_enreg,client_id,client.nom,client.prenom,agence_exp_id,agence.codAg,agence.nomAg, agence_dest_id,beneficiaire.nomBen,beneficiaire.prenomBen FROM transfert INNER JOIN client ON client.id=transfert.client_id INNER JOIN agence ON agence.idag=transfert.agence_exp_id INNER JOIN beneficiaire ON beneficiaire.client_ben_id=transfert.client_id WHERE etat_transfert=0 AND agence_exp_id!='".$data['id_ag']."'");
                        while ($tab=$req->fetch()){?>
                            <option value="<?php echo $tab['id'];?>"><?php echo $tab['montantTrans'];?>&nbsp;|<?php echo $tab['nom'];?>&nbsp;|<?php echo $tab['nomBen'];?>&nbsp;|<?php echo $tab['nomAg'];?></option>
                    <?php
                        }
                        ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="addBonRetrait" class="btn btn-info btn-block btn-lg" id="addBonBtn" value="Ajouter Bon Retrait Fonds" >
            </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Fin d'Ajout Bon Retrait-->
<?php
    require_once '../php/footer.php';
?>
<script type="text/javascript">
 $(document).ready(function(){

    //Ajouter Bon retrait de Fonds Ajax Request
     $("#addBonBtn").click(function(e){
            if($("#add-bon-form")[0].checkValidity()){
                e.preventDefault();
                $("#addBonBtn").val('Veuillez patienter...');
                $.ajax({
                    url:'../php/agence-process.php',
                    method:'post',
                    data:$("#add-bon-form").serialize()+'&action=add_bon',
                    success:function(response){
                        $("#addBonBtn").val('Ajouter Bon Retrait Fonds');
                        $("#add-bon-form")[0].reset();
                        $("#addBonModal").modal('hide');
                        Swal.fire({
                            title:'Bon de Retrait ajouté avec succès !',
                            type:'success'
                        });
                        fetchAllBonRetraitTransactions();
                        //console.log(response);
                    }
                });
            }
        });

        //Fetch All Bon Retrait des Transactions Ajax Request
        fetchAllBonRetraitTransactions();
        function fetchAllBonRetraitTransactions(){
            $.ajax({
                url:'../php/agence-process.php',
                method: 'post',
                data:{action: 'fetchAllBonRetraitTransactions'},
                success:function(response){
                    $("#afficherBonsRetraits").html(response);
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