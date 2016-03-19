<div class="row">
	<div class="col-md-12">
		<h1>
			<?php echo $class->container->title ?>
		</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading">Profil</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
										<b>Nick: </b><?php echo $user_info["nick"]?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<b>Email: </b>
										<a href="mailto:<?php echo $user_info['email'] ?>">
											<?php echo $user_info["email"]?>
										</a>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<b>Meno: </b><?php echo $user_info["name"] . " " . $user_info["surname"] ?>
									</div>
								</div>
							</div>
							<div class="col-md-6 text-center">
								<?php if ($user_info["gender"] == "muž"){ ?>
									<img src="<?php echo $class->basePath?>/images/men.png" style="height: 60px;"/>
								<?php }else{?>
									<img src="<?php echo $class->basePath?>/images/women.png" style="height: 60px;"/>
								<?php }?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<thead>
						<tr>
							<th>Čas</th>
							<th>Typ prihlásenia</th>
						</tr>
					</thead>
					<tbody>
				<?php
					$result = $class->user_manager->getLastLogin($user->id);
					if (mysqli_num_rows($result)){
						while ( $row = $result->fetch_assoc()) {
				?>
							<tr>
								<td>
									<?php echo $class->formatTimestamp($row["time"]) ?>
								</td>
								<td>
									<?php echo $row["type"] ?>
								</td>
							</tr>
				<?php
						}
					}
				?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading">Online</div>
					<div class="panel-body">
						<?php
							$online = $class->user_manager->getOnline();
							while ($o = $online->fetch_assoc()){
						?>
							<div class="row">
								<div class="col-md-12">
									<img src="<?php echo $class->basePath; ?>/images/user.png" style="width: 16px; height: 16px; margin-right: 16px" />&nbsp;<?php echo $o["nick"]==$user_info["nick"]?"ja":$o["nick"]?>
								</div>
							</div>	
						<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div style="width: 300px; height:200px; margin: auto" id="pieChart"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
	google.charts.load('current', {'packages':['corechart']});
</script>
<script>
 	$(function(){
 		google.charts.setOnLoadCallback(drawColumn);
 	});
 	function drawColumn() {
 		var data = new google.visualization.DataTable();
		        data.addColumn('string', 'Znamka');
		        data.addColumn('number', 'Percento');
		        
		        var options = {'title':'Spôsoby prihlasovania',
		                       'width':400,
		                       'height':300};

		        data.addRows([
		        	<?php 
						$result = $class->user_manager->getStats();
						while ( $row = $result->fetch_assoc()) {
					?>
						['<?php echo $row["type"]?>', <?php echo $row["pocet"]?>],
					<?php
						}
					?>

		        ]);
		var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
		chart.draw(data, options);
	}
</script>
