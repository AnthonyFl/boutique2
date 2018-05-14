<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo URL; ?>inc/css/style.css">
	<link rel="stylesheet" href="<?php echo URL; ?>inc/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<title>Boutique</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.11/css/all.css" integrity="sha384-p2jx59pefphTFIpeqCcISO9MdVfIm4pNnsL08A6v5vaQc4owkQqxMV8kg4Yvhaw/" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</head>
<body>
<header>
	<div class="container">
		<div>
			<a href="" title="Mon Site">MonSite.com</a>
		</div>
		<nav>
			<ul>
				<li><a href="<?= URL; ?>index.php">Accueil</a></li>
				<?php if(internauteEstConnecteEtEstAdmin()): ?>
				    <li><a href="<?= URL; ?>admin/gestion-des-produits.php">Gestion des produits</a></li>
					<li><a href="<?= URL; ?>admin/gestion_commandes.php">Gestion des commandes</a></li>
				<?php endif; ?>
				<?php if(internauteEstConnecte()): ?>
					<li><a href="<?= URL; ?>panier.php">Panier</a></li>
					<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Membre</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<li><a href="#"></a>
							<ul>
								<li class="dropdown-item"><a href="<?= URL; ?>profil.php">Profil</a></li>
								<li class="dropdown-item"><a href="<?= URL; ?>connexion.php?action=deconnexion">Déconnexion</a></li>
								</div>
								</div>
							</ul>
						</li>
					<?php else: ?>
					<li><a href="<?= URL; ?>panier.php">Panier</a></li>
					<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Membre</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<li><a href="#"></a>
							<ul>
								<li class="dropdown-item"><a href="<?= URL; ?>inscription.php">Inscription</a></li>
								<li class="dropdown-item"><a href="<?= URL; ?>connexion.php">Connexion</a></li>
								</div>
								</div>
							</ul>
						</li>
					<?php endif; ?>
					</ul>
				</nav>
			</div>
		</header>
	<section>
		<div class="container">