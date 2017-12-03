<!DOCTYPE html>
<html lang="fr">

<!-- Debut En-tête -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<meta name="author" content="<?= $ConfigModule->get("Server.Author"); ?>">
		<meta name="generator" content="<?= $ConfigModule->get("Server.Author"); ?>">

		<title>404 Not Found - <?= $ConfigModule->get("Server.Name"); ?></title>

		<?= $ApplicationModule->getBundleCss(); ?>
	</head>
<!-- END En-tête -->

  <body>

	<!-- Corps de Site -->
	<section id="Page">

		<div class="post divSize-80 div-center">
			<div class="post-Title"><a>Error 404</a></div>

			<div class="post-content divInline-center error-block">
				<h1 class="error-name">Not Found</h1>
				<hr class="style-orange">

				<h3 class="error-info">La page que vous avez demandé est introuvable</h3>

				<?php if (!empty($error)): ?>
					<p class="error-message">Error Message : <?= $error; ?></p>
				<?php endif ?>
			</div>
		</div>

	</section>
	
	</body>
</html>
