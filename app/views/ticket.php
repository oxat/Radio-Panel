<div class="section-wrapper">
	<div class="report-summary-header">
		<div></div>
		<div>
			<a href="/ticket?create=<?php echo $own; ?>" class="btn btn-outline-secondary"><i class="icon ion-ios-gear-outline tx-24"></i> Create Server</a>
		</div>
	</div>
	<table class="table mb-0">
		<thead>
			<tr>
				<th>#</th>
				<th>Subject</th>
				<th>Topic</th>
				<th>Status</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($ticket as $t){?>
				<tr>
					<td><?php echo $t['id']; ?></td>
					<td><?php echo $t['subiect']; ?></td>
					<td>
						<?php if($t['departament'] == 1){
							echo 'Raport Error';
						}elseif($t['departament'] == 2){
							echo 'Raport Bug';
						}elseif($t['departament'] == 3){
							echo 'Raport Problem';
						}elseif($t['departament'] == 4){
							echo 'Payment';
						}elseif($t['departament'] == 5){
							echo 'Update Radio';
						}else{
							echo 'Nulll';
						}
						?>
					</td>
					<td>
						<?php if($t['status']){
							echo '<span class="badge badge-success">Open</span>';
						}else{
							echo '<span class="badge badge-danger">Close</span>';
						} ?>
					</td>
					<td><a href="/ticket?id=<?php echo $t['id']; ?>" class="tx-gray-600 tx-24"><i class="icon ion-android-more-horizontal"></i></a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>