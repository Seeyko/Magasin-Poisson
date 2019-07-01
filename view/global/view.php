<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title><?php echo $pagetitle; ?></title>
<link rel="stylesheet" type="text/css" href="./theme.css">

<script	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</head>

<body>
	<div class="ocean">
		<div class="wave"></div>
		<div class="wave"></div>
	</div>

	<header>
	<?php require (File::build_path(array('view', 'global', 'nav.php')))?>
</header>
		<?php

// Si $controleur='voiture' et $view='list',
// alors $filepath="/chemin_du_site/view/voiture/list.php"
$filepath = File::build_path(array(
    "view",
    $controller,
    "$view.php"
));
require_once $filepath;

?>
<footer>
		<div>Poisson clown</div>
		<div>
			<a href="http://jigsaw.w3.org/css-validator/check/referer"> <img
				style="border: 0; width: 88px; height: 31px"
				src="http://jigsaw.w3.org/css-validator/images/vcss"
				alt="CSS Valide !" />
			</a>
		</div>
		<div>
			<a href="http://jigsaw.w3.org/css-validator/check/referer"> <img
				style="border: 0; width: 88px; height: 31px"
				src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
				alt="CSS Valide !" />
			</a>
		</div>

	</footer>
	<script src="script/main.js">

</script>

</body>

</html>

