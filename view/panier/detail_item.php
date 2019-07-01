<div class='panierItem'>
	<a href="./index.php?controller=poisson&action=read&id=<?php echo($poisson->get('id_poisson'));?>">
	
	<img alt='Poisson' class='produitImg' src=<?php echo($poisson->image());?> /></a>
	<div class='infoItem'>

		<div class='detailItem'>Prix : <?php echo($poisson->get('prix'));?></div>
		<div class='detailItem'>Nom : <?php echo($poisson->get('nomCommun'));?></div>

		<div class='detailItem'>Quantite :
			<input class="qte" id="qte<?php echo($i[0]);?>" type="number" min="1"
				value="<?php echo($i[1]);?>" />
			
		</div>
		<div class='detailItem'>
		<button class='detailItem'
				onclick="changeQuantity('<?php echo($i[0]);?>')">Modifier</button>
				
			<button class='detailItem'
				onclick="removeFromPanier('<?php echo($i[0]);?>')">Supprimer</button>
		</div>
	</div>
</div>
