<?php
$total = 0;
$nbItem = 0;

$panier = null;
if (((isset($_COOKIE['panier'])) && ($_COOKIE['panier'] != 'yes'))) {
    $panier = unserialize($_COOKIE['panier']);
    echo ("<div class='panier'><div class='listPanier'>");
    foreach ($panier as $i) {
        $poisson = ModelPoisson::getById($i[0]);
        if (! is_null($i)) {
            $nbItem += (1 * $i[1]);
            $total += $poisson->get('prix') * $i[1];
            require File::build_path(array(
                'view',
                'panier',
                'detail_item.php'
            ));
        }
    }
}
if($nbItem > 0){
    echo ("</div><div class='panierInfo'>");
    echo ("<div>Total : $total euros</div><div>Nombre d'item : " . $nbItem);
    ?>
<form method="post"
	action="./index.php?action=command&controller=commande">
	<input class="button" type="submit" value="Commander">
</form>
</div></div></div>
<?php
} else {
    echo ("<div class='panierInfo'>");
    echo ("Votre panier est vide, ajoutez y des poissons pour passez commande");
    ?>
<form method="post" action="./index.php">
	<input class="button" type="submit" value="Achetez">
</form></div>
<?php
}
?>