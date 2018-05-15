<?php require_once("../inc/init.inc.php");


       // Enregistrement ------------


if($_POST){
    //debug($_POST); //debug($pdo);
  
    foreach($_POST as $indice => $valeur){
        $_POST[$indice] = addslashes($valeur);
    }

    
    $id_membre = (isset($_GET['id_membre'])) ? $_GET['id_membre'] : 'NULL';
    $pdo->exec("REPLACE INTO membre (id_membre, pseudo, nom, prenom, email, civilite, ville, code_postal, adresse, date_enregistrement, statut) VALUES ('$id_membre', '$_POST[pseudo]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[code_postal]', '$_POST[adresse]', NOW(), '$_POST[statut]')");
    $content .= '<div class="alert alert-success" role="alert"> droit d\'administration accordé !</div>';    
}

// ----------------Vérification admin-----------

if(!internauteEstConnecteEtEstAdmin()){
    header("location:../connexion.php");
    exit();
}

$content .= '<a href="?page=gestion_membres&action=affichage">Affichage des membres</a><br>';

// --------------------- Supprimer un membre --------------------------
if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
    $pdo->exec("DELETE FROM membre WHERE id_membre = $_GET[id_membre]");
}

// ------- Affichage des Membres ------------------

if(isset($_GET['action']) && $_GET['action'] == "affichage"){

$resultat= $pdo->query('SELECT * FROM membre');
$content .= '<h2>Affichage des membres</h2>';
$content .= 'Nombre des membre(s) : ' . $resultat->rowCount();
$content .= '<table class="table"><tr>';
for($i = 0; $i <$resultat->columnCount(); $i++){
//boucle sur les colonnes
$colonne = $resultat->getColumnMeta($i); 
// getColumnmeta récupère les informations sur les colonnes
$content .="<th>$colonne[name]</th>";
}

$content .= '<th colspan="2">Actions</th>';
$content .= '</tr>';
while($membre = $resultat->fetch(PDO::FETCH_ASSOC)){
// boucle sur les données
$content .= '<tr>';
foreach($membre as $indice => $valeur){
        $content .= "<td>$valeur</td>";
}
     $content .= '<td><a href="?page=gestion_membres&action=modification&id_membre=' . $membre['id_membre'] . '"><i class="fas fa-edit"></i></a></td>';    
     $content .= '<td><a href="?page=gestion_membres&action=suppression&id_membre=' . $membre['id_membre'] . '" onClick="return(confirm(\'En êtes-vous certain ?\'))"> <i class="fas fa-trash"></i></a></td>';

// lien de suppression 
}  
    $content .= '</table><br><hr><br>';
}

//-------------- Modification des membres------------------

if(isset($_GET['action']) && $_GET['action'] == 'modification'){
    $r = $pdo->query("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]"); // récupération des informations d'un membre.
    $membre = $r->fetch(PDO::FETCH_ASSOC); // accès aux données
}

// Si nous sommes dans le cas d'une modification, nous souhaitons pré-remplir le formulaire avec les informations actuelles (sinon en cas d'ajout, les variables seront vides)

$id_membre = (isset($membre['id_membre'])) ? $membre['id_membre'] : '';
$pseudo = (isset($membre['pseudo'])) ? $membre['pseudo'] : '';
$nom = (isset($membre['nom'])) ? $membre['nom'] : '';
$prenom = (isset($membre['prenom'])) ? $membre['prenom'] : '';
$email = (isset($membre['email'])) ? $membre['email'] : '';
$civilite = (isset($membre['civilite'])) ? $membre['civilite'] : '';
$ville = (isset($membre['ville'])) ? $membre['ville'] : '';
$code_postal = (isset($membre['code_postal'])) ? $membre['code_postal'] : '';
$adresse = (isset($membre['adresse'])) ? $membre['adresse'] : '';
$statut = (isset($membre['statut'])) ? $membre['statut'] : '';


?>

 <?php require_once("../inc/haut.inc.php"); 
 
  if(isset($_GET['action']) && ($_GET['action'] == 'modification')){
    $content .= '
    <form action="" method="post">
    <input type="hidden" id="id_membre" name="id_membre" value="'; //récupération des valeurs
            if(isset($membre['id_membre'])) $content .= $membre['id_membre'];
            $content .= '">
    <label for="pseudo">Pseudo :</label><br>
    <input type="text" class="form-control" name="pseudo" id="pseudo" value="' . $pseudo . '">
    <br>
    <label for="nom">Nom :</label><br>
    <input type="text" class="form-control" name="nom" id="nom" value="' . $nom . '">
    <br>
    <label for="prenom">Prenom :</label><br>
    <input type="text" class="form-control" name="prenom" id="prenom" value="' . $prenom . '">
    <br>
    <label for="email">Email :</label><br>
    <input type="email" class="form-control" name="email" id="email" value="' . $email . '">
    <br>
    <label for="civilite">Civilité :</label><br>
    <input type="radio" name="civilite" id="civilite" value="m" ';
    if($civilite == 'm') $content .= ' checked';
    $content .= '> Homme<br>
    <input type="radio" name="civilite" id="civilite" value="f" ';
    if($civilite == 'f') $content .= ' checked';
    $content .= '> Femme
    <br>
    <label for="ville">Ville :</label><br>
    <input type="text" class="form-control" name="ville" id="ville" value="' . $ville . '" >
    <br>
    <label for="code_postal">Code Postal :</label><br>
    <input type="text" class="form-control" name="code_postal" id="code_postal" value="' . $code_postal . '" >
    <br>
    <label for="adresse">Adresse :</label><br>
    <textarea name="adresse" class="form-control" id="adresse" >' . $adresse . '</textarea>
    <br>
    <label for="statut">Satut :</label><br>
        <select name="statut" id="statut">
            <option value="0" ';
                if($statut == '0') $content .= ' selected';
            $content .= '>membre</option>;
            <option value="1" ';
                if($statut == '1') $content .= ' selected';
            $content .= '>admin</option>;
        </select><br><br>
    <button type="submit" name="inscription" value="S\'inscrire" class="btn btn-default">Valider</button>
</form>';
}

echo $content; 
   
require_once("../inc/bas.inc.php"); ?>
