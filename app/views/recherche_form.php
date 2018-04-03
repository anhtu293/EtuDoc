<h1>Rechercher un document</h1>
<hr>

<form action="<?php echo route('rechercher'); ?>" method="POST" accept-charset="utf-8">
<div class="row py-3">
	<!-- TODO : ajouter semestre, archivage,  -->
	<div class="col-md-4">
		<h4>Document</h4>
		<div class="form-group">
			<label for="titre">Titre</label>
			<input type="text" class="form-control" id="titre" name="titre">
		</div>
		<div class="form-group">
			<label for="date">Date de publication</label>
			<input type="date" class="form-control" id="date" name="date">
		</div>
		<div class="form-group">
			<label for="semestre">Semestre</label>
			<input type="text" class="form-control" id="semestre" name="semestre">
		</div>
		<div class="form-group">
			<label for="licence">Licence</label>
			<select class="form-control" name="licences">
			<?php 
				$BDD = getDB();
					$query = "SELECT nom FROM Licence";
					$licences = oci_parse($BDD, $query);
					oci_execute($licences);
					while ($row = oci_fetch_array($licences, OCI_NUM))
						echo "<option value='$row[0]'>$row[0]</option>";
			?>
			</select>
		</div>
	</div>

	<div class="col-md-4">
		<h4>Propriétaire</h4>
		<div class="form-group">
			<label for="proprio_email">Email</label>
			<input type="email" class="form-control" id="proprio_email" name="proprio_email">
		</div>
		<div class="form-group">
			<label for="proprio_prenom">Prénom</label>
			<input type="text" class="form-control" id="proprio_prenom" name="proprio_prenom">
		</div>
		<div class="form-group">
			<label for="proprio_nom">Nom</label>
			<input type="text" class="form-control" id="proprio_nom" name="proprio_nom">
		</div>
	</div>

	<div class="col-md-4">
		<h4>Contributeur</h4>
		<div class="form-group">
			<label for="contrib_email">Email</label>
			<input type="email" class="form-control" id="contrib_email" name="contrib_email">
		</div>
		<div class="form-group">
			<label for="contrib_prenom">Prénom</label>
			<input type="text" class="form-control" id="contrib_prenom" name="contrib_prenom">
		</div>
		<div class="form-group">
			<label for="contrib_nom">Nom</label>
			<input type="text" class="form-control" id="contrib_nom" name="contrib_nom">
		</div>
	</div>
	<div class="col-12 text-center mt-3">
		<input class="btn btn-lg btn-primary text-center" type="submit" name="submit" value="Rechercher" style="min-width: 50%;">
	</div>
</div>
</form>