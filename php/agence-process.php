<?php
    require_once 'session.php';

     //Gérer la requête d'insertion d'un client avec Ajax
     if(isset($_POST['action']) && $_POST['action']=='add_client'){
        $nom=$cuser->test_input($_POST['nom']);
        $prenom=$cuser->test_input($_POST['prenom']);
        $telephone=$cuser->test_input($_POST['telephone']);
        
        $cuser->client($nom,$prenom,$telephone,$cid_ag);
        //print_r($_POST);
     }

    //Gérer la requête d'affichages des clients avec Ajax
    if(isset($_POST['action'])&& $_POST['action']=='fetchAllClients'){
        $output='';
        $clients=$cuser->fetchAllClients($cid_ag);
        if($clients){
           $output .='
               <table class="table table-striped table-sm text-justify">
                   <thead>
                       <tr>
                           <th>ID</th>
                           <th>Nom Client</th>
                           <th>Prénom Client</th>
                           <th>Téléphone</th>
                           <th>Date</th>
                           <th>Action</th>
                       </tr>
                   </thead>
                   <tbody>';
               foreach ($clients as $row){
                       $output .='
                       <tr>
                           <td>'.$row['id'].'</td>
                           <td>'.$row['nom'].'</td>
                           <td>'.$row['prenom'].'</td>
                           <td>'.$row['telephone'].'</td>
                           <td>'.$row['date_created'].'</td>
                           <td class="text-center">
                               <a href="#" id="'.$row['id'].'" title="Editer Client" class="text-primary editclientBtn" data-toggle="modal" data-target="#editClientModal"><i class="fas fa-edit fa-lg"></i></a>&nbsp;

                               <a href="#" id="'.$row['id'].'" title="Supprimer Client" class="text-danger deleteclientBtn"><i class="fas fa-trash-alt fa-lg"></i></a>
                           </td>
                       </tr>';
               }
               $output .='</tbody></table>';
               echo $output;
       }
       else{
           echo '<h3 class="text-center text-secondary">:( Pas encore des clients  crééent !</h3>';
       }
   }

   //Gérer la suppression d'un client en Ajax Request
   if(isset($_POST['del_client_id'])){
    $id=$_POST['del_client_id'];
    $cuser->clientDelete($id);
   }



   //Gérer la requête d'insertion d'un bénéficiaire avec Ajax
   if(isset($_POST['action']) && $_POST['action']=='add_beneficiaire'){
    $nomBen=$cuser->test_input($_POST['nomBen']);
    $postnomBen=$cuser->test_input($_POST['postnomBen']);
    $prenomBen=$cuser->test_input($_POST['prenomBen']);
    $adresseBen=$cuser->test_input($_POST['adresseBen']);
    $telephoneBen=$cuser->test_input($_POST['telephoneBen']);
    $client_ben_id=$cuser->test_input($_POST['client_ben_id']);
    
    $cuser->beneficiaire($nomBen,$postnomBen,$prenomBen,$telephoneBen,$adresseBen,$client_ben_id,$cid_ag);
    //print_r($_POST);
 }

//Gérer la requête d'affichages des bénéficiaires avec Ajax
if(isset($_POST['action'])&& $_POST['action']=='fetchAllBeneficiaires'){
    $output='';
    $beneficiaires=$cuser->fetchAllBeneficiaires($cid_ag);
    if($beneficiaires){
       $output .='
           <table class="table table-striped table-sm text-justify">
               <thead>
                   <tr>
                       <th>ID</th>
                       <th>Nom Client</th>
                       <th>Prénom Client</th>
                       <th>Téléphone</th>
                       <th>Nom Ben.</th>
                       <th>Prénom Ben.</th>
                       <th>Téléphone Ben.</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <tbody>';
           foreach ($beneficiaires as $row){
                   $output .='
                   <tr>
                       <td>'.$row['id'].'</td>
                       <td>'.$row['nom'].'</td>
                       <td>'.$row['prenom'].'</td>
                       <td>'.$row['telephone'].'</td>
                       <td>'.$row['nomBen'].'</td>
                       <td>'.$row['prenomBen'].'</td>
                       <td>'.$row['telephoneBen'].'</td>
                       <td class="text-center">
                           <a href="#" id="'.$row['id'].'" title="Editer Bénéficiaire" class="text-primary editclientBtn" data-toggle="modal" data-target="#editBeneficiaireModal"><i class="fas fa-edit fa-lg"></i></a>&nbsp;

                           <a href="#" id="'.$row['id'].'" title="Supprimer Bénéficiaire" class="text-danger deletebeneficiaireBtn"><i class="fas fa-trash-alt fa-lg"></i></a>
                       </td>
                   </tr>';
           }
           $output .='</tbody></table>';
           echo $output;
   }
   else{
       echo '<h3 class="text-center text-secondary">:( Pas encore des bénéficiaires  crééent !</h3>';
   }
}

//Gérer la suppression d'un bénéficiaire en Ajax Request
if(isset($_POST['del_ben_id'])){
$id=$_POST['del_ben_id'];
$cuser->beneficiaireDelete($id);
}


//Gérer la requête d'insertion d'une Transaction de Fonds avec Ajax
if(isset($_POST['action']) && $_POST['action']=='add_transaction'){
    $codeTrans=$cuser->test_input($_POST['codeTrans']);
    $montantTrans=$cuser->test_input($_POST['montantTrans']);
    $pourcentage=$cuser->test_input($_POST['pourcentage']);
    $client_id=$cuser->test_input($_POST['client_id']);
    $agence_dest_id=$cuser->test_input($_POST['agence_dest_id']);
    $cuser->clientTransaction($client_id);
    $cuser->transactions($codeTrans,$montantTrans,$pourcentage,$client_id,$cid_ag,$agence_dest_id);
    //print_r($_POST);
 }

//Gérer la requête d'affichages des transactions des fonds avec Ajax
if(isset($_POST['action'])&& $_POST['action']=='fetchAllTransactions'){
    $output='';
    $transactions=$cuser->fetchAllTransactionsFonds($cid_ag);
    if($transactions){
       $output .='
           <table class="table table-striped table-sm text-justify">
               <thead>
                   <tr>
                       <th>ID</th>
                       <th>Client</th>
                       <th>Prénom Cl.</th>
                       <th>Phone Cl.</th>
                       <th>Nom Ben.</th>
                       <th>Prénom Ben.</th>
                       <th>Phone Ben.</th>
                       <th>Code Trans.</th>
                       <th>Montant Trans.</th>
                       <th>%</th>
                       <th>Frais Trans.</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <tbody>';
           foreach ($transactions as $row){
                   $output .='
                   <tr>
                       <td>'.$row['id'].'</td>
                       <td>'.$row['nom'].'</td>
                       <td>'.$row['prenom'].'</td>
                       <td>'.$row['telephone'].'</td>
                       <td>'.$row['nomBen'].'</td>
                       <td>'.$row['prenomBen'].'</td>
                       <td>'.$row['telephoneBen'].'</td>
                       <td>'.$row['codeTrans'].'</td>
                       <td>'.$row['montantTrans'].'</td>
                       <td>'.$row['pourcentage'].'</td>
                       <td>'.$row['Frais_transaction'].'</td>
                       <td class="text-center">
                           <a href="#" id="'.$row['id'].'" title="Editer Transaction de Fonds" class="text-primary editTransactionBtn" data-toggle="modal" data-target="#editTransactionModal"><i class="fas fa-edit fa-lg"></i></a>&nbsp;

                           <a href="#" id="'.$row['id'].'" title="Supprimer Transaction de Fonds" class="text-danger deletetransactionBtn"><i class="fas fa-trash-alt fa-lg"></i></a>
                       </td>
                   </tr>';
           }
           $output .='</tbody></table>';
           echo $output;
   }
   else{
       echo '<h3 class="text-center text-secondary">:( Pas encore des Transactions de Fonds crééent !</h3>';
   }
}

//Gérer la requête d'affichages des transactions des fonds avec Ajax
if(isset($_POST['action'])&& $_POST['action']=='fetchAllTransactionsF'){
    $output='';
    $transactions=$cuser->fetchAllTransactionsFondsF($cid_ag);
    if($transactions){
       $output .='
           <table class="table table-striped table-sm text-justify">
               <thead>
                   <tr>
                       <th>ID</th>
                       <th>Client</th>
                       <th>Prénom Cl.</th>
                       <th>Phone Cl.</th>
                       <th>Nom Ben.</th>
                       <th>Prénom Ben.</th>
                       <th>Phone Ben.</th>
                       <th>Code Trans.</th>
                       <th>Montant Trans.</th>
                       <th>Etat Trans.</th>
                       <th>Agence Exp.</th>
                   </tr>
               </thead>
               <tbody>';
           foreach ($transactions as $row){
                   $output .='
                   <tr>
                       <td>'.$row['id'].'</td>
                       <td>'.$row['nom'].'</td>
                       <td>'.$row['prenom'].'</td>
                       <td>'.$row['telephone'].'</td>
                       <td>'.$row['nomBen'].'</td>
                       <td>'.$row['prenomBen'].'</td>
                       <td>'.$row['telephoneBen'].'</td>
                       <td>'.$row['codeTrans'].'</td>
                       <td>'.$row['montantTrans'].'</td>
                       <td>'.$row['etat_transfert'].'</td>
                       <td>'.$row['Ag'].'</td>
                   </tr>';
           }
           $output .='</tbody></table>';
           echo $output;
   }
   else{
       echo '<h3 class="text-center text-secondary">:( Pas encore des Transactions de Fonds reçues ici !</h3>';
   }
}

//Gérer la suppression d'une transaction de fonds en Ajax Request
if(isset($_POST['del_trans_id'])){
    $id=$_POST['del_trans_id'];
    //$cuser->clientTransaction($id);
    $cuser->transactionDelete($id);
}

//Gérer la requête d'insertion d'un bon de retrait de fonds avec Ajax
if(isset($_POST['action']) && $_POST['action']=='add_bon'){
    $motif=$cuser->test_input($_POST['motif']);
    $date_create=$cuser->test_input($_POST['date_create']);
    $beneficiaire_id=$cuser->test_input($_POST['beneficiaire_id']);
    $etat_transaction=$cuser->test_input($_POST['etat_transaction']);
    $cuser->etatBeneficiaireTransaction($beneficiaire_id);
    $cuser->etatTransaction($etat_transaction);
    $cuser->retraitFondstransactions($motif,$date_create,$beneficiaire_id,$cid_ag,$etat_transaction);
    //print_r($_POST);
 }

 //Gérer la requête d'affichages des transactions des fonds avec Ajax
if(isset($_POST['action'])&& $_POST['action']=='fetchAllBonRetraitTransactions'){
    $output='';
    $bonretraits=$cuser->fetchAllBonRetraitTransactions($cid_ag);
    if($bonretraits){
       $output .='
           <table class="table table-striped table-sm text-justify">
               <thead>
                   <tr>
                       <th>ID</th>
                       <th>Motif Bon Retrait</th>
                       <th>Date Bon Retrait</th>
                       <th>Bénéficiaire Bon Retrait</th>
                       <th>Prénom Bénéficiaire</th>
                       <th>Montant Bon Retrait</th>
                   </tr>
               </thead>
               <tbody>';
           foreach ($bonretraits as $row){
                   $output .='
                   <tr>
                       <td>'.$row['id_bon'].'</td>
                       <td>'.$row['motif'].'</td>
                       <td>'.$row['date_create'].'</td>
                       <td>'.$row['nomBen'].'</td>
                       <td>'.$row['prenomBen'].'</td>
                       <td>'.$row['montantTrans'].'</td>
                   </tr>';
           }
           $output .='</tbody></table>';
           echo $output;
   }
   else{
       echo '<h3 class="text-center text-secondary">:( Pas encore des bons des retraits créent!</h3>';
   }
}


?>