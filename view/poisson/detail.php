<div class='produitDetails'>
	<img alt='Poisson' class='produitImg' src=<?php echo($poisson->image());?> />
	
	<?php if(!isset($_SESSION['isAdmin'])){?>
	<div class='produitInfo'>Nom : <?php echo($poisson->get('nomCommun'));?></div>

	<div class='produitInfo'>Prix : <?php echo($poisson->get('prix'));?></div>
	<div class='produitInfo'>Nom Scientifique : <?php echo($poisson->get('nomScientifique'));?></div>

	<div class='produitInfo'>Taille : <?php echo($poisson->get('taille'));?></div>
	<div class='produitInfo'>Famille : <?php echo($poisson->get('famille'));?></div>
	<div class='produitInfo'>Zone de vie : <?php echo($poisson->get('zoneDeVie'));?></div>
	<div class='produitInfo'>Esperance de vie: <?php echo($poisson->get('esperanceDeVie'));?></div>

	<div class='produitInfo'>
		<input class="qte" id="qte<?php echo($poisson->get('id_poisson'));?>"
			type="number" value="1" min="1" />
		<button class='detailItem'
			onclick="addToPanier(<?php echo($poisson->get('id_poisson'));?>)">Ajouter
			au panier</button>
	</div>
	
	<?php }else{?>
	
	<div id="compte" class="modal">
		<form method="post" class="modal-content"
			action="./index.php?controller=poisson&action=update&id=<?php echo($poisson->get('id_poisson'));?>">
			<div class="container">
				<h1>Nom : <?php echo($poisson->get('nomCommun'));?></h1>
				<hr>
				<label for="prix"><b>Prix</b></label> 
				<input type="number" min="1"	name="prix" required value="<?php echo($poisson->get('prix'));?>" />
				<label for="taille"><b>Taille </b></label> 
				<input type="text" name="taille" required value="<?php echo($poisson->get('taille'));?>" /> 
				<label for="famille"><b>Famille</b></label> 
				<input	type="text" name="famille" required	value="<?php echo($poisson->get('famille'));?>" />
				<label	for="zoneDeVie"><b>Zone De Vie</b></label> 
				<select name="zoneDeVie" required>
					<option value="douce" <?php echo(($poisson->get('famille') == "douce") ? "selected" : "");?>>douce</option>
					<option value="salée" <?php echo(($poisson->get('famille') == "salée") ? "selected" : "");?>>salée</option>
				</select>	
				<label for="esperanceDeVie"><b>Esperance de vie</b></label> 
				<input	type="text" name="esperanceDeVie" required	value="<?php echo($poisson->get('esperanceDeVie'));?>" />

				<div class="clearfix">
				<button type="submit" class="signupbtn">Mettre a jour</button>
				<button type="button" onclick="supprimerPoisson('<?php echo($poisson->get('id_poisson'))?>');">Supprimer</button>		
				</div>
			</div>
		</form>			
		
	</div>
	<?php }?>
</div>
