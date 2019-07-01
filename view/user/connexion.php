<div id="connexion" class="modal">
	<form method="post" class="modal-content"
		action="./index.php?controller=user&action=connected">
		<div class="container">
			<h1>Connexion</h1>
			<p>Remplissez ce formulaire pour vous connectez</p>
			<hr>
			<label for="mail"><b>Email</b></label> <input type="email" id="mail"
				placeholder="Votre email" name="mail"
				value="<?php echo((isset($_POST['mail']) ? $_POST['mail'] : ""));?>"
				required /> <label for="password"><b>Mot de passe</b></label> <input
				type="password" id="password" placeholder="Votre mot de passe"
				name="password"
				value="<?php echo((isset($_POST['password']) ? $_POST['password'] : ""));?>"
				required />

			<div class="clearfix">
				<button type="button" onclick="location.href = './index.php'"
					class="cancelbtn">Annuler</button>
				<button type="submit" class="signupbtn">Connexion</button>
			</div>
		</div>
	</form>
</div>