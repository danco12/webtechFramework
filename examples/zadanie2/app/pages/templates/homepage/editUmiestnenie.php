<?php
	$class = new Homepage($container);
	$class->startup();
?>
<form action="<?php echo $class->basePath ?>/homepage/editUmiestnenie/<?php echo $class->id?>" method="post" id="editUmiestnenieForm">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
					<label>Osoba</label>
					<select class="form-control" name="person">
						<?php while($row = $class->persons->fetch_assoc()){ ?>
							<option value="<?php echo $row['id'];?>" <?php if($row['id'] == $class->umiestnenie["person"]){ ?>selected <?php } ?> > 
								<?php echo $row["name"] . ", " . $row["surname"] ?>
							</option>
						<?php }?>
					</select>
				</div>
				<div class="col-md-6">
					<label>OH</label>
					<select class="form-control" name="oh">
						<?php while($row = $class->ohs->fetch_assoc()){ ?>
							<option value="<?php echo $row['id'];?>" <?php if($row['id'] == $class->umiestnenie["oh"]){ ?>selected <?php } ?>>
								<?php echo $row["type"] . ", " . $row["year"] . ", " . $row["city"] . ", " . $row["country"] ?>
							</option>
						<?php }?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="margin-top: 25px;">
			<div class="row">
				<div class="col-md-6">
					<label>Disciplína</label>
					<input type="text" name="discipline" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->umiestnenie['discipline']?>" />
				</div>
				<div class="col-md-6">
					<label>Miesto</label>
					<input type="text" name="place" class="form-control" style="margin-bottom: 20px" value="<?php echo $class->umiestnenie['place']?>" />
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-right">
			<input type="submit" id="editUmiestnenieForm-submit" name="editUmiestnenieForm" class="button green" value="Odoslať" style="margin-top: 25px"/>
		</div>
	</div>
</form>