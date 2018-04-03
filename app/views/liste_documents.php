<h1>Documents visibles</h1>
<hr>
<p class="lead">Liste des documents visibles publiquement</p>

<table class="table table-hover">
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
		</tr>
	</thead>
	<tbody>
		<?php
			while ($row = oci_fetch_array($list))
			{
				echo "<tr>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td>$row[4]</td>
					<td>$row[5]</td>
				</tr>";
			}
		?>
	</tbody>
</table>