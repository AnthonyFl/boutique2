<?php require_once("inc/init.inc.php"); ?>
<?php
    if($_POST){
        //debug($_POST); //debug($pdo);
        $erreur = '';
        if(strlen($_POST['pseudo']) <= 3 || strlen($_POST['pseudo']) > 20){
            $erreur .= '<div class="alert alert-danger" role="alert"> Erreur taille pseudo</div>';
        }

        if(!preg_match('#^[a-zA-Z0-9.-_]+$#', $_POST['pseudo'])){
            $erreur .= '<div class="alert alert-danger" role="alert"> Erreur format pseudo</div>';
        }

        $r = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");
        if($r->rowCount() >=1){
            $erreur .= '<div class="alert alert-danger" role="alert"> Pseudo Indisponible !</div>';
        }

        foreach($_POST as $indice => $valeur){
            $_POST[$indice] = addslashes($valeur);
        }

        $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT); //Cripte le mot de passe

        if(empty($erreur)){
            $pdo->exec("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, date_enregistrement) VALUES ('$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[code_postal]', '$_POST[adresse]', NOW())");
            $content .= '<div class="alert alert-success" role="alert"> Inscription validée !</div>';
        }
        $content .= $erreur;
    }
?>
<?php require_once("inc/haut.inc.php"); ?>
<?= $content; //Equivalent à un echo ?>
<form action="" method="post">
    <label for="pseudo">Pseudo :</label><br>
    <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Pseudo" maxlength="20" pattern="[a-zA-Z0-9-_.]{3,20}" title="caractères acceptés : a-z A-Z 0-9 .-_" required>
    <br>
    <label for="mdp">Mot de passe :</label><br>
    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe" required>
    <br>
    <label for="nom">Nom :</label><br>
    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom">
    <br>
    <label for="prenom">Prenom :</label><br>
    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prenom">
    <br>
    <label for="email">Email :</label><br>
    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
    <br>
    <label for="civilite">Civilité :</label><br>
    <input type="radio" name="civilite" id="civilite" value="m" checked> Homme<br>
    <input type="radio" name="civilite" id="civilite" value="f"> Femme
    <br>
    <label for="ville">Ville :</label><br>
    <input type="text" class="form-control" name="ville" id="ville" placeholder="Ville" pattern="[a-zA-Z0-9-_.]{2,25}" title="caractères acceptés : a-z A-Z 0-9 .-_">
    <br>
    <label for="code_postal">Code Postal :</label><br>
    <input type="text" class="form-control" name="code_postal" id="code_postal" placeholder="Code postal" pattern="[0-9]{5}" title="5 chiffres requis">
    <br>
    <label for="adresse">Adresse :</label><br>
    <textarea name="adresse" class="form-control" id="adresse" placeholder="Votre adresse" pattern="[a-zA-Z0-9-_.]{5,50}" title="caractères acceptés : a-z A-Z 0-9 .-_"></textarea>
    <br>
    <button type="submit" name="inscription" value="S'inscrire" class="btn btn-default">Valider</button>
</form>

<?php require_once("inc/bas.inc.php"); ?>