<?php require_once("inc/init.inc.php");

 //Traitement PHP-----------
if(!internauteEstConnecte()){
    header('location:connexion.php');
    exit();
}

if(internauteEstConnecteEtEstAdmin()){
    $content .= "<h1>Vous êtes administrateur du site</h1>";
}

require_once("inc/haut.inc.php"); ?>

<?= $content; ?>
Bonjour <?= $_SESSION['membre']['pseudo']?> Vous êtes bien connecté.<br>
Voici vos informations : <br>
Votre nom : <?= $_SESSION['membre']['nom']?><br>
Votre prenom : <?= $_SESSION['membre']['prenom']?><br>
Votre email : <?= $_SESSION['membre']['email']?><br>

<?php require_once("inc/bas.inc.php"); ?>