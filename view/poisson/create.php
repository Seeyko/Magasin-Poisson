<div id="create" class="modal">

      <form method="post" class="modal-content"
       action="./index.php?action=create&controller=poisson">
        <div class="container">
          <h1>Ajouter un poisson</h1>
          <p>
            <label for="nomScientifique">Nom Scientifique</label> :
              <input type="text" placeholder="Ex : Amphiprion ocellaris" name="nomScientifique" id="nomScientifique" required />
            <label for="famille">Famille</label> :
              <input type="text" placeholder="Ex: Pomacentridae" name="famille" id="famille" required />
            <label for="nomCommun">Nom Commun</label> :
              <input type="text" placeholder="Ex : Nemo" name="nomCommun" id="nomCommun" required />
            <label for="taille">Taille</label> :
              <input type="number" name="taille" id="taille" required />
            <select name="zoneDeVie" required>
					<option value="douce">douce</option>
					<option value="salée" >salée</option>
				</select>
			<label for="esperanceDeVie">Esperance De Vie</label> :
              <input type="number"  name="esperanceDeVie" id="esperanceDeVie" required />
            <label for="prix">Prix</label> :
              <input type="number"  name="prix" id="prix" required /> 
          </p>
          <p>
              <input type="submit" value="J'ajoute mon poisson !" />
          </p>
        </fieldset> 
    </form>
      </body>
</html> 



