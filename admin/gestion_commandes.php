<?php require_once("../inc/init.inc.php");

//-------------Traitements PHP-------------------
//--------Vérification admin----------
if(!internauteEstConnecteEtEstAdmin()){
    header("location:../connexion.php");
    exit();
}


// ------------ Supression des commandes--------
if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
    $pdo->exec("DELETE FROM commande WHERE id_commande = $_GET[id_commande]");
}

//--------------- Modification état -------------------

if(!empty($_POST)){

    $id_commande = (isset($_GET['id_commande'])) ? $_GET['id_commande'] : 'NULL';

    $pdo->exec("UPDATE commande SET etat = '$_POST[etat]' WHERE id_commande = $_GET[id_commande]");

    $content .= '<div class="alert alert-success">L\'état de la commande à bien été modifié !</div>';
}


if(isset($_GET['action']) && ($_GET['action'] == "modification")){
    if(isset($_GET['id_commande'])){
        $resultat = $pdo->query("SELECT * FROM commande WHERE id_commande = $_GET[id_commande]");
        $commande_actuelle = $resultat->fetch(PDO::FETCH_ASSOC);
    }
    $content .= 'Bonjour <br> Voici la gestion de l\'état de la commande. <hr>';
    $content .= '
        <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" id="id_commande" name="id_commande" value="';
            if(isset($commande_actuelle['id_commande'])) $content .= $commande_actuelle['id_commande'];
            $content .= '">
        <label for="etat">Etat :</label><br>
        <select name="etat" id="etat">
            <option value="en cours de traitement" ';
            $content .= '>en cours de traitement</option>;
            <option value="envoyé" ';
            $content .= '>envoyé</option>;
            <option value="livré" ';
            $content .= '>livré</option>;
        </select>
        <input type="submit" value="'; $content .= ucfirst($_GET['action']) . ' du produit'; 
        $content .= '">
    </form>';
}

//--------------- Liens commandes -------------------------

$content .= '<a href="?page=gestion_commandes&action=affichage">Affichage des commandes</a><br>';

//-------------- Affichage des commandes ---------------------

if(isset($_GET['action']) && $_GET['action'] == "affichage"){
    $resultat= $pdo->query('SELECT commande.id_commande, commande.montant, commande.date_enregistrement, produit.id_produit, produit.titre, produit.photo, details_commande.quantite, membre.id_membre, membre.pseudo, membre.adresse, membre.ville, membre.code_postal, commande.etat FROM commande, membre, details_commande, produit WHERE commande.id_commande = details_commande.id_commande AND commande.id_membre = membre.id_membre AND produit.id_produit = details_commande.id_produit');
    $content .= '<h2>Affichage des commandes</h2>';
    $content .= 'Nombre de commande(s) : ' . $resultat->rowCount();
    $content .= '<table class="table"><tr>';
    for($i = 0; $i < $resultat->columnCount(); $i++){ //boucle sur les colonnes
        $colonne = $resultat->getColumnMeta($i); // getColumnMeta récupère les informations sur les colonnes
        $content .= "<th>$colonne[name]</th>";
    }

    $content .= '<th colspan="2">Actions</th>';
    $content .= '</tr>';
    while($commande = $resultat->fetch(PDO::FETCH_ASSOC)){ // boucle sur les données
        $content .= '<tr>';
        foreach($commande as $indice => $valeur){
                $content .= "<td>$valeur</td>";
        }
        $content .= '<td><a href="?page=gestion_commandes&action=modification&id_commande=' . $commande['id_commande'] . '"><i class="fas fa-edit"></i></a></td>'; // lien modification
        $content .= '<td><a href="?page=gestion_commandes&action=suppression&id_commande=' . $commande['id_commande'] . '" onClick="return(confirm(\'En êtes-vous certain ?\'))"> <i class="fas fa-trash"></i></a></td>';
    }
    $content .= '</table><br><hr><br>';

}

//--------------- Chiffre d'affaire ---------------

$result = $pdo->query("SELECT SUM(montant) AS valeur FROM commande");
$total = $result->fetch(PDO::FETCH_ASSOC);
$chiffreAffaire = $total['valeur'];


$content .= '<th colspan="6">Le chiffre d\'affaire est de : ' . $chiffreAffaire . ' €</th>';


require_once("../inc/haut.inc.php");

echo $content;

require_once("../inc/bas.inc.php");