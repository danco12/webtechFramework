<?php
	$class = new Homepage($container);
	$class->startup();
?>
<form action="<?php echo $class->basePath ?>/homepage/editPerson/<?php echo $class->person['id']?>" method="post" id="editPersonForm">
	<div class="row">
		<div class="col-md-6">
			<label>Meno</label>
			<input type="text" name="name" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->person['name']?>" />

			<label>Dátum narodenia</label>
			<input type="date" name="birthDay" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->person['birthDay']?>" />

			<label>Rodné mesto</label>
			<input type="text" name="birthPlace" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->person['birthPlace']?>" />

			<label>Rodný štát</label>
			<input type="text" name="birthCountry" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->person['birthCountry']?>" />
		</div>
		<div class="col-md-6">
			<label>Priezvisko</label>
			<input type="text" name="surname" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->person['surname']?>" />

			<label>Dátum umretia</label>
			<input type="date" name="deathDay" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->person['deathDay']?>" />

			<label>Mesto smrti</label>
			<input type="text" name="deathPlace" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->person['deathPlace']?>" />

			<label>Štát smrti</label>
			<input type="text" name="deathCountry" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->person['deathCountry']?>" />
		</div>
	</div>
	<div class="row">
		
		<div class="col-md-12 text-right">
			<input type="submit" id="editPersonForm-submit" name="editPersonForm" class="button green" value="Odoslať" style="margin-top: 25px"/>
		</div>
	</div>
</form>