<h1>Ajouter une licence</h1>
<hr>
<form action="<?php echo route('admin/ajouterLicence'); ?>" method="POST" accept-charset="utf-8" style="max-width: 600px;">
	<div class="form-group">
		<label for="licence">Nom de la licence :</label>
		<input type="text" class="form-control" id="licence" name="licence" required>
	</div>
	<input class="btn btn-lg btn-primary" type="submit" name="submit" value="Ajouter">
</form>