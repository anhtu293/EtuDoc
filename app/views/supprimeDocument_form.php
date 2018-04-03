<h1> Supprimer un document </h1>

<form action="<?php route('user/supprimerDocument'); ?>" method="POST" accept-charset="utf-8">

<h4>Document</h4>
<?php

	//Si user n'est pas un admin, il n'a que droit de supprimer les documents dont il est propriétaire
	$BDD = getDB();

	if (isAdmin()==false) {
			$query = "SELECT d.lien, d.titre FROM Document d WHERE d.proprietaire.login ='".$_SESSION["login"]."'";
			$doc = oci_parse($BDD,$query);
			oci_execute($doc);
			if (oci_fetch_array($doc,OCI_BOTH)==NULL) {
				echo "Vous n'avez pas des documents";
			} else {echo '<table class="table table-hover">
					<thead>
						<tr class="text-center">
							<th colspan="3">Document</th>
							<th colspan="3">Propriétaire</th>
						</tr>
						<tr>
							<th>Titre</th>
							<th>Lien</th>
							<th>Date de publication</th>

							<th>Login</th>
							<th>Prénom</th>
							<th>Nom</th>
							<th> </th>
						</tr>
					</thead>
					<tbody>';
				$query = "SELECT d.lien, d.titre, d.date_publication, d.proprietaire.login, d.proprietaire.prenom, d.proprietaire.nom FROM Document d WHERE d.proprietaire.login ='".$_SESSION["login"]."'";
				$doc = oci_parse($BDD,$query);
				oci_execute($doc);
				while ($row=oci_fetch_array($doc,OCI_BOTH)) {
					echo "<tr>
					<td>$row[1]</td>
					<td>$row[0]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td>$row[4]</td>
					<td>$row[5]</td>";
					echo '<th><div class="form-group">';
					echo '<input type="radio" class="form-control" name="document" value="'.$row[0].'"/> </div></th></tr>';
				}
			echo '</tbody></table>';
				echo '<div class="col-12 text-center mt-3">';
				echo '<input class="btn btn-lg btn-primary" type="submit" name="submit" value="Supprimer">';
				echo '</div>';

			}
		} else { 
		echo '<h4>Document</h4>';
		//admin a droit de supprimer tous les documents dans BDD
		echo '<table class="table table-hover">
					<thead>
						<tr class="text-center">
							<th colspan="3">Document</th>
							<th colspan="3">Propriétaire</th>
						</tr>
						<tr>
							<th>Titre</th>
							<th>Lien</th>
							<th>Date de publication</th>

							<th>Login</th>
							<th>Prénom</th>
							<th>Nom</th>
							<th> </th>
						</tr>
					</thead>
					<tbody>';
				$query = "SELECT d.lien, d.titre, d.date_publication , d.proprietaire.login, d.proprietaire.prenom, d.proprietaire.nom FROM Document d";
				$doc = oci_parse($BDD,$query);
				oci_execute($doc);
				while ($row=oci_fetch_array($doc,OCI_BOTH)) {
					echo "<tr>
					<td>$row[1]</td>
					<td>$row[0]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td>$row[4]</td>
					<td>$row[5]</td>";
					echo '<th><div class="form-group">';
					echo '<input type="radio" class="form-control" name="document" value="'.$row[0].'"/> </div></th></tr>';
				}
			echo '</tbody></table>';
				echo '<div class="col-12 text-center mt-3">';
				echo '<input class="btn btn-lg btn-primary" type="submit" name="submit" value="Supprimer">';
				echo '</div>';

			}
?>

