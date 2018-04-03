<h1> Ajouter un document </h1>
<form action="<?php route('ajouterDocument'); ?>" method="POST" accept-charset="utf-8">

<div class="row py-3">
	<div class="col-md-6">
		<h4>Document</h4>
		<div class="form-group">
			<label for="titre">Titre</label>
			<input type="text" class="form-control" id="titre" name="titre">
		</div>
		<div class="form-group">
			<label for="semestre">Semestre</label>
			<input type="text" class="form-control" id="semestre" name="semestre">
		</div>
		<div class="form-group">
			<label for="fichier">Fichier</label>
			<input type="text" class="form-control" id="fichier" name="fichier">
			<small>Donner le nom du fichier, par exemple "fichier.txt"</small>
		</div>
		<div class="form-group">
			<label for="licences">Licences</label>
			<select class="form-control" name="licences[]" multiple>
			<?php 
				$BDD = getDB();
					$query = "SELECT * FROM Licence";
					$licences = oci_parse($BDD, $query);
					oci_execute($licences);
					while ($row = oci_fetch_array($licences, OCI_NUM))
						echo "<option value='$row[0]'>$row[0]</option>";
			?>
			</select>
		</div>
		<div class="text-center mt-3">
			<input class="btn btn-lg btn-primary" type="submit" name="submit" value="Ajouter le document">
		</div>
	</div>

	<div class="col-md-6">
		<h4>Contributeurs</h4>
		<div id="contributeurs" class="row">
			<div class="form-group col-12">
				<label for="email">Email</label>
				<input type="text" class="form-control" id="email" name="contributeurs[0][email]">
			</div>
			<div class="form-group col-md-6">
				<label for="prenom">Prénom</label>
				<input type="text" class="form-control" id="prenom" name="contributeurs[0][prenom]">
			</div>
			<div class="form-group col-md-6">
				<label for="nom">Nom</label>
				<input type="text" class="form-control" id="nom" name="contributeurs[0][nom]">
			</div>
		</div>
		<div class="text-center mt-3">
			<a class="btn btn-lg btn-outline-secondary" onClick="ajouterContributeur();">Ajouter un contributeur</a>
		</div>
	</div>
</div>
</form>

<script type="text/javascript" charset="utf-8">
	var i = 1;
	function ajouterContributeur() {
		document.getElementById("contributeurs").innerHTML += '<div class="col-12"><hr></div><div class="form-group col-12"><label for="email">Email</label><input type="text" class="form-control" id="email" name="contributeurs['+i+'][email]"></div><div class="form-group col-md-6"><label for="prenom">Prénom</label><input type="text" class="form-control" id="prenom" name="contributeurs['+i+'][prenom]"></div><div class="form-group col-md-6"><label for="nom">Nom</label><input type="text" class="form-control" id="nom" name="contributeurs['+i+'][nom]"></div>';
		i++;
	}
	function ajouterLicence() {
	}
</script>