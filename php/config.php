<?php
    class Database{

        const USERNAME='donatienbanyishayimobeti@gmail.com';
        const PASSWORD='Irb@1234@';

        private $dsn="mysql:host=localhost;dbname=adtfclaude";

        private $dbuser="root";

        private $dbpass="";

        public $conn;

        public function __construct(){
            try{
        
                $this->conn=new PDO($this->dsn,$this->dbuser,$this->dbpass);
                //echo 'Success';
            }catch(PDOException $e){

                echo'Error: '.$e->getMessage();
            }

            return $this->conn;
        }

        //Vérifier les champs input 
        public function test_input($data){
            $data=trim($data);
            $data=stripslashes($data);
            $data=htmlspecialchars($data);
            return $data;
        }

        //Vérifier le message d'alert d'erreur
        public function showMessage($type, $message){
            return '<div class="alert alert-'.$type.' alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong class="text-center">'.$message.'</strong>
                   </div>';
        }

         //Display time in ago
         public function timeInAgo($timestamp){

            date_default_timezone_set('Africa/Lubumbashi');

            date_default_timezone_get();

            $timestamp=strtotime($timestamp)? strtotime($timestamp):$timestamp;
            $time=time()-$timestamp;
            switch($time){
                //Seconds
                case $time <=60:
                    return 'Maintenant';
                //Minutes
                case $time >=60 && $time < 3600:
                    return (round($time/60)==1)? 'une minute passée ': round($time/60).'minutes passées';
                //Hours
                case $time >=3600 && $time < 86400:
                    return (round($time/3600)==1)? 'une heure passée' : round($time/3600).'heures passées';
                //Days
                case $time >= 86400 && $time < 604800:
                    return (round($time/86400)==1)? 'un jour passé' : round($time/86400).'jours passés';
                //Weeks
                case $time >= 604800 && $time < 2600640:
                    return (round($time/604800)==1)? 'une semaine passée' : round($time/604800).'semaines passées';
                //Months
                case $time >=2600640 && $time <31207680:
                    return (round($time/2600640)==1)? 'un mois passé': round($time/2600640).'mois passés';
                //Years
                case $time >=31207680;
                return (round($time/31207680)==1)? 'une année passée': round($time/31207680).'années passées';
            }
        }
    }
?>