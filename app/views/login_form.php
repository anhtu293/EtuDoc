<h1>Se connecter</h1>
<hr>

<form action="<?php echo route('login'); ?>" method="POST" accept-charset="utf-8" style="max-width: 600px;">
	<div class="form-group">
		<label for="login">Login CAS UTC</label>
		<input type="text" class="form-control" id="login" name="login" placeholder="Votre login CAS" required>
	</div>
	<div class="form-group">
		<label for="password">Mot de passe</label>
		<input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe">
	</div>
	<input class="btn btn-lg btn-primary" type="submit" name="submit" value="Se connecter">
</form>
<a href="<?php echo route('inscription')?>"> S'inscrire </a> 