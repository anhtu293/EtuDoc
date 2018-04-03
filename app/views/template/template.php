<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>NA17 - Groupe 10</title>

	<link rel="stylesheet" href="<?php echo asset("css/bootstrap.min.css"); ?>" crossorigin="anonymous">
</head>

<body>
	<nav id="header" class="navbar navbar-expand-md navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand p-0 mr-md-5" href="<?php echo route("") ?>">NA17 - Groupe 10</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="menu">
				<ul class="navbar-nav ml-auto mt-2 mt-md-0">
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo route(""); ?>">Accueil <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo route("documents"); ?>">Voir les documents</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo route("rechercher"); ?>">Rechercher</a>
					</li>
					<?php
					if (isLoggued()) {
						echo '<li class="nav-item"><a class="nav-link" href="' . route("logout") . '">Se déconnecter</a></li>';
					} else {
						echo '<li class="nav-item"><a class="nav-link" href="' . route("login") . '">Se connecter</a></li>';
					}
					?>
				</ul>
			</div>
		</div>
	</nav>

	<main id="content" class="py-5 container">
		<?php
			if(isset($message))
				echo '<div class="alert alert-primary alert-dismissible fade show mb-4" role="alert">'.$message.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		?>
		<?php echo isset($content) ? $content : 'Pas de vue sélectionnée'; ?>
	</main>

	<footer class="fixed-bottom bg-dark">
		<p class="text-center text-white m-0 py-2">NA17 - Groupe 10 : Alexandre Brasseur x Anh Tu Nguyen x Camille Beaudou x Kyllian Chartrain</p>
	</footer>

	<script src="<?php echo asset("js/jquery-3.2.1.min.js"); ?>"></script>
	<script src="<?php echo asset("js/popper.min.js"); ?>"></script>
	<script src="<?php echo asset("js/bootstrap.min.js"); ?>"></script>
</body>
</html>