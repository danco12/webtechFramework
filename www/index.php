<?php
	$container = require __DIR__ . "/../webtechF/start.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <title><?php echo $container->title; ?> | Zadanie 2</title>

		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">

		<script type="text/javascript" src="<?php echo $basePath?>/js/jquery-2.2.1.min.js"></script>
		<script type="text/javascript" src="<?php echo $basePath?>/js/bootstrap.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-inverse">
			<div class="container-fluid"> 
				<div class="navbar-header"> 
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6" aria-expanded="false"> 
						<span class="sr-only">Toggle navigation</span> 
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span> 
					</button> 
					<a class="navbar-brand" href="<?php echo $basePath?>">Zadanie 2</a> 
				</div> 

				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-6"> 
					<ul class="nav navbar-nav"> 
						<li <?php if ($container->file == "homepage") echo "class='active'";?>>
							<a href="<?php echo $container->basePath?>">Domov</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
		<?php
			require_once($container->path);
		?>
		</div>
	</body>
	<?php
	$container->database->close();
	?>
</html>