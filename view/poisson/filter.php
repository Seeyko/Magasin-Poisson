<div>
	<label for="tri">Trier par :</label> <select id="tri" name="tri" size="1">
		<option value='nomCommun_asc'
			<?php if (isset($_POST['tri']) && $_POST['tri'] == "nomCommun_asc") echo 'selected="selected" '; ?>>Nom
			- alphabetique</option>
		<option value='nomCommun_desc'
			<?php if (isset($_POST['tri']) && $_POST['tri'] == "nomCommun_desc") echo 'selected="selected" '; ?>>Nom
			- inv alphabetique</option>
		<option value='prix_asc'
			<?php if (isset($_POST['tri']) && $_POST['tri'] == "prix_asc") echo 'selected="selected" '; ?>>Prix
			- croissant</option>
		<option value='prix_desc'
			<?php if (isset($_POST['tri']) && $_POST['tri'] == "prix_desc") echo 'selected="selected" '; ?>>Prix
			- decroissant</option>
		<option value='taille_asc'
			<?php if (isset($_POST['tri']) && $_POST['tri'] == "taille_asc") echo 'selected="selected" '; ?>>Taille
			- croissante</option>
		<option value='taille_desc'
			<?php if (isset($_POST['tri']) && $_POST['tri'] == "taille_desc") echo 'selected="selected" '; ?>>Taille
			- decroissante</option>
	</select>
</div>

<div>Cocher les caractéristiques :</div>
<fieldset>
	<legend>Zone de vie :</legend>
	<?php

$zones = ModelPoisson::getColumn('zoneDeVie');
foreach ($zones as $zone) {
    ?>
    <div><input type="checkbox" id="<?php echo($zone->zoneDeVie);?>"
		name="filter[]" value="zoneDeVie_<?php echo($zone->zoneDeVie);?>"
		<?php if ( (isset($_POST['filter'])) && strpos(serialize($_POST['filter']), "zoneDeVie_$zone->zoneDeVie") !== false) { echo('checked="checked"');}  ?> />
	<label for="<?php echo($zone->zoneDeVie);?>">Eau <?php echo($zone->zoneDeVie);?></label></div>
	<?php }?>
</fieldset>

<fieldset>
	<legend>Famille :</legend>
	<?php
$familles = ModelPoisson::getColumn('famille');
foreach ($familles as $f) {
    ?>
    <div><input type="checkbox" id="<?php echo($f->famille);?>"
		name="filter[]" value="famille_<?php echo($f->famille);?>"
		<?php if ( (isset($_POST['filter'])) && strpos(serialize($_POST['filter']), "famille_$f->famille") !== false) { echo('checked="checked"');}  ?> />
	<label for="<?php echo($f->famille);?>"><?php echo($f->famille);?></label></div>
	<?php }?>
</fieldset>
