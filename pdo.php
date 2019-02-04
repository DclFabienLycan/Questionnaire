<?php

try
{
        $bdd = new PDO('mysql:host=localhost;dbname=Questionnaire;charset=utf8', 'root', 'root');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $bdd-> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); 
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

?>