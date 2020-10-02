<?php
/**
 * fliegwerk link page
 * by fliegwerk
 * (c) 2020. MIT License
 */

require_once "definitions.php";
require_once "config.php";
require_once "styles.php";

$images = glob(IMAGE_PATH . "/*");

try {
	$config = parse_config();
} catch (Exception $e) {
	$error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">

	<title><?php echo $config->title ?? $error ?? "Unknown error"; ?></title>

	<link rel="apple-touch-icon" sizes="180x180" href="icons/apple-touch-icon.png?v=Ryx4Lajeq9">
	<link rel="icon" type="image/png" sizes="32x32" href="icons/favicon-32x32.png?v=Ryx4Lajeq9">
	<link rel="icon" type="image/png" sizes="16x16" href="icons/favicon-16x16.png?v=Ryx4Lajeq9">
	<link rel="manifest" href="icons/site.webmanifest?v=Ryx4Lajeq9">
	<link rel="mask-icon" href="icons/safari-pinned-tab.svg?v=Ryx4Lajeq9" color="#5656b1">
	<link rel="shortcut icon" href="icons/favicon.ico?v=Ryx4Lajeq9">
	<meta name="msapplication-TileColor" content="#2d89ef">
	<meta name="msapplication-config" content="icons/browserconfig.xml?v=Ryx4Lajeq9">
	<meta name="theme-color" content="#ffffff">

	<link rel="stylesheet" type="text/css" href="index.css">
	<style>
		<?php if (isset($config)) foreach ($config->sections as $section) {
			echo build_color_styles($section->id, $section->color);
		} ?>
	</style>
</head>

<body>
<?php

if (isset($config)): ?>
	<nav>
		<input type="checkbox" id="MenuTrigger" />
		<label for="MenuTrigger" id="MenuTriggerLabel">
			Menu
		</label>
		<ul id="MainMenu">
			<?php foreach ($config->sections as $section): ?>
				<li class="<?php echo $section->id; ?>">
					<a href="<?php echo "#" . $section->id; ?>"><?php echo $section->name; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>

	<?php foreach ($config->sections as $section): ?>
		<section id="<?php echo $section->id; ?>">
			<header>
				<h2><?php echo $section->name; ?></h2>
			</header>
			<ul>
				<?php foreach ($section->links as $link): ?>
					<li id="<?php echo $link->id; ?>">
						<a href="<?php echo $link->url; ?>">
							<aside>
								<?php echo render_image($images, $section->color, $link->id, $link->name); ?>
							</aside>
							<main>
								<h3><?php echo $link->name; ?></h3>
								<hr>
								<p><?php echo $link->description; ?></p>
							</main>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endforeach; ?>

	<footer>
		<div>by fliegwerk</div>
		<div>&copy; 2020</div>
	</footer>

<?php else: ?>
	<section class="error">
		<div>
			<h3>Configuration error</h3>
			<hr>
			<p><?php echo $error ?? "Unknown error happened" ?></p>
		</div>
	</section>
<?php endif; ?>
</body>
</html>
