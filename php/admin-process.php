<?php
    session_start();
    require_once 'admin-db.php';
    $process=new Admin();

    //Préparation d'enregistrement de données du responsable avec la requete Ajax
    if(isset($_POST['action']) && $_POST['action'] =='register'){

        $matricule=$process->test_input($_POST['matricule']);
        $idrole=$process->test_input($_POST['idrole']);
        $nom=$process->test_input($_POST['nom']);
        $postnom=$process->test_input($_POST['postnom']);
        $prenom=$process->test_input($_POST['prenom']);
        $sexe=$process->test_input($_POST['sexe']);
        $loginU=$process->test_input($_POST['loginU']);
        $passwordU=$process->test_input($_POST['passwordU']);
        $email=$process->test_input($_POST['email']);
        $adresse=$process->test_input($_POST['adresse']);
        $telephone=$process->test_input($_POST['telephone']);
        $id_ag=$process->test_input($_POST['id_ag']);
        $process->responsable($matricule,$idrole,$nom,$postnom,$prenom,$sexe,$loginU,$passwordU,$email,$adresse,$telephone,$id_ag);
    
    }

    //Préparation d'enregistrement de données d'agence avec la requete Ajax
    if(isset($_POST['action']) && $_POST['action'] =='add_agence'){
        $codAg=$process->test_input($_POST['codAg']);
        $idprov=$process->test_input($_POST['idprov']);
        $matriculeFiscale=$process->test_input($_POST['matriculeFiscale']);
        $nomAg=$process->test_input($_POST['nomAg']);
        $adresseAg=$process->test_input($_POST['adresseAg']);
        $telephone=$process->test_input($_POST['telephone']);
        $emailAg=$process->test_input($_POST['emailAg']);
        $process->agences($codAg,$idprov,$matriculeFiscale,$nomAg,$adresseAg,$telephone,$emailAg);
    }

    //Préparation d'enregistrement de données de guichet avec la requete Ajax
    if(isset($_POST['action']) && $_POST['action'] =='add_guichet'){
        $codeGuichet=$process->test_input($_POST['codeGuichet']); 
        $nomGuichet=$process->test_input($_POST['nomGuichet']);
        $idAg=$process->test_input($_POST['idAg']);
        $process->guichets($codeGuichet,$nomGuichet,$idAg);
        
    }

    //Préparation d'enregistrement de données d'horaire de travail avec la requete Ajax
    if(isset($_POST['action']) && $_POST['action'] =='add_horaire'){
        $heure_debut=$process->test_input($_POST['heure_debut']);
        $heure_fin=$process->test_input($_POST['heure_fin']); 
        $process->add_horaire($heure_debut,$heure_fin);
    }




?>