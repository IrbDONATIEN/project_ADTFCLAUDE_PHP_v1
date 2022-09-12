<?php
    require_once '../php/agence-header.php';
    require_once '../php/agence-db.php';

    $count=new Agence();
?>
<div class="container mt-2">
    <div class="alert alert-info bg-info alert-dismissible text-center text-white mt-2 m-0">
        <div class="col-lg-16">
            <strong>Bienvenu(e) dans le système de Transaction de Fonds Agence:&nbsp;<?=$cagence;?> &nbsp;Fonction:<?=$croles;?>&nbsp;</strong>
        </div>
    </div>
    <hr>
    <?php if($crole=='Operateur'):?>
    <h4 class="text-center text-primary mt-3">Tableau de Bord de ADTFCLAUDE !</h4>
    <!--Début de la ligne 1-->
    <div class="row text-center ">
    <div class="col-lg-12">
        <div class="card-deck mt-3 text-light text-center font-weight-bold">
            <!--Debut de la case 1-->
            <div class="card bg-primary">
                <div class="card-header"><i class="fa fa-home"></i>&nbsp;&nbsp;Code Agence</div>
                    <div class="card-body">
                        <h1 class="display-4">
                            <?=$ccodeagence;?>
                        </h1>
                    </div>
            </div>
            <!--Fin de la case 1-->
            <!--Debut de la case 1-->
            <div class="card bg-danger">
                <div class="card-header"><i class="far fa-address-book"></i>&nbsp;&nbsp;Total Client</div>
                    <div class="card-body">
                        <h1 class="display-4">
                           <?= $count->totalCount($cid_ag);?>
                        </h1>
                    </div>
            </div>
            <!--Fin de la case 1-->
            <!--Debut de la case 1-->
            <div class="card bg-success">
                <div class="card-header"><i class="fas fa-book"></i>&nbsp;Total Client Transaction</div>
                    <div class="card-body">
                        <h1 class="display-4">
                            <?= $count->totalClientTransaction($cid_ag);?>
                        </h1>
                    </div>
            </div>
            <!--Fin de la case 1-->
        </div>        
    </div>
</div>
<!--Fin de la ligne 1-->
<!--Début de la ligne 2-->
<div class="row text-center ">
    <div class="col-lg-12">
        <div class="card-deck mt-3 text-light text-center font-weight-bold">
            <!--Debut de la case 1-->
            <div class="card bg-secondary">
                <div class="card-header"><i class="fas fa-money-check-alt"></i>&nbsp;<i class="fas fa-money-check-alt"></i>&nbsp;Total Montant Généré</div>
                    <div class="card-body">
                        <h1 class="display-4">
                           <?php  $data=$count->caisseTotalGenerals($cid_ag); echo $data['Total'];?>
                        </h1>
                    </div>
            </div>
            <!--Fin de la case 1-->
            <!--Debut de la case 1-->
            <div class="card bg-dark">
                <div class="card-header"><i class="fas fa-money-check-alt"></i>&nbsp;Total Revenu Généré</div>
                    <div class="card-body">
                        <h1 class="display-4">
                             <?php  $data=$count->caisseTotalGeneral($cid_ag); echo $data['Totals'];?>
                        </h1>
                    </div>
            </div>
            <!--Fin de la case 1-->
            <!--Debut de la case 1-->
            <div class="card bg-warning">
                <div class="card-header"><i class="fab fa-buffer"></i>&nbsp;Total Bon Retrait</div>
                    <div class="card-body">
                        <h1 class="display-4">
                           <?= $count->totalCounts($cid_ag);?>
                        </h1>
                    </div>
            </div>
            <!--Fin de la case 1-->
        </div>        
    </div>
</div>
<!--Fin de la ligne 2-->
<?php else:?>
    <h1 class="text-center text-secondary mt-5">Vous n'êtes autorisé à voir les contenues de cette page !</h1>
<?php endif;?>
</div>
    <!--Footer Area-->
            </div>
        </div>
     </div>
<?php
    require_once '../php/footer.php';
?>
</body>
</html>