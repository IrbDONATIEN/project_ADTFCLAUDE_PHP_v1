<?php
    require_once 'php/admin-header.php';
    require_once 'php/admin-db.php';

    $count=new Admin();
?>

        <!--Debut de la ligne 1-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-deck mt-3 text-light text-center font-weight-bold">
                    
                    <!--Debut de la case 1-->
                    <div class="card bg-primary">
                        <div class="card-header">Total Provinces</div>
                            <div class="card-body">
                                <h1 class="display-4">
                                    <?= $count->totalCount('provinces');?>
                                </h1>
                            </div>
                    </div>
                    <!--Fin de la case 1-->
                    
                     <!--Debut de la case 2-->
                     <div class="card bg-warning">
                        <div class="card-header">Total Agences</div>
                            <div class="card-body">
                                <h1 class="display-4">
                                   <?= $count->totalCount('agence');?>
                                </h1>
                            </div>
                    </div>
                    <!--Fin de la case 2-->

                     <!--Debut de la case 3-->
                     <div class="card bg-success">
                        <div class="card-header">Total Guichets</div>
                            <div class="card-body">
                                <h1 class="display-4">
                                   <?= $count->totalCount('guichets');?>
                                </h1>
                            </div>
                    </div>
                    <!--Fin de la case 3-->

                     <!--Debut de la case 4-->
                     <div class="card bg-danger">
                        <div class="card-header">Total des visites</div>
                            <div class="card-body">
                                <h1 class="display-4">
                                   <?php  $data=$count->site_hits(); echo $data['hits'];?>
                                </h1>
                            </div>
                    </div>
                    <!--Fin de la case 4-->

                </div>
            </div>
        </div>
        <!--Fin de la ligne 1-->

        <!--Debut de la ligne 2-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-deck mt-3 text-light text-center font-weight-bold">
                    <!--Debut de la case 1-->
                    <div class="card bg-secondary">
                        <div class="card-header">Total Responsables</div>
                        <h1 class="display-4">
                            <?= $count->totalCount('responsables');?>
                        </h1>
                    </div>
                    <!--Fin de la case 1-->

                    <!--Debut de la case 2-->
                    <div class="card bg-success">
                        <div class="card-header"> Total Montant Revenu Généré</div>
                        <h1 class="display-4">
                            <?php  $data=$count->caisseTotalGeneral(); echo $data['Totals'];?>
                        </h1>
                    </div>
                    <!--Fin de la case 2-->

                    <!--Debut de la case 3-->
                    <div class="card bg-info">
                        <div class="card-header">Total Montant Perçu</div>
                        <h1 class="display-4">
                            <?php  $data=$count->caisseTotalGenerals(); echo $data['Total'];?>
                        </h1>
                    </div>
                    <!--Fin de la case 3-->

                </div>
            </div>
        </div>
        <!--Fin de la ligne 2-->

        <!--Début de la ligne 3-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-deck my-3">

                       <!--Début de la case 2-->
                        <div class="card border-success">
                            <div class="card-header bg-success text-center text-white lead">
                                Nombre de pourcentage de Responsable Masculin/Féminin
                            </div>
                            <div id="chatOne" style="width:99%; height: 400px;"></div>
                        </div>
                      <!--Fin de la case 1-->
                </div>
            </div>
        </div>
        <!--Fin de la ligne 3-->

        <!--Footer Area-->
            </div>
        </div>
     </div>

     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
     <script type="text/javascript">

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
        
        google.charts.load("current",{packages:["corechart"]});
            google.charts.setOnLoadCallback(pieChart);
            function pieChart(){
                var data=google.visualization.arrayToDataTable([
                    ['Gender', 'Number'],
                    <?php
                        $sexe=$count->genreResponsable();
                        foreach($sexe as $row){
                            echo '[" '.$row['sexe'].'",'.$row['number'].'],';
                        }
                    ?>
                ]);
                var options ={
                    is3D:false
                };
                var chart=new google.visualization.PieChart(document.getElementById('chatOne'));
                chart.draw(data, options);
            }
     </script>
</body>
</html>