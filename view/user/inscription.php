<div id="inscription" class="modal">
	<form method="post" class="modal-content"
		action="./index.php?controller=user&action=created">
		<div class="container">
			<h1>Inscription</h1>
			<p>Remplissez ce formulaire pour vous creer un compte</p>
			<hr>
			<label for="mail"><b>Email</b></label> <input type="email"
				placeholder="Votre email" name="mail" id="mail" required
				value="<?php echo((isset($_POST['mail']) ? $_POST['mail'] : ""));?>" />
			<label for="password"><b>Mot de passe</b></label> <input
				type="password" id="password" placeholder="Votre mot de passe" name="password"
				required
				value="<?php echo((isset($_POST['password']) ? $_POST['password'] : ""));?>" />
			<label for="nom"><b>Nom</b></label> <input type="text" id="nom"
				placeholder="Votre nom" name="nom" required
				value="<?php echo((isset($_POST['nom']) ? $_POST['nom'] : ""));?>" />
			<label for="prenom"><b>Prenom</b></label> <input type="text" id="prenom"
				placeholder="Votre prenom" name="prenom" required
				value="<?php echo((isset($_POST['prenom']) ? $_POST['prenom'] : ""));?>" />

			<p>
				En creeant un compte vous acceptez notre<a
					href='./assets/pol/politique_confidentialité.php'
					style="color: dodgerblue">Politique de confidentialite</a>.
			</p>
			<div class="clearfix">
				<button type="button" onclick="location.href = './index.php'"
					class="cancelbtn">Annuler</button>
				<button type="submit" class="signupbtn">M'inscrire</button>
			</div>
		</div>
	</form>
</div>