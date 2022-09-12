<?php
    session_start();
    require_once 'admin-db.php';
    $admin=new Admin();
    require_once 'agence-db.php';
    $agence=new Agence();
   
    
    //Handle Admin Login Ajax Request
    if(isset($_POST['action'])&& $_POST['action']=='adminLogin'){
        $username=$admin->test_input($_POST['username']);
        $password=$admin->test_input($_POST['password']);

        $hpassword=sha1($password);

        $loggedInAdmin=$admin->admin_login($username,$hpassword);

        if($loggedInAdmin !=null){
            echo 'admin_login';
            $_SESSION['username']=$username;
        }
        else{
            echo $admin->showMessage('danger', 'Username ou Password est incorrect!');
        }
    }

    //Handle Agence Login Ajax Request
    if(isset($_POST['action'])&& $_POST['action']=='agenceLogin'){
        $login=$agence->test_input($_POST['login']);
        $password=$agence->test_input($_POST['password']);
        $idrole=$agence->test_input($_POST['idrole']);

        $loggedInAgence=$agence->loginUser($login,$password,$idrole);

        if($loggedInAgence !=null){
            echo 'agence_login';
            $_SESSION['user']=$login;
        }
        else{
            echo $agence->showMessage('danger', 'Login ou Mot de passe ou role est incorrect !');
        }
    }


    //Gérer la requête d'insertion des Provinces avec Ajax
    if(isset($_POST['action']) && $_POST['action']=='add_province'){
        $province=$admin->test_input($_POST['province']);

        //$admin->province($province);

        //Vérifier si la province saisie existe déjà
        if($admin->province_exist($province)){
            echo $admin->showMessage('warning', 'Cette province est déjà enregistrée!');
        }else{
            if($admin->province($province)){
            }else{
                echo $admin->showMessage('danger', 'Un problème est survenu! Réessayez plus tard.');
            }
        }

     }

     
    //Gérer la requête Fetch All Provinces Ajax
    if(isset($_POST['action']) && $_POST['action']=='fetchAllProvinces'){
        $output='';
        $province=$admin->fetchAllProvinces();

        if($province){
            $output .='
                <table class="table table-striped table-sm table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Province</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($province as $row){
                        $output .='<tr>
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['nomProvince'].'</td>
                                        <td>
                                            
                                            <a href="#" id="'.$row['id'].'" title="Voir détail province" class="text-success infoProvinceBtn"><i class="fas fa-info-circle fa-lg"></i>&nbsp;</a>

                                            <a href="#" id="'.$row['id'].'" title="Editer Province" class="text-primary editerProvinceIcon" data-toggle="modal" data-target="#editProvinceModal" ><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;

                                            <a href="#" id="'.$row['id'].'" title="Supprimer Province" class="text-danger deleteProvinceIcon"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp;
                                        </td>
                                   </tr>';
                    }
                    $output .='
                    </tbody>
                    </table>';
                    echo $output;
        }
        else{
            echo '<h3 class="text-center text-secondary">:( Pas encore de province créée !</h3>';
        }
    }

    //Gérer la demande supprimée de la province d'Ajax
    if(isset($_POST['province_id'])){
        $id=$_POST['province_id'];

        $admin->deleteProvince($id);
    }

    //Gérer la demande d'affichage avant la modification de la province d'Ajax
    if(isset($_POST['editprovince_id'])){
        $id=$_POST['editprovince_id'];

        $row=$admin->editerprovince($id);
        echo json_encode($row);
    }

    //Gérer la demande  de la mise à jour de province de l'utilisateur avec Ajax
    if(isset($_POST['action']) && $_POST['action']=='update_province'){
        $id=$admin->test_input($_POST['id']);
        $province=$admin->test_input($_POST['eprovince']);

        $admin->update_province($id,$province);
    }
    
    //Affichage de détail de la province avec la demande Ajax
    if(isset($_POST['infoprovince_id'])){
        $id=$_POST['infoprovince_id'];
        
        $row=$admin->editerprovince($id);

        echo json_encode($row);
    }


    //Gérer la requête Fetch All Rôles Ajax
    if(isset($_POST['action']) && $_POST['action']=='fetchAllRoles'){
        $output='';
        $roles=$admin->fetchAllRoles();

        if($roles){
            $output .='
                <table class="table table-striped table-sm table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Province</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($roles as $row){
                        $output .='<tr>
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['nomRole'].'</td>
                                        <td>
                                            
                                            <a href="#" id="'.$row['id'].'" title="Voir détail rôle" class="text-success infoRolesBtn"><i class="fas fa-info-circle fa-lg"></i>&nbsp;</a>

                                            <a href="#" id="'.$row['id'].'" title="Editer Rôle" class="text-primary editerRolesIcon" data-toggle="modal" data-target="#editRolesModal" ><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;

                                            <a href="#" id="'.$row['id'].'" title="Supprimer Rôle" class="text-danger deleteRolesIcon"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp;
                                        </td>
                                   </tr>';
                    }
                    $output .='
                    </tbody>
                    </table>';
                    echo $output;
        }
        else{
            echo '<h3 class="text-center text-secondary">:( Pas encore de rôle créée !</h3>';
        }
    }

    //Gérer la demande supprimé le rôle d'Ajax
    if(isset($_POST['role_id'])){
        $id=$_POST['role_id'];

        $admin->deleteRoles($id);
    }

    //Affichage de détail de rôle avec la demande Ajax
    if(isset($_POST['inforole_id'])){
        $id=$_POST['inforole_id'];
        
        $row=$admin->editerRoles($id);

        echo json_encode($row);
    }

    //Gérer la demande d'affichage avant la modification de la province d'Ajax
    if(isset($_POST['editrole_id'])){
        $id=$_POST['editrole_id'];

        $row=$admin->editerRoles($id);
        echo json_encode($row);
    }

    //Gérer la demande  de la mise à jour de rôle de l'utilisateur avec Ajax
    if(isset($_POST['action']) && $_POST['action']=='update_role'){
        $id=$admin->test_input($_POST['id']);
        $roles=$admin->test_input($_POST['erole']);

        $admin->update_roles($id,$roles);
    }

    //Gérer la requête d'insertion des Rôles avec Ajax
    if(isset($_POST['action']) && $_POST['action']=='add_role'){
        $roles=$admin->test_input($_POST['role']);

        //Vérifier si le rôle saisie existe déjà
        if($admin->roles_exist($roles)){
            echo json_encode($admin->showMessage('warning', 'Ce rôle est déjà enregistré!'));exit;
        }else{
            if($admin->roles($roles)){
            }else{
                echo json_encode($admin->showMessage('danger', 'Un problème est survenu! Réessayez plus tard.'));exit;
            }
        }

    }

    //Gérer la requête Fetch All Responsables Ajax
    if(isset($_POST['action']) && $_POST['action']=='fetchAllResponsables'){
        $output='';
        $responsable=$admin->fetchAllResponsables(1);

        if($responsable){
            $output .='
                <table class="table table-striped table-sm table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Sexe</th>
                            <th>E-Mail</th>
                            <th>Adresse</th>
                            <th>Télephone</th>
                            <th>Rôle</th>
                            <th>Code Ag.</th>
                            <th>Agence</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($responsable as $row){
                        $output .='<tr>
                                        <td>'.$row['matricule'].'</td>
                                        <td>'.$row['nom'].'</td>
                                        <td>'.$row['prenom'].'</td>
                                        <td>'.$row['sexe'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['adresse'].'</td>
                                        <td>'.$row['telephone'].'</td>
                                        <td>'.$row['nomRole'].'</td>
                                        <td>'.$row['codAg'].'</td>
                                        <td>'.$row['nomAg'].'</td>
                                        <td>
                                            
                                            <a href="#" matricule="'.$row['matricule'].'" title="Voir détail responsable" class="text-success infoResponsablesBtn"><i class="fas fa-info-circle fa-lg"></i>&nbsp;</a>

                                            <a href="#" matricule="'.$row['matricule'].'" title="Editer responsable" class="text-primary editerResponsablesIcon" data-toggle="modal" data-target="#editResponsablesModal" ><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;

                                            <a href="#" matricule="'.$row['matricule'].'" title="Supprimer responsable" class="text-danger deleteResponsablesIcon"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp;
                                        </td>
                                   </tr>';
                    }
                    $output .='
                    </tbody>
                    </table>';
                    echo $output;
        }
        else{
            echo '<h3 class="text-center text-secondary">:( Pas encore de responsable créée !</h3>';
        }
    }

     //Handle Restore Deleted Responsable Ajax Request
     if(isset($_POST['del_matr'])){

        $matricule=$_POST['del_matr'];
        
        $admin->responsableAction($matricule, 0);
    }
    
    //Gérer la requête Fetch All Responsables supprimés avec Ajax
    if(isset($_POST['action']) && $_POST['action']=='fetchAllDeletedResponsables'){
        $output='';
        $responsable_del=$admin->fetchAllResponsables(0);

        if($responsable_del){
            $output .='
                <table class="table table-striped table-sm table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Sexe</th>
                            <th>E-Mail</th>
                            <th>Adresse</th>
                            <th>Télephone</th>
                            <th>Rôle</th>
                            <th>Code Ag.</th>
                            <th>Agence</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($responsable_del as $row){
                        $output .='<tr>
                                        <td>'.$row['matricule'].'</td>
                                        <td>'.$row['nom'].'</td>
                                        <td>'.$row['prenom'].'</td>
                                        <td>'.$row['sexe'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['adresse'].'</td>
                                        <td>'.$row['telephone'].'</td>
                                        <td>'.$row['nomRole'].'</td>
                                        <td>'.$row['codAg'].'</td>
                                        <td>'.$row['nomAg'].'</td>
                                        <td>
                                            <a href="#" matricule="'.$row['matricule'].'" title="Restaurer responsable" class="text-white restoreResponsablesIcon badge badge-dark p-2">Restaurer</a>
                                        </td>
                                   </tr>';
                    }
                    $output .='
                    </tbody>
                    </table>';
                    echo $output;
        }
        else{
            echo '<h3 class="text-center text-secondary">:( Pas encore de responsable supprimé !</h3>';
        }
    }

    //Handle Restore Deleted Responsable Ajax Request
    if(isset($_POST['resp_matr'])){

        $matricule=$_POST['resp_matr'];

        $admin->responsableAction($matricule, 1);
    }

    //Affichage de détail de responsable avec la demande Ajax
    if(isset($_POST['inforespo_matr'])){
        
        $matricule=$_POST['inforespo_matr'];
        
        $row=$admin->editerResponsables($matricule);

        echo json_encode($row);
    }

    //Handle Fetch Notification Ajax Request
    if(isset($_POST['action'])&& $_POST['action']=='fetchNotification'){
        $notification=$admin->fetchNotification();
        $output='';

        if($notification){
            foreach ($notification as $row){
               $output .='<div class="alert alert-success" role="alert">
                    <button type="button" id="'.$row['id'].'" class="close" data-dismiss="alert" aria-label="Close" title="Supprimer la notification">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading">Nouvelle Notification</h4>
                    <p class="mb-0 lead">'.$row['message'].' écrite par : <b>'.$row['nom'].'</b></p>
                    <hr class="my-2">
                    <p class="mb-0 float-left"><b>User E-mail :</b>'.$row['email'].'</p>
                    <p class="mb-0 float-right">'.$admin->timeInAgo($row['created_at']).'</p>
                    <div class="clearfix"></div>
                </div>'; 
            }
            echo $output;
        }
        else{
            echo '<h3 class="text-center text-primary mt-5">Pas une nouvelle notification </h3>';
        }
    }

     //Handle Check Notification
     if(isset($_POST['action'])&& $_POST['action']=='checkNotification'){
        if($admin->fetchNotification()){
            echo '<i class="fas fa-circle text-danger fa-sm" ></i>';
        }
        else{
            echo '';
        }
    }

    //Handle Remove Notification 
    if(isset($_POST['notification_id'])){
        $id=$_POST['notification_id'];
        $admin->removeNotification($id);
    }


//Gérer la requête Fetch All Agences Ajax
if(isset($_POST['action']) && $_POST['action']=='fetchAllAgences'){
    $output='';
    $agences=$admin->fetchAllAgences(1);

    if($agences){
        $output .='
            <table class="table table-striped table-sm table-bordered text-center">
                <thead>
                    <tr>
                        <th>Code Agence</th>
                        <th>Agence</th>
                        <th>Matricule Fiscale</th>
                        <th>Adresse Agence</th>
                        <th>Téléphone</th>
                        <th>E-mail</th>
                        <th>Province</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($agences as $row){
                    $output .='<tr>
                                    <td>'.$row['codAg'].'</td>
                                    <td>'.$row['nomAg'].'</td>
                                    <td>'.$row['matriculeFiscale'].'</td>
                                    <td>'.$row['adresseAg'].'</td>
                                    <td>'.$row['telephone'].'</td>
                                    <td>'.$row['emailAg'].'</td>
                                    <td>'.$row['nomProvince'].'</td>
                                    <td>
                                        
                                        <a href="#" id="'.$row['idag'].'" title="Voir détail agence" class="text-success infoAgencesBtn"><i class="fas fa-info-circle fa-lg"></i>&nbsp;</a>

                                        <a href="#" id="'.$row['idag'].'" title="Editer agence" class="text-primary editerAgencesIcon" data-toggle="modal" data-target="#editResponsablesModal" ><i class="fas fa-edit fa-lg"></i></a>&nbsp;

                                        <a href="#" id="'.$row['idag'].'" title="Supprimer agence" class="text-danger deleteAgencesIcon"><i class="fas fa-trash-alt fa-lg"></i></a>
                                    </td>
                               </tr>';
                }
                $output .='
                </tbody>
                </table>';
                echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( Pas encore d\'agences crééent !</h3>';
    }
}

//Gérer la requête Fetch All Agences supprimées Ajax
if(isset($_POST['action']) && $_POST['action']=='fetchAllAgencesDel'){
    $output='';
    $agences=$admin->fetchAllAgences(0);

    if($agences){
        $output .='
            <table class="table table-striped table-sm table-bordered text-center">
                <thead>
                    <tr>
                        <th>Code Agence</th>
                        <th>Agence</th>
                        <th>Matricule Fiscale</th>
                        <th>Adresse Agence</th>
                        <th>Téléphone</th>
                        <th>E-mail</th>
                        <th>Province</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($agences as $row){
                    $output .='<tr>
                                    <td>'.$row['codAg'].'</td>
                                    <td>'.$row['nomAg'].'</td>
                                    <td>'.$row['matriculeFiscale'].'</td>
                                    <td>'.$row['adresseAg'].'</td>
                                    <td>'.$row['telephone'].'</td>
                                    <td>'.$row['emailAg'].'</td>
                                    <td>'.$row['nomProvince'].'</td>
                                    <td>
                                        
                                         <a href="#" id="'.$row['idag'].'" title="Restaurer Agence" class="text-white restoreAgnecesDelIcon badge badge-dark p-2">Restaurer</a>

                                    </td>
                               </tr>';
                }
                $output .='
                </tbody>
                </table>';
                echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( Pas encore d\'agences supprimées !</h3>';
    }
}

//Handle Restore Deleted Agence Ajax Request
if(isset($_POST['rest_agence'])){

    $id=$_POST['rest_agence'];

    $admin->agenceAction($id, 1);
}

//Handle Restore Deleted Agence Ajax Request
if(isset($_POST['del_agence'])){

    $id=$_POST['del_agence'];
    
    $admin->agenceAction($id, 0);
}


//Gérer la requête Fetch All Guichets Ajax
if(isset($_POST['action']) && $_POST['action']=='fetchAllGuichets'){
    $output='';
    $guichets=$admin->fetchAllGuichets();

    if($guichets){
        $output .='
            <table class="table table-striped table-sm table-bordered text-center">
                <thead>
                    <tr>
                        <th>Code Agence</th>
                        <th>Agence</th>
                        <th>Code Guichet</th>
                        <th>Guichet</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($guichets as $row){
                    $output .='<tr>
                                    <td>'.$row['codAg'].'</td>
                                    <td>'.$row['nomAg'].'</td>
                                    <td>'.$row['codeGuichet'].'</td>
                                    <td>'.$row['nomGuichet'].'</td>
                                    <td>
                                        
                                        <a href="#" id="'.$row['codeGuichet'].'" title="Voir détail guichet" class="text-success infoGuichetsBtn"><i class="fas fa-info-circle fa-lg"></i>&nbsp;</a>

                                        <a href="#" id="'.$row['codeGuichet'].'" title="Editer guichet" class="text-primary editerGuichetsIcon" data-toggle="modal" data-target="#editGuichetsModal" ><i class="fas fa-edit fa-lg"></i></a>&nbsp;

                                        <a href="#" id="'.$row['codeGuichet'].'" title="Supprimer guichet" class="text-danger deleteGuichetsIcon"><i class="fas fa-trash-alt fa-lg"></i></a>
                                    </td>
                               </tr>';
                }
                $output .='
                </tbody>
                </table>';
                echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( Pas encore des guichets crééent !</h3>';
    }
}

//Handle Restore Deleted Guichet Ajax Request
if(isset($_POST['del_guichet'])){

    $id=$_POST['del_guichet'];
    
    $admin->guichetAction($id);
}

//Gérer la requête Fetch All Agences supprimées Ajax
if(isset($_POST['action']) && $_POST['action']=='fetchAllHoraires'){
    $output='';
    $horaires=$admin->fetchAllHoraires();

    if($horaires){
        $output .='
            <table class="table table-striped table-sm table-bordered text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Heure du début</th>
                        <th>Heure de la fin</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($horaires as $row){
                    $output .='<tr>
                                    <td>'.$row['id'].'</td>
                                    <td>'.$row['heure_debut'].'</td>
                                    <td>'.$row['heure_fin'].'</td>
                                    <td>
                                        
                                         <a href="#" id="'.$row['id'].'" title="Supprimer Horaire" class="text-danger deleteHorairesIcon"><i class="fas fa-trash-alt fa-lg"></i></a>

                                    </td>
                               </tr>';
                }
                $output .='
                </tbody>
                </table>';
                echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( Pas encore d\'horaires créeent !</h3>';
    }
}

//Handle Restore Deleted Horaire Ajax Request
if(isset($_POST['del_horaire'])){

    $id=$_POST['del_horaire'];
    
    $admin->horaireAction($id);
}

?>