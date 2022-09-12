<?php
	try{
		$db= new PDO('mysql:host=localhost;dbname=adtfclaude','root','');
	}
	catch(Exception $e ){
		die('votre connection a échouée');
	}
?>