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
                <span class="text-light lead align-self-center"><i class="fas fa-hiking"></i>&nbsp;Tous les bénéficiaires</span>
                <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addBeneficiaireModal"><i class="fas fa-hiking"></i>&nbsp;Ajouter Bénéficiaire</a>
            </h5>
        <div class="card-body">
            <div class="table-responsive" id="afficherBeneficiaires">
                <p class="text-center lead mt-5">Veuillez patienter...</p>
            </div>
        </div>
    </div>
</div>
<!--Début d'Ajout Bénéficiaire -->
<div class="modal fade" id="addBeneficiaireModal">
    <div class="modal-dialog modal-dialog-justify">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-light"><i class="fas fa-hiking"></i>&nbsp;Ajouter Bénéficiaire</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form  action="#" method="post" id="add-beneficiaire-form" class="px-3">
            <div class="form-group">  
                <input type="text" name="nomBen" id="nomBen" class="form-control form-control-lg" placeholder="Entrer nom Bénéficiaire" required autofocus>
            </div>
            <div class="form-group">            
                <input type="text" name="postnomBen" id="postnomBen" class="form-control form-control-lg" placeholder="Entrer postnom Bénéficiaire" required>
            </div>
            <div class="form-group">            
                <input type="text" name="prenomBen" id="prenomBen" class="form-control form-control-lg" placeholder="Entrer prénom Bénéficiaire" required>
            </div>
            <div class="form-group">            
                <input type="text" name="telephoneBen" id="telephoneBen" class="form-control form-control-lg" placeholder="Entrer téléphone Bénéficiaire" required>
            </div>
            <div class="form-group">            
                <input type="text" name="adresseBen" id="adresseBen" class="form-control form-control-lg" placeholder="Entrer adresse Bénéficiaire" required>
            </div>
            <div class="form-group">
                <label for="client_ben_id">Sélectionner client :</label>
                <select name="client_ben_id" id="client_ben_id" class="form-control form-control-lg" required>
                    <?php $req=$db->query("SELECT * FROM client WHERE etat=0 AND agence_id='".$data['id_ag']."'");
                        while ($tab=$req->fetch()){?>
                            <option value="<?php echo $tab['id'];?>"><?php echo $tab['nom'];?></option>
                    <?php
                        }
                        ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="addBeneficiaire" class="btn btn-info btn-block btn-lg" id="addBeneficiaireBtn" value="Ajouter Bénéficiaire" >
            </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Fin d'Ajout Bénéficiaire-->
<?php
    require_once '../php/footer.php';
?>
<script type="text/javascript">
 $(document).ready(function(){

        //Ajouter Bénéficiaire Ajax Request
        $("#addBeneficiaireBtn").click(function(e){
            if($("#add-beneficiaire-form")[0].checkValidity()){
                e.preventDefault();
                $("#addBeneficiaireBtn").val('Veuillez patienter...');
                $.ajax({
                    url:'../php/agence-process.php',
                    method:'post',
                    data:$("#add-beneficiaire-form").serialize()+'&action=add_beneficiaire',
                    success:function(response){
                        $("#addBeneficiaireBtn").val('Ajouter Bénéficiaire');
                        $("#add-beneficiaire-form")[0].reset();
                        $("#addBeneficiaireModal").modal('hide');
                        Swal.fire({
                            title:'Bénéficiaire ajouté avec succès !',
                            type:'success'
                        });
                        fetchAllBeneficiaires();
                        //console.log(response);
                    }
                });
            }
        });

        //Delete un bénéficiaire
        $("body").on("click", ".deleteBeneficiaireBtn", function(e){
                e.preventDefault();

                del_ben_id=$(this).attr('id');

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
                            data:{del_ben_id:del_ben_id},
                            success:function(response){
                                Swal.fire(
                                    'Supprimer Bénéficiaire !',
                                    'Bénéficiaire supprimé avec succès.',
                                    'success'
                                )
                                fetchAllBeneficiaires();
                            }
                        });
                        
                    }
                })

            });

        //Fetch All Bénéficiaires Ajax Request
        fetchAllBeneficiaires();

        function fetchAllBeneficiaires(){
            $.ajax({
                url:'../php/agence-process.php',
                method: 'post',
                data:{action: 'fetchAllBeneficiaires'},
                success:function(response){
                    $("#afficherBeneficiaires").html(response);
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