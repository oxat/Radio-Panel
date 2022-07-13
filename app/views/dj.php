<div class="section-wrapper">
	<div class="alert alert-outline alert-info" role="alert">
		<strong>IP:</strong> <?php echo $config[0]['host_add']; ?><br>
		<strong>Port:</strong> <?php echo $info[0]['djport_1']; ?>
	</div>
	<div class="report-summary-header">
		<div></div>
		<div><a href="/dj?create=<?php echo $port; ?>" class="btn btn-outline-secondary"><i class="icon ion-ios-gear-outline tx-24"></i> Create Server</a></div>
	</div>
	<table class="table mb-0">
		<thead>
			<tr>
				<th>#</th>
				<th>Username</th>
				<th>Password</th>
				<th>djpriority</th>
				<th>Port Server</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($dj as $key => $d){?>
				<tr>
					<td><?php echo $key + 1; ?></td>
					<td><?php echo $d['login']; ?></td>
					<td><?php echo $d['password']; ?></td>
					<td>
						<?php if($d['djpriority']){
							echo '<span class="badge badge-success">Priority Yes</span>';
						}else{
							echo '<span class="badge badge-danger">Priority Not</span>';
						} ?>
					</td>
					<td><?php echo $d['server']; ?></td>
					<td><form method="POST"><button name="delete" class="btn btn-danger btn-sm btn-block mg-b-10" type="submit" value="<?php echo base64_encode($d['id']); ?>">Delete</button></form></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php
	if($message){
		if($message['success']){
			echo '<script type="text/javascript">
					swal("", "'.$message['success'].'", "success");
				  </script>
				  <script type="text/javascript">
						setTimeout(function () {
						window.location.href = "/dj?port='.$port.'";
					}, 2000); //will call the function after 2 secs.
				  </script>';
		}
	}
?>