<?php require_once("../inc/init.inc.php");

//-------------Traitements PHP-------------------
//--------Vérification admin----------
if(!internauteEstConnecteEtEstAdmin()){
    header("location:../connexion.php");
    exit();
}
//------------- Enregistrement d'un produit ------------

if(!empty($_POST)){
    //debug($_POST);
    $photo_bdd = '';
    if(isset($_GET['action']) && $_GET['action'] == 'modification'){
        $photo_bdd = $_POST['photo_actuelle']; // en cas de modification, on récupère la photo actuelle.
    }
    if(!empty($_FILES['photo']['name'])){ // S'il y a une photo qui a été ajoutée
        $photo_bdd = URL . "photo/$_POST[reference]_" . $_FILES['photo']['name']; // Cette variable nous permettra de sauvegarder le chemin dans la base
        $photo_dossier = RACINE_SITE . "photo/$_POST[reference]_" . $_FILES['photo']['name']; // Cette variable nous permettra de sauvegarder la photo dans le dossier
        copy($_FILES['photo']['tmp_name'], $photo_dossier); // copy permet de sauvegarder un fichier sur le serveur
    }

    $id_produit = (isset($_GET['id_produit'])) ? $_GET['id_produit'] : 'NULL'; // s'il y a un id_produit dans l'url c'est que nous sommes dans le cas d'une modification

    $pdo->exec("REPLACE INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES ('$id_produit', '$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$photo_bdd', '$_POST[prix]', '$_POST[stock]')");

    $content .= '<div class="alert alert-success">Le produit à bien été ajouté !</div>';
}

//--------------- Suppression d'un produit-------------

if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
    $pdo->exec("DELETE FROM produit WHERE id_produit = $_GET[id_produit]");
}

//--------------- Liens produits -------------------------

$content .= '<a href="?page=gestion-des-produits&action=affichage">Affichage des produits</a><br>';
$content .= '<a href="?page=gestion-des-produits&action=ajout">Ajout d\'un produit</a><br><hr><br>';

//-------------- Affichage des produits ---------------------

if(isset($_GET['action']) && $_GET['action'] == "affichage"){
    $resultat= $pdo->query('SELECT * FROM produit');
    $content .= '<h2>Affichage des produits</h2>';
    $content .= 'Nombre de produit(s) dans la boutique : ' . $resultat->rowCount();
    $content .= '<table class="table"><tr>';
    for($i = 0; $i < $resultat->columnCount(); $i++){ //boucle sur les colonnes
        $colonne = $resultat->getColumnMeta($i); // getColumnMeta récupère les informations sur les colonnes
        $content .= "<th>$colonne[name]</th>";
    }
    $content .= '<th colspan="2">Actions</th>';
    $content .= '</tr>';
    while($produits = $resultat->fetch(PDO::FETCH_ASSOC)){ // boucle sur les données
        $content .= '<tr>';
        foreach($produits as $indice => $valeur){
            if($indice == 'photo')
                $content .= "<td><img src=\"$valeur\"></td>";
            else
                $content .= "<td>$valeur</td>";
        }
        $content .= '<td><a href="?page=gestion-des-produits&action=modification&id_produit=' . $produits['id_produit'] . '"><i class="fas fa-edit"></i></a></td>'; // lien modification
        $content .= '<td><a href="?page=gestion-des-produits&action=suppression&id_produit=' . $produits['id_produit'] . '" onClick="return(confirm(\'En êtes-vous certain ?\'))"> <i class="fas fa-trash"></i></a></td>'; // lien de suppression
    }
    $content .= '</table><br><hr><br>';
}

//-------------- Modification des produits------------------

if(isset($_GET['action']) && $_GET['action'] == 'modification'){
    $r = $pdo->query("SELECT * FROM produit WHERE id_produit=$_GET[id_produit]"); // récupération des informations d'un produit.
    $produit = $r->fetch(PDO::FETCH_ASSOC); // accès aux données
}

// Si nous sommes dans le cas d'une modification, nous souhaitons pré-remplir le formulaire avec les informations actuelles (sinon en cas d'ajout, les variables seront vides)

$id_produit = (isset($produit['id_produit'])) ? $produit['id_produit'] : '';
$reference = (isset($produit['reference'])) ? $produit['reference'] : '';
$categorie = (isset($produit['categorie'])) ? $produit['categorie'] : '';
$titre = (isset($produit['titre'])) ? $produit['titre'] : '';
$description = (isset($produit['description'])) ? $produit['description'] : '';
$couleur = (isset($produit['couleur'])) ? $produit['couleur'] : '';
$taille = (isset($produit['taille'])) ? $produit['taille'] : '';
$public = (isset($produit['public'])) ? $produit['public'] : '';
$photo = (isset($produit['photo'])) ? $produit['photo'] : '';
$prix = (isset($produit['prix'])) ? $produit['prix'] : '';
$stock = (isset($produit['stock'])) ? $produit['stock'] : '';

//------------- Formulaire d'ajout d'un produit--------------
require_once("../inc/haut.inc.php");

if(isset($_GET['action']) && ($_GET['action'] == "ajout" || $_GET['action'] == 'modification')){
    if(isset($_GET['id_produit'])){
        $resultat = $pdo->query("SELECT * FROM produit WHERE id_produit = $_GET[id_produit]");
        $produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
    }
    $content .= 'Bonjour <br> Voici la gestion des produits. <hr>';
    $content .= '

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" id="id_produit" name="id_produit" value="';
            if(isset($produit_actuel['id_produit'])) $content .= $produit_actuel['id_produit'];
            $content .= '">
        <label for="reference">Réference :</label><br>
        <input type="text" id="reference" name="reference" placeholder="Réference du produit" value="' . $reference . '" required><br>

        <label for="categorie">Catégorie :</label><br>
        <input type="text" id="categorie" name="categorie" placeholder="Catégorie du produit" value="' . $categorie . '" required><br>

        <label for="titre">Titre :</label><br>
        <input type="text" id="titre" name="titre" placeholder="Titre du produit" value="' . $titre . '"><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description" placeholder="Description du produit" required>' . $description . '</textarea><br>

        <label for="couleur">Couleur :</label><br>
        <input type="text" id="couleur" name="couleur" placeholder="Couleur du produit" value="' . $couleur . '"><br>

        <label for="taille">Taille :</label><br>
        <select name="taille" id="taille">
            <option value="S" ';
                if($taille == 'S') $content .= ' selected';
            $content .= '>S</option>;
            <option value="M" ';
                if($taille == 'M') $content .= ' selected';
            $content .= '>M</option>;
            <option value="L" ';
                if($taille == 'L') $content .= ' selected';
            $content .= '>L</option>;
            <option value="XL" ';
                if($taille == 'XL') $content .= ' selected';
            $content .= '>XL</option>;
        </select>
        <br>

        <label for="public">Public :</label><br>
        <select name="public" id="public">
            <option value="m" ';
                if($public == 'm') $content .= ' selected';
            $content .= '>Homme</option>;
            <option value="f" ';
                if($public == 'f') $content .= ' selected';
            $content .= '>Femme</option>;
            <option value="mixte" ';
                if($public == 'mixte') $content .= ' selected';
            $content .= '>Mixte</option>;
        </select>
        <br>

        <label for="photo">Photo :</label><br>
        <input type="file" id="photo" name="photo" placeholder="Photo du produit">';
            if(!empty($photo)){
                $content .= 'photo actuelle : <img src="' . $photo . '" width="50">';
                $content .= '<input type="hidden" name="photo_actuelle" value="' . $photo . '">';
            }
        $content .= '
        <br>

        <label for="prix">Prix :</label><br>
        <input type="text" id="prix" name="prix" placeholder="Prix du produit" value="' . $prix . '" required><br>

        <label for="stock">Stock :</label><br>
        <input type="text" id="stock" name="stock" placeholder="Stock du produit" value="' . $stock . '"><br>

        <input type="submit" value="'; $content .= ucfirst($_GET['action']) . ' du produit'; 
        $content .= '">
    </form>';
}

echo $content; 

require_once("../inc/bas.inc.php");