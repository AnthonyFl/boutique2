<?php require_once("inc/init.inc.php");
    if(!isset($_GET['id_produit'])){
        header('location:index.php');
        exit();
    }
    if(isset($_GET['id_produit'])){
        $r = $pdo->query("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]'");
    }
    if($r->rowCount() <= 0){
        header('location:index.php');
        exit();
    }

    $produit = $r->fetch(PDO::FETCH_ASSOC);

    $content .= "<h1>$produit[titre]</h1>";
    $content .= "<p>Catégorie : $produit[categorie]</p>";
    $content .= "<p>Couleur : $produit[couleur]</p>";
    $content .= "<p>Taille : $produit[taille]</p>";
    $content .= "<p><img src=\"$produit[photo]\"</p>";
    $content .= "<p><em>Description : $produit[description]</em></p>";
    $content .= "<p>Prix : $produit[prix] €</p>";

    if($produit['stock'] > 0){
        $content .= "Nombre de produit(s) disponible(s) en stock : $produit[stock]<br>";
        $content .= "<form method=\"post\" action=\"panier.php\">";
        $content .= "<input type=\"hidden\" name=\"id_produit\" value=\"$produit[id_produit]\"><br><br>";
        $content .= "<label for=\"quantite\">Quantité&nbsp;</label>";
        $content .= "<select name=\"quantite\" id=\"quantite\">";
            for($i = 1; $i <= $produit['stock']; $i++){
                $content .= "<option>$i</option>";
            }
        $content .= "</select><br><br>";
        $content .= "<input type=\"submit\" value=\"Ajouter au panier\" name=\"ajout_panier\" class=\"btn btn-default\" <br><br>";
        $content .= "</form>";
    }
    else{
        $content .= "<p>Rupture de stock !</p>";
    }
    $content .= "<a href=\"index.php?categorie=$produit[categorie]\">Retour vers la catégorie $produit[categorie]</a>";
?>

<?php require_once("inc/haut.inc.php"); ?>
    <em>Fiche produit</em>
    <?= $content ?>
<?php require_once("inc/bas.inc.php"); ?>