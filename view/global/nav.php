<nav class="navbar">
	<div class="menuItem" onclick="location.href='./index.php'">Accueil</div>

	
	<div class="menuItem"
		onclick="location.href='./index.php?controller=commande&action=panier'">Panier</div>
		
	<?php if(isset($_SESSION['isAdmin'])){?>
	<div class="menuItem"
		onclick="location.href='./index.php?controller=poisson&action=created'">Ajouter un poisson</div>	
<?php }if(!isset($_SESSION['nom'])){?>
        <button
		onclick="location.href = './index.php?action=create&controller=user'"
		style="width: auto">Inscription</button>

	<button
		onclick="location.href = './index.php?action=connecte&controller=user'"
		style="width: auto">Connexion</button>
	
<?php
} else {
    ?>
 <button 
		onclick="location.href = './index.php?action=update&controller=user'"
		style="	max-width: 25%;">Mon Compte</button>

	<button 
		onclick="location.href = './index.php?action=deconnect&controller=user'"
		style="	max-width: 25%;">Deconnexion</button>
	
<?php
}
?>
	
</nav>




