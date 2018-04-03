<h1>Accueil</h1>
<hr class="mb-5">

<div class="row">
	<div class="col-md-6">
		<p class="lead">Liste des fonctionnalités implémentées</p>
		<ul>
			<li>Public</li>
			<ul>
				<li><a href="<?php echo route("documents") ?>">Voir tous les documents</a></li>
				<li><a href="<?php echo route("rechercher") ?>">Rechercher un document</a></li>
				<li><a href="<?php echo route("login") ?>">Se connecter</a></li>
			</ul>
			<li>Utilisateur connecté</li>
			<ul>
				<li><a href="<?php echo route("user/ajouterDocument") ?>">Ajouter un document</a></li>
				<li><a href="<?php echo route("user/supprimerDocument") ?>">Supprimer un document</a></li>
				<li><a href="<?php echo route("logout") ?>">Se déconnecter</a></li>
			</ul>
			<li>Administrateur</li>
			<ul>
				<li><a href="<?php echo route("admin/archiverDocument") ?>">Archiver un document</a></li>
				<li><a href="<?php echo route("admin/ajouterLicence") ?>">Ajouter des licences</a></li>
			</ul>
		</ul>
	</div>
	<div class="col-md-6">
		<p class="lead">Comment tester ?</p>
		<p>Les mots de passes sont pour la plupart 12345678</p>
		<p>admin : stcrozat</p>
	</div>
</div>
