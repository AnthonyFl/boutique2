<?php require_once("inc/init.inc.php");

 //Traitement PHP-----------
if(!internauteEstConnecte()){
    header('location:connexion.php');
    exit();
}

if(!empty($_POST)){

    $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    $pdo->exec("UPDATE membre SET mdp = '$_POST[mdp]', nom = '$_POST[nom]', prenom = '$_POST[prenom]', email = '$_POST[email]', civilite = '$_POST[civilite]', ville = '$_POST[ville]', code_postal = '$_POST[code_postal]', adresse = '$_POST[adresse]' WHERE id_membre = $_GET[id_membre]");

    $content .= '<div class="alert alert-success">Votre profil à bien été modifié !</div>';
}


if(isset($_GET['action']) && ($_GET['action'] == "modification")){
    if(isset($_GET['id_membre'])){
        $resultat = $pdo->query("SELECT * FROM membre WHERE id_membre = $_GET[id_membre]");
        $membre_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
    }
    $mdp = (isset($membre_actuel['mdp'])) ? $membre_actuel['mdp'] : '';
    $nom = (isset($membre_actuel['nom'])) ? $membre_actuel['nom'] : '';
    $prenom = (isset($membre_actuel['prenom'])) ? $membre_actuel['prenom'] : '';
    $email = (isset($membre_actuel['email'])) ? $membre_actuel['email'] : '';
    $ville = (isset($membre_actuel['ville'])) ? $membre_actuel['ville'] : '';
    $code_postal = (isset($membre_actuel['code_postal'])) ? $membre_actuel['code_postal'] : '';
    $adresse = (isset($membre_actuel['adresse'])) ? $membre_actuel['adresse'] : '';

    $content .= 'Bonjour <br> Voici la gestion de votre profil. <hr>';
    $content .= '
        <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" id="id_membre" name="id_membre" value="">
            <label for="mdp">Mot de passe :</label><br>
            <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe" value="' . $mdp . '">
            <br>
            <label for="nom">Nom :</label><br>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="' . $nom . '">
            <br>
            <label for="prenom">Prenom :</label><br>
            <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prenom" value="' . $prenom . '">
            <br>
            <label for="email">Email :</label><br>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="' . $email . '">
            <br>
            <label for="civilite">Civilité :</label><br>
            <input type="radio" name="civilite" id="civilite" value="m" checked> Homme<br>
            <input type="radio" name="civilite" id="civilite" value="f"> Femme
            <br>
            <label for="ville">Ville :</label><br>
            <input type="text" class="form-control" name="ville" id="ville" placeholder="Ville" pattern="[a-zA-Z0-9-_.]{2,25}" title="caractères acceptés : a-z A-Z 0-9 .-_" value="' . $ville . '">
            <br>
            <label for="code_postal">Code Postal :</label><br>
            <input type="text" class="form-control" name="code_postal" id="code_postal" placeholder="Code postal" pattern="[0-9]{5}" title="5 chiffres requis" value="' . $code_postal . '">
            <br>
            <label for="adresse">Adresse :</label><br>
            <textarea name="adresse" class="form-control" id="adresse" placeholder="Votre adresse" pattern="[a-zA-Z0-9-_.]{5,50}" title="caractères acceptés : a-z A-Z 0-9 .-_" value="' . $adresse . '"></textarea>
            <br>
            <input type="submit" value="'; $content .= ucfirst($_GET['action']) . ' du profil'; 
            $content .= '">
            </form>';
}



require_once("inc/haut.inc.php"); ?>

<?= $content; ?>

<?php require_once("inc/bas.inc.php"); ?>