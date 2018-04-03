<h1>Résultat de la recherche</h1>
<hr>
<p class="lead mb-0">Requête utilisée :</p>
<p class="mb-3">
	<?php echo $fullQuery; ?>
</p>
<table class="table table-hover">
	<thead>
		<tr class="text-center">
			<th colspan="4">Document</th>
			<th colspan="3">Propriétaire</th>
		</tr>
		<tr>
			<th>Titre</th>
			<th>Lien</th>
			<th>Date de publication</th>
			<th>Semestre</th>

			<th>Login</th>
			<th>Prénom</th>
			<th>Nom</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while ($row = oci_fetch_array($documents, OCI_NUM)) {
				echo "<tr>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td>$row[4]</td>
					<td>$row[5]</td>
					<td>$row[6]</td>
				</tr>";
			}
		?>
	</tbody>
</table>
