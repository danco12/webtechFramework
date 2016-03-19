<div class="row">
	<div class="col-md-12">
		<h1>
			<?php echo $class->container->title ?>
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<form action="<?php echo $class->basePath ?>/sign/in" method="post" id="loginForm">
			<div class="row">
				<div class="col-md-12">
					<label>Nick</label>
					<input class="form-control" type="text" name="nick">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12">
					<label>Heslo</label>
					<input class="form-control" type="password" name="password">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-6 text-left">
					<a class="login" href="<?php echo $class->authUrl?>">
						<img style="height: 35px" src="<?php echo $class->basePath?>/images/google.png" />
					</a>
					<a class="login" href="<?php echo $class->basePath?>/sign/ldap">
						<img style="height: 35px" src="<?php echo $class->basePath?>/images/ais.png" />
					</a>
				</div>
				<div class="col-md-6 text-right">
					<input type="submit" class="button green" value="Odoslať" name="loginForm" id="loginForm-submit">
				</div>
			</div>
		</form>
	</div>
</div>