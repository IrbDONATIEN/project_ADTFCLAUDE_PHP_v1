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
                                        <span class="text-light lead align-self-center"><i class="fas fa-business-time"></i>&nbsp;Toutes les Transactions de Fonds</span>
                                    </h5>
                                <div class="card-body">
                                    <div class="table-responsive" id="afficherTransactionsFonds">
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
<?php
    require_once '../php/footer.php';
?>
<script type="text/javascript">
 $(document).ready(function(){
        
    //Fetch All Transactions Ajax Request
        fetchAllTransactionsF();

        function fetchAllTransactionsF(){
            $.ajax({
                url:'../php/agence-process.php',
                method: 'post',
                data:{action: 'fetchAllTransactionsF'},
                success:function(response){
                    $("#afficherTransactionsFonds").html(response);
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