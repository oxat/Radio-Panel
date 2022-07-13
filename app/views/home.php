<div class="row row-xs">
	<div class="col-sm-6 col-lg-3">
		<div class="card card-status">
			<div class="media">
				<i class="icon ion-wifi tx-purple"></i>
				<div class="media-body">
					<h1><?php if($tserver){echo $tserver;}else{ echo 'NaN';}?></h1>
					<p>Servere Total</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
		<div class="card card-status">
			<div class="media">
				<i class="icon ion-clock tx-teal"></i>
				<div class="media-body">
					<h1><?php if($tserver){echo $tserver;}else{ echo 'NaN';}?></h1>
					<p>AutoDJ Total</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
		<div class="card card-status">
			<div class="media">
				<i class="icon ion-person-stalker tx-primary"></i>
				<div class="media-body">
					<h1><?php if($rank){ echo 'Admin'; }else{ echo 'Clinet'; }?></h1>
					<p>Rank</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
		<div class="card card-status">
			<div class="media">
				<i class="icon ion-help-circled tx-pink"></i>
				<div class="media-body">
					<h1><?php if($ticket){echo $ticket;}else{ echo 'NaN';}?></h1>
					<p>Ticket</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
foreach($server as $s){
?>
<div class="row row-sm mg-t-20">
	<div class="col-lg-6">
		<div class="card card-table">
			<center><div class="slim-card-title">AutoDJ [ <?php echo $s['port'];?> ]</div></center>
			<table class="table mb-0">
				<thead>
					<tr>
						<th>IP-Adresa</th>
						<th>Port</th>
						<th>Link</th>
						<th>Status</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="<?php echo str_replace('https://', 'http://', $s['streamurl']); ?>:<?php echo $s['port']; ?>" target="_blank"><?php echo str_replace('https://', '', $s['streamurl']); ?></a></td>
						<td><a href="<?php echo str_replace('https://', 'http://', $s['streamurl']); ?>:<?php echo $s['port']; ?>" target="_blank"><?php echo $s['port']; ?></a></td>
						<td><a href="<?php echo str_replace('https://', 'http://', $s['streamurl']); ?>:<?php echo $s['port']; ?>" target="_blank"><?php echo str_replace('https://', '', $s['streamurl']); ?>:<?php echo $s['port']; ?></a></td>
						<td>
							<?php if($s['statusdj']){
								echo '<span class="badge badge-success">Online</span>';
							}else{
								echo '<span class="badge badge-danger">Offline</span>';
							}?>
						</td>
						<td><a href="/autodj?id=<?php echo $s['id']; ?>" class="tx-gray-600 tx-24"><i class="icon ion-android-more-horizontal"></i></a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-lg-6 mg-t-20 mg-lg-t-0">
		<div class="card card-table">
			<center><div class="slim-card-title">Server [ <?php echo $s['port'];?> ]</div></center>
			<table class="table mb-0">
				<thead>
					<tr>
						<th>IP-Adresa</th>
						<th>Stream (https)</th>
						<th>Space</th>
						<th>Status</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="<?php echo str_replace('https://', 'http://', $s['streamurl']); ?>:<?php echo $s['port']; ?>" target="_blank"><?php echo str_replace('https://', '', $s['streamurl']); ?></a></td>
						<td><a href="<?php echo $s['streamurl']; ?>/stream/<?php echo $s['port']; ?>" target="_blank"><?php echo str_replace('https://', '', $s['streamurl']); ?>/stream/<?php echo $s['port']; ?></a></td>
						<?php
							 $bytes = number_format($s['space'] / 1048576, 2) . ' MB';
							 $result = explode('.',$bytes);
								echo '<td>
										<div class="progress mg-b-20">
											<div class="progress-bar wd-'.$result[0].'p" role="progressbar" aria-valuenow="'.$result[0].'" aria-valuemin="0" aria-valuemax="100">'.$result[0].' MB</div>
										</div>
									</td>';
							?>
						<td>
							<?php if($s['status']){
								echo '<span class="badge badge-success">Online</span>';
							}else{
								echo '<span class="badge badge-danger">Offline</span>';
							}
							?>
						</td>
						<td><a href="/Server?id=<?php echo $s['id']; ?>" class="tx-gray-600 tx-24"><i class="icon ion-android-more-horizontal"></i></a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
}
	if($message){
		if($message['success']){
			echo '<script type="text/javascript">
					swal("", "'.$message['success'].'", "success");
				</script>';
		}
		if($message['error']){
			echo '<script type="text/javascript">
					swal("", "'.$message['error'].'", "error");
				</script>';
		}
	}
?>