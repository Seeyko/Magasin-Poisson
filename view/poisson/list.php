<div class="produitPage">
	<div id="produitAction">
		<form method="post"
			action="./index.php?action=readAll&controller=poisson">	
			<?php require_once './view/poisson/filter.php';?>	
			
			<div>
				<input type="submit" value="Appliquer" />
			</div>
		</form>
	</div>
<?php
echo ('<div class="produitList">');
foreach ($tab_poisson as $poisson) {
    if (! is_null($poisson)) {
        ?>
        <div class='panierItem'>
		<a
			href="./index.php?controller=poisson&action=read&id=<?php echo($poisson->get('id_poisson'));?>">
			<img class='produitImg' src=<?php echo($poisson->image());?>
			alt='Poisson' />
		</a>
		<div class='infoItem'>

			<div class='detailItem'>Prix : <?php echo($poisson->get('prix'));?></div>
			<div class='detailItem'>Nom : <?php echo($poisson->get('nomCommun'));?></div>

			<div class='detailItem'>
				Quantite : <input class="qte"
					id="qte<?php echo($poisson->get('id_poisson'));?>" type="number"
					min="1" value="1" />
			</div>
			<div class='detailItem'>
				<button class='detailItem'
					onclick="addToPanier('<?php echo($poisson->get('id_poisson'));?>')">Ajouter
					au panier</button>
			</div>
		</div>
	</div>
        
        
    <?php
    }
}
if (empty($tab_poisson)) {
    echo ("Aucun poisson avec les caractéristique séléctionné");
}
echo ("</div></div>");
?>
