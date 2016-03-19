<div class="row">
	<div class="col-md-12">
		<h1>
			<?php echo $class->container->title ?>
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<form action="<?php echo $class->basePath ?>/sign/up" method="post" id="registerForm">
			<div class="row">
				<div class="col-md-6">
					<label>Meno</label>
					<input class="form-control" type="text" name="name">
				</div>
				<div class="col-md-6">
					<label>Priezvisko</label>
					<input class="form-control" type="text" name="surname">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-6">
					<label>Email</label>
					<input class="form-control" type="text" name="email">
				</div>
				<div class="col-md-6">
					<label>Pohlavie</label>
					<select class="form-control" name="gender">
						<option value="muž">
							Muž
						</option>
						<option value="žena">
							Žena
						</option>
					</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-6">
					<label>Nick</label>
					<input class="form-control" type="text" name="nick">
				</div>
				<div class="col-md-6">
					<label>Heslo</label>
					<input class="form-control" type="password" name="password">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12 text-right">
					<input type="submit" class="button green" value="Registrovať" name="registerForm" id="registerForm-submit">
				</div>
			</div>
		</form>
	</div>
</div>