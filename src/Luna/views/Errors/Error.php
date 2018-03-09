<!DOCTYPE html>
<html lang="fr">

<!-- Debut En-tête -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<meta name="author" content="<?= $ConfigModule->get("Server.Author"); ?>">
		<meta name="generator" content="<?= $ConfigModule->get("Server.Author"); ?>">

		<title><?= $code ?> <?= $codeName ?> - <?= $ConfigModule->get("Server.Name"); ?></title>

		<?= $ApplicationModule->getBundleCss(); ?>
	</head>
<!-- END En-tête -->

  <body>

	<!-- Corps de Site -->
	<section id="Page">

		<div class="post divSize-80 div-center">
			<div class="post-Title"><a>Error <?= $code ?></a></div>

			<div class="post-content divInline-center error-block">
				<h1 class="error-name"><?= $codeName ?></h1>
				<hr class="style-orange">

				<h3 class="error-info">Un problème à eu lieu lors du traitement de votre requête</h3>

				<?php if (!empty($error)): ?>
					<p class="error-message">Error Message : <?= $error; ?></p>
				<?php endif ?>
			</div>
		</div>

	</section>
	
	</body>
</html>
