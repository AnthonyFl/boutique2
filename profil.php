<?php require_once("inc/init.inc.php");

 //Traitement PHP-----------
if(!internauteEstConnecte()){
    header('location:connexion.php');
    exit();
}

if(internauteEstConnecteEtEstAdmin()){
    $content .= "<h1>Vous êtes administrateur du site</h1>";
}

// ------------ Désinscription--------
if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
    $pdo->exec("DELETE FROM membre WHERE id_membre = $_GET[id_membre]");
    $content .= '<div class="alert alert-success">Vous vous êtes désinscrit</div>';
    unset($_SESSION['membre']);
}


require_once("inc/haut.inc.php"); ?>

<?= $content; ?>
Bonjour <?= $_SESSION['membre']['pseudo']?> Vous êtes bien connecté.<br>
Voici vos informations : <br>
Votre nom : <?= $_SESSION['membre']['nom']?><br>
Votre prenom : <?= $_SESSION['membre']['prenom']?><br>
Votre email : <?= $_SESSION['membre']['email']?><br>

<a href="<?= URL; ?>membres.php?action=modification&id_membre='<?= $_SESSION['membre']['id_membre']?>'">Modifier votre profil</a><br>

<a href="?page=profil&action=suppression&id_membre='<?= $_SESSION['membre']['id_membre']?>'" onClick="return(confirm('En êtes-vous certain ?'))">Se désinscrire</a>

<?php require_once("inc/bas.inc.php"); ?>