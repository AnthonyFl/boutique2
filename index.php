<?php require_once("inc/init.inc.php");

    $r = $pdo->query('SELECT DISTINCT(categorie) FROM produit');
    $content .= '<div class="row">';
    $content .= '<div class="col-md-3"><div class="list-group">';
    while($categorie = $r->fetch(PDO::FETCH_ASSOC)){
        $content .= "<a href=\"?categorie=$categorie[categorie]\" class=\"list-group-item\">$categorie[categorie]</a>";
    }
    $content .= '</div></div>';
    $content .= '<div class="col-md-8 col-md-offset-1">';
    if(isset($_GET['categorie'])){
        $r = $pdo->query("SELECT * FROM produit WHERE categorie = '$_GET[categorie]'");
        while($produit = $r->fetch(PDO::FETCH_ASSOC)){
            $content .= '<div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="thumbnail">
                                <a href="fiche-produit.php?id_produit=' . $produit['id_produit'] . '">
                                    <img src="' . $produit['photo'] . '"alt=""></a>
                                <div class="caption">
                                    <a href="fiche-produit.php?id_produit=' . $produit['id_produit'] . '"><h4>' . $produit['titre'] . '</h4></a>
                                    <p>' . $produit['description'] . ' <strong>' . $produit['prix'] . '€</strong></p>
                                </div>
                            </div>
                        </div>';
        }
    }
?>
<?php require_once("inc/haut.inc.php"); ?>

<h1>Nos produits</h1>
<p>Voici notre catalogue de produits.</p>
<hr>

<?= $content; ?>

<?php require_once("inc/bas.inc.php"); ?>