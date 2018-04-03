
<h1>S'inscrire</h1>
<hr>
<form action="<?php route('inscription'); ?>" method="POST" accept-charset="utf-8" style="max-width: 600px;">
	<div class="form-group">
		<label for="nom">Votre nom</label>
		<input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" required>
	</div>
	<div class="form-group">
		<label for="prenom">Votre prenom</label>
		<input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prenom" required>
	</div>
	<div class="form-group">
		<label for="email">Adresse email</label>
		<input type="email" class="form-control" id="email" name="email" placeholder="Votre mail" required>
	</div>
	<div class="form-group">
		<label for="login">Votre login</label>
		<input type="text" class="form-control" id="login" name="login" placeholder="Votre login" required>
	</div>	
	<div class="form-group">
		<label for="password">Mot de passe</label>
		<input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe">
	</div>
	<div class="form-check">
		<span class="mr-4">Vous êtes...</span>
		<label class="form-check-label mx-3">
			<input class="form-check-input" type="radio" name="role" value="etudiant"> Etudiant
		</label>
		<label class="form-check-label mx-3">
			<input class="form-check-input" type="radio" name="role" value="enseignant"> Enseignant
		</label>
	</div>
	<input class="btn btn-lg btn-primary" type="submit" name="submit" value="S'inscrire"> <br>
</form>


