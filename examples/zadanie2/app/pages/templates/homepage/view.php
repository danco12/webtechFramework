<?php
	$class = new Homepage($container);
	$class->startup();
?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-info">
			<div class="panel-heading">
				<?php echo $class->person["name"] . " " . $class->person["surname"] ?>
				<a class="glyphicon glyphicon-pencil" href="<?php echo $class->basePath ?>/homepage/editPerson/<?php echo $class->person['id']?>"></a>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-xs-2">
								<img src="<?php echo $class->basePath ?>/images/baby.png" class="icon"/>
							</div>
							<div class="col-xs-10">
								<div class="row">
									<div class="col-md-12">
									<?php
										$date = new DateTime($class->person["birthDay"] ); 
										echo $date->format("d.m.Y");
									?>
									</div>
									<div class="col-md-12">
										<?php echo $class->person["birthPlace"] . ", " . $class->person["birthCountry"] ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-xs-2">
								<img src="<?php echo $class->basePath ?>/images/tomb_cross.png" class="icon"/>
							</div>
							<div class="col-xs-10">
								<div class="row">
									<div class="col-md-12">
									<?php
										if ($class->person["deathDay"] != null && $class->person["deathDay"] != ""){
											$date = new DateTime($class->person["deathDay"] ); 
											echo $date->format("d.m.Y");
										}else{
											echo "Ešte neumrel";
										}
									?>
									</div>
									<div class="col-md-12">
										<?php 
											if ($class->person["deathDay"] != null && $class->person["deathDay"] != "")
												echo $class->person["deathPlace"] . ", " . $class->person["deathCountry"];
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php
							if ( $class->person_places != null && mysqli_num_rows ($class->person_places) > 0 ){
								while ($row = $class->person_places->fetch_assoc()){
						?>
									<div class="row">
										<div class="col-md-12">
											<?php echo $row["type"] . ", " . $row["year"] . ", " . $row["city"] . ", " . $row["country"]; ?>
											<a class="glyphicon glyphicon-trash" href="<?php echo $class->basePath ?>/homepage/view/<?php echo $class->person['id']?>?action=deleteUmiestnenie&id=<?php echo $row['uid'] ?>"></a>
										</div>
									</div>
									<div class="row">
										<div class="col-md-10 col-md-offset-2">
											<?php
												$medal = null;
												switch ($row["place"]) {
													case 1:
														$medal = "gold";
														break;
													case 2:
														$medal = "silver";
														break;
													case 3:
														$medal = "bronze";
														break;
												}
											?>
											<?php if ($medal){ ?>
												<img class="icon" src="<?php echo $class->basePath ?>/images/medals/<?php echo $medal ?>.png"/>
											<?php } ?>
											<?php echo $row["place"] . ".miesto"; ?>

										</div>
									</div>
									<div class="row">
										<div class="col-md-10 col-md-offset-2">
											<b><?php echo ucfirst($row["discipline"]); ?></b>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<hr>
										</div>
									</div>
						<?php
								}
							}else{
						?>
								Športovec nemá žiadne umiestnenia
						<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<h1>Nové umiestnenie</h1>
	</div>
</div>
<form action="<?php echo $class->basePath ?>/homepage/view/<?php echo $class->person['id']?>" method="post" id="addUmiestnenieForm">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="row">
				<div class="col-md-12">
					<label>OH</label>
					<select class="form-control" name="oh">
						<?php while($row = $class->ohs->fetch_assoc()){ ?>
							<option value="<?php echo $row['id'];?>">
								<?php echo $row["type"] . ", " . $row["year"] . ", " . $row["city"] . ", " . $row["country"] ?>
							</option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top: 25px;">
				<div class="col-md-12">
					<label>Disciplína</label>
					<input type="text" name="discipline" class="form-control"/>
				</div>
			</div>
			<div class="row" style="margin-top: 25px;">
				<div class="col-md-12">
					<label>Miesto</label>
					<input type="text" name="place" class="form-control"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-right">
					<input type="submit" id="addUmiestnenieForm-submit" name="addUmiestnenieForm" class="button green" value="Odoslať" style="margin-top: 25px"/>
				</div>
			</div>
		</div>
	</div>
</form>