<?php require_once("../inc/init.inc.php");

//-------------Traitements PHP-------------------
//--------Vérification admin----------
if(!internauteEstConnecteEtEstAdmin()){
    header("location:../connexion.php");
    exit();
}

//--------------- Liens commandes -------------------------

$content .= '<a href="?page=gestion_commandes&action=affichage">Affichage des commandes</a><br>';

// ------------ Supression des commandes--------

if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
    $pdo->exec("DELETE FROM commande WHERE id_commande = $_GET[id_commande]");
}

//-------------- Affichage des commandes ---------------------

if(isset($_GET['action']) && $_GET['action'] == "affichage"){
    $resultat= $pdo->query('SELECT * FROM commande');
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
        $content .= '<td><a href="?page=gestion_commandes&action=suppression&id_commande=' . $commande['id_commande'] . '" onClick="return(confirm(\'En êtes-vous certain ?\'))"> <i class="fas fa-trash"></i></a></td>'; // lien de suppression
    }
    $content .= '</table><br><hr><br>';
}

// $content .= '<th colspan="6">Le chiffre d\'affaire est de : ' . chiffreaffaire() . ' €</th>';


require_once("../inc/haut.inc.php");

echo $content;

require_once("../inc/bas.inc.php");