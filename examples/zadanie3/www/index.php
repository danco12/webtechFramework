<?php
	session_start();
	// session_unset ();exit;
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	$container = require __DIR__ . "/../dano/start.php";

	/**
	 * dynamicke nacitanie Classy 
	 */
	if (file_exists(__DIR__."/../app/pages/".ucfirst($container->class)."Controller.php")){
		require_once(__DIR__."/../dano/MainController.php");
		require_once(__DIR__."/../app/pages/".ucfirst($container->class)."Controller.php");
		$reflClass = new ReflectionClass(ucfirst($container->class));
		$class = $reflClass->newInstanceArgs(array( $container )); 
		$class->startup();
	}

	/**
	 * 
	 */
	if (file_exists(__DIR__."/../app/pages/".ucfirst($container->class)."Controller.php") && file_exists(__DIR__."/../app/pages/templates/".$container->class."/".$container->template.".php")){
		$target_template = $container->class."/".$container->template.".php";
	}else{
		$container->title = "chyba";
		$target_template = "error/404.html";
	}

	$user = $class->user;

	if (isset($user->id))
		$user_info = $class->user_manager->byId($user->id);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <title><?php echo $container->title ?> | Zadanie 3</title>

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
					<a class="navbar-brand" href="<?php echo $container->basePath?>">Zadanie 3</a> 
				</div> 

				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-6"> 
					<ul class="nav navbar-nav"> 
						<li <?php if ($container->checkLink("homepage/default")) echo "class='active'";?>>
							<a href="<?php echo $container->basePath?>">Domov</a>
						</li>
						<?php if (!$user->isLoggedIn()){ ?>
						<li <?php if ($container->checkLink("sign/in")) echo "class='active'";?>>
							<a href="<?php echo $container->basePath?>/sign/in">Prihlásenie</a>
						</li>
						<?php } ?>

						<?php if (!$user->isLoggedIn()){ ?>
							<li <?php if ($container->checkLink("sign/up")) echo "class='active'";?>>
								<a href="<?php echo $container->basePath?>/sign/up">Registrácia</a>
							</li>
						<?php } ?>

						<?php if ($user->isLoggedIn()){ ?>
							<li <?php if ($container->checkLink("dashboard/default")) echo "class='active'";?>>
								<a href="<?php echo $container->basePath?>/dashboard/default">Dashboard</a>
							</li>
						<?php } ?>

						<?php if ($user->isLoggedIn()){ ?>
							<li <?php if ($container->checkLink("sign/out")) echo "class='active'";?>>
								<a href="<?php echo $container->basePath?>/sign/out">Odhlásenie</a>
							</li>
						<?php } ?>

						
					</ul>
				</div>
			</div>
		</nav>
		
		
		<div class="container">
			<?php 
				if ($class->flash_messages->exist()){
					foreach ($class->flash_messages->getMessages() as $f) {?>
						<div class="text-center alert alert-<?php echo $f['type']?>">
							<div class="row">
								<div class="col-md-12">
									<?php echo $f["message"]?>
								</div>
							</div>
						</div>
			<?php
					}
				}
			?>
		<?php
			require_once __DIR__."/../app/pages/templates/".$target_template;
			// $class->flash_messages->clean();
		?>
		</div>
		<script type="text/javascript" src="<?php echo $container->basePath?>/js/main.js"></script>
	</body>
</html>