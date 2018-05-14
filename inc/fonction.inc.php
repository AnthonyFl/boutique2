<?php
function debug($var, $mode = 1){
    $trace = debug_backtrace();
    $trace = array_shift($trace);
    echo "<strong>Debug demandé dans le fichier : $trace[file] en ligne : $trace[line]</strong>";
    if($mode == 1){
        print '<pre>'; print_r($var); print '</pre>';
    }
    else
        var_dump($var);
}

function internauteEstConnecte(){
    if(!isset($_SESSION['membre'])) return false;
    else return true;
}

function internauteEstConnecteEtEstAdmin(){
    if(internauteEstConnecte() && $_SESSION['membre']['statut'] == 1)
    return true;
    else return false;
}

function creationPanier(){
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier'] = array();
        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['titre'] = array();
        $_SESSION['panier']['reference'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}

function ajoutProduitDansPanier($id_produit, $titre, $reference, $quantite, $prix){
    creationPanier();
    $position_produit = array_search($id_produit, $_SESSION['panier']['id_produit']);
    if($position_produit !== false){ // produit existant
        $_SESSION['panier']['quantite'][$position_produit] += $quantite;
    }
    else{ // nouveau produit
        $_SESSION['panier']['id_produit'][] = $id_produit;
        $_SESSION['panier']['titre'][] = $titre;
        $_SESSION['panier']['reference'][] = $reference;
        $_SESSION['panier']['quantite'][] = $quantite;
        $_SESSION['panier']['prix'][] = $prix;
    }
}

function montantTotal(){
    $total = 0;
    for($i = 0; $i < count( $_SESSION['panier']['id_produit']); $i++){
        $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
    }
    return round($total, 2);
}

function retireProduitPanier($id_produit_a_supprimer){
    $position_produit = array_search($id_produit_a_supprimer, $_SESSION['panier']['id_produit']);
    if($position_produit !== false){
        array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);
        array_splice($_SESSION['panier']['titre'], $position_produit, 1);
        array_splice($_SESSION['panier']['reference'], $position_produit, 1);
        array_splice($_SESSION['panier']['quantite'], $position_produit, 1);
        array_splice($_SESSION['panier']['prix'], $position_produit, 1);
    }
}