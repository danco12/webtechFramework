<?php
	$container = require __DIR__ . "/../dano/start.php";
	$error = !(file_exists("../app/pages/".ucfirst($container->class)."Class.php") && file_exists("../app/pages/templates/".$container->class."/".$container->template.".php"));
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <title><?php echo $error ? "Chyba" : $container->title; ?> | Zadanie 2</title>

		<link rel="stylesheet" href="<?php echo $container->basePath?>/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $container->basePath?>/css/style.css">

		<script type="text/javascript" src="<?php echo $container->basePath?>/js/jquery-2.2.1.min.js"></script>
		<script type="text/javascript" src="<?php echo $container->basePath?>/js/bootstrap.js"></script>
		
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
					<a class="navbar-brand" href="<?php echo $container->basePath?>">Zadanie 2</a> 
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

			require_once("../dano/MainClass.php");
			if (!$error){
				require_once("../app/pages/".ucfirst($container->class)."Class.php");
				require_once("../app/pages/templates/".$container->class."/".$container->template.".php");
			}else{
				$container->title = "chyba";
				require_once("../app/pages/templates/error/404.html");
			}
			
		?>
		</div>
			<script type="text/javascript" src="<?php echo $container->basePath?>/js/main.js"></script>
			
	</body>
</html>