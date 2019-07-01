<?php 
foreach ($command as $v){
    
    $produit = ModelPoisson::getById($v[0]);
    $img = $produit->image();
    ?>
    <a href="./index.php?controller=poisson&action=read&id=<?php echo($v[0]);?>">
    
    <?php echo("<div class='commandeDetail'><img alt='Poisson' class='produitImg' src='$img'>". $produit->get('nomCommun') . "  Quantité : ". $v[1] .'</img></a></div>');
}

?>