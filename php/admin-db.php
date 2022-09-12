<?php
    require_once 'config.php';

    class Admin extends Database{

        //Admin Login
        public function admin_login($username, $password){
            $sql="SELECT username, password FROM admin WHERE username=:username AND password =:password";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['username'=>$username, 'password'=>$password]);
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        //Compteur de nombres des lignes dans chaque tables
        public function totalCount($tablename){
            $sql="SELECT * FROM $tablename";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $count=$stmt->rowCount();
            return $count;
        }

        //Enregistrer une nouvelle province
        public function province($province){
            $sql="INSERT INTO provinces (nomProvince) VALUES (:province)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['province'=>$province]);
            return true;
        }

        //Vérifier si la province existe déjà dans la base de données
        public function province_exist($province){
            $sql="SELECT nomProvince FROM province WHERE nomProvince=:province";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['province'=>$province]);
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        //Affichage avant l'édition de province existante dans la base de données
        public function editerprovince($id){
            $sql="SELECT * FROM provinces WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

        //Edition proprement dite de la province
        public function update_province($id, $province){
            $sql="UPDATE provinces SET nomProvince=:nomProvince WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['nomProvince'=>$province, 'id'=>$id]);
            return true;
        }

         //Montant Général Généré  
         public function caisseTotalGenerals(){
            $sql="SELECT id,codeTrans,SUM(montantTrans) as Total,pourcentage,etat_transfert,date_enreg,client_id,agence_exp_id,agence_dest_id FROM transfert";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $count=$stmt->fetch(PDO::FETCH_ASSOC);
            return $count;
        }

         //Montant Général Revenu Généré  
         public function caisseTotalGeneral(){
            $sql="SELECT id,codeTrans,SUM(montantTrans*pourcentage/100) as Totals,etat_transfert,date_enreg,client_id,agence_exp_id,agence_dest_id FROM transfert";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $count=$stmt->fetch(PDO::FETCH_ASSOC);
            return $count;
        }

        //Classe province pour afficher toutes les provinces
         public function fetchAllProvinces(){
            $sql="SELECT provinces.id, provinces.nomProvince FROM provinces";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

         //Delete A Province of An Province by Admin
         public function deleteProvince($id){
            $sql="DELETE FROM provinces WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

        //Classe rôles pour afficher tous les rôles
        public function fetchAllRoles(){
            $sql="SELECT roles.id, roles.nomRole FROM roles";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

         //Delete A Rôle of An Role by Admin
         public function deleteRoles($id){
            $sql="DELETE FROM roles WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

         //Affichage avant l'édition de rôle existante dans la base de données
         public function editerRoles($id){
            $sql="SELECT * FROM roles WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

         //Edition proprement dite de rôle
         public function update_roles($id, $roles){
            $sql="UPDATE roles SET nomRole=:nomRole WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['nomRole'=>$roles, 'id'=>$id]);
            return true;
        }

         //Enregistrer un nouveau rôle
         public function roles($roles){
            $sql="INSERT INTO roles (nomRole) VALUES (:role)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['role'=>$roles]);
            return true;
        }

        //Vérifier si le rôle existe déjà dans la base de données
        public function roles_exist($roles){
            $sql="SELECT nomRole FROM roles WHERE nomRole=:role";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['role'=>$roles]);
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        //Classe rôles pour afficher tous les responsables
        public function fetchAllResponsables($val){
            $sql="SELECT responsables.matricule,responsables.nom, responsables.postnom,responsables.prenom,responsables.sexe,responsables.email,responsables.adresse,responsables.telephone, responsables.dateCreation, roles.nomRole, agence.nomAg, agence.codAg FROM responsables INNER JOIN roles ON responsables.idrole=roles.id INNER JOIN agence ON agence.idag=responsables.id_ag WHERE responsables.etat =$val";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

        //Afficher tous les agences
        public function fetchAllAgences($val){
            $sql="SELECT idag,codAg,idprov,provinces.nomProvince,matriculeFiscale,nomAg,adresseAg,telephone,emailAg,etatAg, dateCreationAg FROM agence INNER JOIN provinces ON provinces.id=agence.idprov WHERE agence.etatAg=$val";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

        //Afficher tous les guichets
        public function fetchAllGuichets(){
            $sql="SELECT codeGuichet,nomGuichet, etatGuichet,guichets.idAg,agence.codAg,agence.nomAg FROM guichets INNER JOIN agence ON agence.idag=guichets.idAg WHERE etatGuichet=1";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

        //Delete An Responsable
        public function responsableAction($matricule, $val){
            $sql="UPDATE responsables SET etat=$val WHERE matricule=:matricule";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['matricule'=>$matricule]);

            return true;
        }

         //Delete An Agence 
         public function agenceAction($id,$val){
            $sql="UPDATE agence SET etatAg=$val WHERE idag=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

        //Delete An Horaire de travail 
        public function horaireAction($id){
            $sql="DELETE FROM horaires WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

         //Delete An Guichet 
         public function guichetAction($id){
            $sql="DELETE FROM guichets WHERE guichets.codeGuichet=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

        //Fetch Notification
        public function fetchNotification(){
            $sql="SELECT  notification.id,notification.message,notification.created_at,responsables.nom,responsables.email FROM notification INNER JOIN responsables ON notification.umatricule=responsables.matricule WHERE type='admin' ORDER BY notification.id DESC LIMIT 5";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        //Supprimer la Notification
        public function removeNotification($id){
            $sql="DELETE FROM notification WHERE id=:id AND type= 'admin'";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);
            return true;
        }
        
        //Genre maxiculin ou féminin de responsable en pourcentage
        public function genreResponsable(){
            $sql="SELECT sexe, COUNT(*) AS number FROM responsables WHERE sexe !='' GROUP BY sexe";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
         }

         //Count Website Hits
         public function site_hits(){
            $sql="SELECT hits FROM visitors";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $count=$stmt->fetch(PDO::FETCH_ASSOC);
            return $count;
        }

        //Affichage avant l'édition de rôle existante dans la base de données
        public function editerResponsables($matricule){
            $sql="SELECT responsables.matricule,responsables.nom, responsables.postnom,responsables.prenom,responsables.sexe,responsables.email,responsables.adresse,responsables.telephone, responsables.dateCreation, roles.nomRole FROM responsables INNER JOIN roles ON responsables.idrole=roles.id WHERE etat=true AND matricule=:matricule";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['matricule'=>$matricule]);

            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

         //Enregistrer un nouveau responsable
         public function responsable($matricule,$idrole,$nom,$postnom,$prenom,$sexe,$loginU,$passwordU,$email,$adresse,$telephone,$id_ag){
            $sql="INSERT INTO responsables(matricule,idrole,nom,postnom,prenom,sexe,loginU,passwordU,email,adresse,telephone,id_ag) VALUES (:matricule,:idrole,:nom,:postnom,:prenom,:sexe,:loginU,:passwordU,:email,:adresse,:telephone,:id_ag)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['matricule'=>$matricule,'idrole'=>$idrole,'nom'=>$nom,'postnom'=>$postnom,'prenom'=>$prenom,'sexe'=>$sexe,'loginU'=>$loginU,'passwordU'=>$passwordU,'email'=>$email,'adresse'=>$adresse,'telephone'=>$telephone,'id_ag'=>$id_ag]);
            return true;
        }

        //Enregistrer une nouvelle agence
        public function agences($codAg,$idprov,$matriculeFiscale,$nomAg,$adresseAg,$telephone,$emailAg){
            $sql="INSERT INTO agence(codAg,idprov,matriculeFiscale,nomAg,adresseAg,telephone,emailAg) VALUES (:codAg,:idprov,:matriculeFiscale,:nomAg,:adresseAg,:telephone,:emailAg)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['codAg'=>$codAg,'idprov'=>$idprov,'matriculeFiscale'=>$matriculeFiscale,'nomAg'=>$nomAg,'adresseAg'=>$adresseAg,'telephone'=>$telephone,'emailAg'=>$emailAg]);
            return true;
        }

         //Enregistrer une nouveau guichet
         public function guichets($codeGuichet,$nomGuichet,$idAg){
            $sql="INSERT INTO guichets(codeGuichet,nomGuichet,idAg) VALUES (:codeGuichet,:nomGuichet,:idAg)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['codeGuichet'=>$codeGuichet,'nomGuichet'=>$nomGuichet,'idAg'=>$idAg]);
            return true;
        }

          //Enregistrer un horaire de connexion au système pour les users
          public function add_horaire($heure_debut,$heure_fin){
            $sql="INSERT INTO horaires(heure_debut,heure_fin) VALUES (:heure_debut,:heure_fin)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['heure_debut'=>$heure_debut,'heure_fin'=>$heure_fin]);
            return true;
        }
        
        //Afficher tous les horaires
        public function fetchAllHoraires(){
            $sql="SELECT * FROM horaires";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }
        
    }
?>