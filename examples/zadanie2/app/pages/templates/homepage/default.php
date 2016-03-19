<?php
	$class = new Homepage($container);
	$class->startup();
?>
<div class="row">
	<div class="col-md-12">
		<h1>
			Zadanie 2
		</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12" style="margin-bottom: 25px;">
		<a class="button green" data-toggle="modal" data-target="#addPerson">Pridať osobu</a>
	</div>
</div>
<div class="row" id="homepage">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th> ID </th>
					<th>Meno</th>
					<th><a href="<?php echo $container->basePath?>?order=surname,name">Priezvisko</a></th>
					<th><a href="<?php echo $container->basePath?>?order=year">Rok</a></th>
					<th>Miesto</th>
					<th><a href="<?php echo $container->basePath?>?order=type,year">Typ OH</a></th>
					<th>Disciplína</th>
					<th>Akcie</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while($row = $class->list->fetch_assoc()){
				?>
					<tr>
						<td><?php echo $row["id"] ?></td>
						<td>
							<a href="<?php echo $container->basePath?>/homepage/view/<?php echo $row["id"] ?>">
								<?php echo $row["name"] ?>
							</a>
						</td>
						<td>
							<a href="<?php echo $container->basePath?>/homepage/view/<?php echo $row["id"] ?>">
								<?php echo $row["surname"] ?>
							</a>
						</td>
						<td><?php echo $row["year"]?$row["year"]:"-" ?></td>
						<?php 
							$city = $row["city"]?$row["city"]:"-"; 
							$country = $row["country"]?$row["country"]:"-";
						?>
						<td><?php echo $city . ", " . $country ?></td>
						<td><?php echo $row["type"]?$row["type"]:"-" ?></td>
						<td><?php echo $row["discipline"]?$row["discipline"]:"-" ?></td>
						<td>
							<a href="<?php echo $class->basePath; ?>/homepage/editUmiestnenie/<?php echo $row['uid'] ?>"class="button blue" style="margin-right: 10px"><span class="glyphicon glyphicon-pencil"></span></a>
							<a href="<?php echo $class->basePath; ?>/homepage/default/?action=deletePerson&id=<?php echo $row["id"]; ?>" class="button red"><span class="glyphicon glyphicon-trash"></span></a>
						</td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="modal fade" id="addPerson">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Pridať osobu</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo $class->basePath ?>/homepage/default" method="post" id="addPersonForm">
					<div class="row">
						<div class="col-md-6">
							<label>Meno</label>
							<input type="text" name="name" class="form-control" style="margin-bottom: 20px" />

							<label>Dátum narodenia</label>
							<input type="date" name="birthDay" class="form-control" style="margin-bottom: 20px" />

							<label>Rodné mesto</label>
							<input type="text" name="birthPlace" class="form-control" style="margin-bottom: 20px" />

							<label>Rodný štát</label>
							<input type="text" name="birthCountry" class="form-control" style="margin-bottom: 20px" />
						</div>
						<div class="col-md-6">
							<label>Priezvisko</label>
							<input type="text" name="surname" class="form-control" style="margin-bottom: 20px" />

							<label>Dátum umretia</label>
							<input type="date" name="deathDay" class="form-control" style="margin-bottom: 20px" />

							<label>Mesto smrti</label>
							<input type="text" name="deathPlace" class="form-control" style="margin-bottom: 20px" />

							<label>Štát smrti</label>
							<input type="text" name="deathCountry" class="form-control" style="margin-bottom: 20px" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<hr>
						</div>
					</div>
					<div class="row">
						
					</div>
					<div class="row">
						
						<div class="col-md-12 text-right">
							<input type="submit" id="addPersonForm-submit" name="addPersonForm" class="button green" value="Odoslať" style="margin-top: 25px"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
