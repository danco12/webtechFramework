<div class="row">
	<div class="col-md-12">
		<h1>
			<?php echo $class->container->title ?>
		</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<form action="<?php echo $class->basePath ?>/sign/in" method="post" id="loginLdapForm">
			<div class="row">
				<div class="col-md-12">
					<label>AIS login</label>
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
				<div class="col-md-12 text-right">
					<input type="submit" class="button green" value="Odoslať" name="loginLdapForm" id="loginLdapForm-submit">
				</div>
			</div>
		</form>
	</div>
</div>