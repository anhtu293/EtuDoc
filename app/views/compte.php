<h1>Mon compte</h1>
<hr>

<h3>Mes informations </h3>
<table class="table table-hover">
	<tbody>
		<tr>
			<th>Prénom</th>
			<td><?php echo $user[1] ?></td>
		</tr>
		<tr>
			<th>Nom</th>
			<td><?php echo $user[1] ?></td>
		</tr>
		<tr>
			<th>Email</th>
			<td><?php echo $user[1] ?></td>
		</tr>
		<tr>
			<th>Login</th>
			<td><?php echo $user[1] ?></td>
		</tr>
		<tr>
			<th>Status</th>
			<td><?php echo $user[1] ?></td>
		</tr>
		<tr>
			<th>Droits</th>
			<td><?php echo ($user[1] ? "Admnistrateur" : "Non admininstrateur") ?></td>
		</tr>
	</tbody>
</table>

<h3>Mes documents </h3>
<table class="table table-hover">
	<thead>
		<tr class="text-center">
			<th colspan="4">Document</th>
			<th colspan="1">Actions</th>
		</tr>
		<tr>
			<th>Titre</th>
			<th>Lien</th>
			<th>Date de publication</th>
			<th>Archivé</th>

			<th>Archiver</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while ($row = oci_fetch_array($list))
				echo "<tr>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td>$row[3]</td>
					<td>$row[5]</td>
				</tr>";
		?>
		<tr>
			<td>data</td>
		</tr>
	</tbody>
</table>