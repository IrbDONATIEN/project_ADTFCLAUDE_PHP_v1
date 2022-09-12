<?php
    require_once 'config.php';

    class Agence extends Database{
    
         //Login Utilisateur
         public function loginUser($login,$password,$idrole){
            $sql="SELECT loginU,passwordU,idrole FROM responsables WHERE etat=1 AND loginU=:login AND passwordU=:password AND idrole=:idrole";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['login'=>$login,'password'=>$password,'idrole'=>$idrole]);
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        //Afficher les détails de l'utilisateur  connecté
        public function currentUser($login){
            $sql="SELECT responsables.id,matricule,idrole,roles.nomRole,nom,postnom,prenom,sexe,loginU,passwordU,email,adresse,responsables.telephone,etat,dateCreation,id_ag, agence.codAg, agence.nomAg, agence.adresseAg, agence.telephone, agence.emailAg FROM responsables INNER JOIN roles ON roles.id=responsables.idrole INNER JOIN agence ON agence.idag=responsables.id_ag WHERE etat=1 AND loginU=:login";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['login'=>$login]);
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        //Compteur de nombres des lignes dans chaque tables
        public function totalCount($cid_ag){
            $sql="SELECT * FROM client WHERE agence_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $count=$stmt->rowCount();
            return $count;
        }

        //Compteur de nombres des lignes dans chaque tables
        public function totalCounts($cid_ag){
            $sql="SELECT * FROM bon_retrail WHERE agence_bon_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $count=$stmt->rowCount();
            return $count;
        }

         //Compteur de nombre 
         public function totalClientTransaction($cid_ag){
            $sql="SELECT id,nom,prenom,telephone,etat,date_created,agence_id FROM client WHERE etat=1 AND client.agence_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $count=$stmt->rowCount();
            return $count;
        }
        
         //Montant Général Généré  
         public function caisseTotalGenerals($cid_ag){
            $sql="SELECT id,codeTrans,SUM(montantTrans) as Total,pourcentage,etat_transfert,date_enreg,client_id,agence_exp_id,agence_dest_id FROM transfert WHERE agence_exp_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $count=$stmt->fetch(PDO::FETCH_ASSOC);
            return $count;
        }

         //Montant Général Revenu Généré  
         public function caisseTotalGeneral($cid_ag){
            $sql="SELECT id,codeTrans,SUM(montantTrans*pourcentage/100) as Totals,etat_transfert,date_enreg,client_id,agence_exp_id,agence_dest_id FROM transfert WHERE agence_exp_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $count=$stmt->fetch(PDO::FETCH_ASSOC);
            return $count;
        }

         //Enregistrer un nouveau client dans la base de données
         public function client($nom,$prenom,$telephone,$cid_ag){
            $sql="INSERT INTO client(nom,prenom,telephone,agence_id) VALUES (:nom,:prenom,:telephone,:cid_ag)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['nom'=>$nom,'prenom'=>$prenom,'telephone'=>$telephone,'cid_ag'=>$cid_ag]);
            return true;
        }

        //Afficher les clients 
        public function fetchAllClients($cid_ag){
            $sql="SELECT client.id,nom,prenom,client.telephone,etat,date_created,agence_id,agence.codAg,agence.matriculeFiscale,agence.nomAg FROM client INNER JOIN agence ON agence.idag=client.agence_id WHERE client.agence_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

         //Delete An Clients
         public function clientDelete($id){
            $sql="DELETE FROM client WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

        //Etat de transaction par le client
        public function clientTransaction($id){
            $sql="UPDATE client SET etat=1 WHERE etat!=1 AND id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }
        
         //Enregistrer un nouveau bénéficiaire dans la base de données
         public function beneficiaire($nomBen,$postnomBen,$prenomBen,$telephoneBen,$adresseBen,$client_ben_id,$cid_ag){
            $sql="INSERT INTO beneficiaire(nomBen,postnomBen,prenomBen,telephoneBen,adresseBen,client_ben_id,agence_ben_id) VALUES (:nomBen,:postnomBen,:prenomBen,:telephoneBen,:adresseBen,:client_ben_id,:cid_ag)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['nomBen'=>$nomBen,'postnomBen'=>$postnomBen,'prenomBen'=>$prenomBen,'telephoneBen'=>$telephoneBen,'adresseBen'=>$adresseBen,'client_ben_id'=>$client_ben_id,'cid_ag'=>$cid_ag]);
            return true;
        }

        //Afficher les bénéficiaires plus les clients 
        public function fetchAllBeneficiaires($cid_ag){
            $sql="SELECT beneficiaire.id,nomBen,postnomBen,prenomBen,telephoneBen,adresseBen,client_ben_id,client.nom,client.prenom,client.telephone,etat_ben,dateCreation, agence_ben_id, agence.codAg,agence.matriculeFiscale,agence.nomAg FROM beneficiaire INNER JOIN client ON client.id=beneficiaire.client_ben_id INNER JOIN agence ON agence.idag=beneficiaire.agence_ben_id WHERE beneficiaire.agence_ben_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

         //Delete An Bénéficiaires
         public function beneficiaireDelete($id){
            $sql="DELETE FROM beneficiaire WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

        //Enregistrer une nouvelle transaction de fonds dans la base de données
        public function transactions($codeTrans,$montantTrans,$pourcentage,$client_id,$cid_ag,$agence_dest_id){
            $sql="INSERT INTO transfert(codeTrans,montantTrans,pourcentage,client_id,agence_exp_id,agence_dest_id) VALUES (:codeTrans,:montantTrans,:pourcentage,:client_id,:cid_ag,:agence_dest_id)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['codeTrans'=>$codeTrans,'montantTrans'=>$montantTrans,'pourcentage'=>$pourcentage,'client_id'=>$client_id,'cid_ag'=>$cid_ag,'agence_dest_id'=>$agence_dest_id]);
            return true;
        }

        //Afficher les Transactions de Fonds des clients 
        public function fetchAllTransactionsFonds($cid_ag){
            $sql="SELECT transfert.id,codeTrans,montantTrans,pourcentage,(montantTrans*pourcentage/100)as Frais_transaction,etat_transfert,date_enreg,client_id,client.nom,client.prenom,client.telephone,agence_exp_id,agExp.codAg,agExp.matriculeFiscale,agExp.nomAg,agence_dest_id,agDest.codAg,agDest.matriculeFiscale,agDest.nomAg,beneficiaire.id,beneficiaire.nomBen,beneficiaire.prenomBen,beneficiaire.telephoneBen FROM transfert INNER JOIN beneficiaire ON transfert.client_id=beneficiaire.client_ben_id INNER JOIN client ON client.id=transfert.client_id INNER JOIN agence agExp ON agExp.idag=transfert.agence_exp_id INNER JOIN agence agDest ON agDest.idag=transfert.agence_dest_id WHERE transfert.agence_exp_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

         //Afficher les Transactions de Fonds des clients 
         public function fetchAllTransactionsFondsF($cid_ag){
            $sql="SELECT transfert.id,codeTrans,montantTrans,pourcentage,(montantTrans*pourcentage/100)as Frais_transaction,etat_transfert,date_enreg,client_id,client.nom,client.prenom,client.telephone,agence_exp_id,agExp.codAg,agExp.matriculeFiscale,agExp.nomAg as Ag,agence_dest_id,agDest.codAg,agDest.matriculeFiscale,agDest.nomAg,beneficiaire.id,beneficiaire.nomBen,beneficiaire.prenomBen,beneficiaire.telephoneBen FROM transfert INNER JOIN beneficiaire ON transfert.client_id=beneficiaire.client_ben_id INNER JOIN client ON client.id=transfert.client_id INNER JOIN agence agExp ON agExp.idag=transfert.agence_exp_id INNER JOIN agence agDest ON agDest.idag=transfert.agence_dest_id WHERE transfert.agence_dest_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

         //Delete An Transaction de Fonds
         public function transactionDelete($id){
            $sql="DELETE FROM transfert WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

        //Etat de transaction par le bénéficiaire
        public function etatBeneficiaireTransaction($beneficiaire_id){
            $sql="UPDATE  beneficiaire SET etat_ben=1 WHERE etat_ben!=1 AND id=:beneficiaire_id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['beneficiaire_id'=>$beneficiaire_id]);

            return true;
        }

        //Etat de transaction
        public function etatTransaction($etat_transaction){
            $sql="UPDATE  transfert SET etat_transfert=1 WHERE 	etat_transfert!=1 AND id=:etat_transaction";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['etat_transaction'=>$etat_transaction]);

            return true;
        }

         //Enregistrer un bon de retrait de fonds  dans la base de données
         public function retraitFondstransactions($motif,$date_create,$beneficiaire_id,$cid_ag,$etat_transaction){
            $sql="INSERT INTO bon_retrail(motif,date_create,beneficiaire_id,agence_bon_id,etat_transaction) VALUES (:motif,:date_create,:beneficiaire_id,:cid_ag,:etat_transaction)"; 
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['motif'=>$motif,'date_create'=>$date_create,'beneficiaire_id'=>$beneficiaire_id,'cid_ag'=>$cid_ag,'etat_transaction'=>$etat_transaction]);
            return true;
        }

        //Afficher les Bons des Retraits de Fonds Bénéficiaires 
        public function fetchAllBonRetraitTransactions($cid_ag){
            $sql="SELECT id_bon,motif,date_create,beneficiaire_id,beneficiaire.nomBen,beneficiaire.postnomBen,beneficiaire.prenomBen,beneficiaire.telephoneBen,agence_bon_id,etat_transaction,transfert.codeTrans,transfert.montantTrans FROM bon_retrail INNER JOIN beneficiaire ON beneficiaire.id=bon_retrail.beneficiaire_id INNER JOIN transfert ON transfert.id=bon_retrail.etat_transaction WHERE agence_bon_id=:cid_ag";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute(['cid_ag'=>$cid_ag]);
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }
    
    }
?>