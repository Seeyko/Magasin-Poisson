<div id="compte" class="modal">	
	<form method="post" class="modal-content"
		action="./index.php?controller=user&action=updated">
		<div class="container">
			<h1>Mon Compte</h1>
			<p>Vos informations</p>
			<hr>
			<label for="mail"><b>Email</b></label> <input type="mail" name="mail"
				readonly value="<?php echo($_SESSION['mail']);?>" /> <label for="nom"><b>Nom</b></label>
			<input type="text"  value="<?php echo($_SESSION['nom']);?>" name="nom"
				required /> <label for="prenom"><b>Prenom</b></label> <input
				type="text" value="<?php echo($_SESSION['prenom']);?>" name="prenom"
				required />


			<div class="clearfix">
				<button type="button"
					onclick="location.href ='./index.php'"
					class="cancelbtn">Annuler</button>
				<button type="submit" class="signupbtn">Mettre a jour mes
					informations</button>
			</div>
		</div>
	</form>
</div>

<?php 
ControllerCommande::read();
?>
