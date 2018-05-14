<?php require_once("../inc/init.inc.php");


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



  require_once("../inc/haut.inc.php"); 

  echo $content; 

  require_once("../inc/bas.inc.php"); 


  



