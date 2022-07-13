<div class="row">
	<div class="col-lg-6 mg-t-20 mg-sm-t-30 mg-lg-t-0">
		<div class="section-wrapper">
			<form method="POST" >
				<center><h4>Songs in the update file</h4></center>
				<table class="table mb-0" id="myTable">
					<thead>
						<tr>
							<th><input type="checkbox" onclick="toggle(this);" /></th>
							<th>Name Music</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$dirlisting = @scandir("./uploads/".$sv[0]['portbase']) or $errors[] = "<h2>Not Font</h2>";
							foreach($dirlisting as $f){
								if (($f!=".") and ($f!="..") and ($f!="")) {
									if(in_array($f, $contents)) {
										echo '<tr>
													<td>#</td>
													<td><span class="tx-danger">'. $f .'</span><td>
												</tr>';
									}else {
										echo '<tr>
												<td><input type="checkbox" name="up[]" value="'.$f.'" /></td>
												<td><span class="tx-success">'. $f .'</span><td>
										</tr>';
									}
								}
							}
						?>
					</tbody>
				</table>
				<div class="form-layout-footer">
					<center><input name="edit" class="btn btn-primary mr-2" type="submit" value="Update" /></center>
				</div>
			</form>
		</div>
	</div>
	<div class="col-lg-6 mg-t-20 mg-sm-t-30 mg-lg-t-0">
		<div class="section-wrapper">
			<center><h4>Existing songs in the playlist</h4></center>
			<form method="POST" >
				<table class="table mb-0" id="uptab">
					<thead>
						<tr>
							<th>Name Music</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($contents as $item) {
								echo '<tr>
											<td><span class="tx-info">'. $item .'</span><td>
											<td><form method="POST" ><button name="delete" class="btn btn-danger btn-sm btn-block mg-b-10" type="submit" value="'.base64_encode($item).'">Delete</button></form></td>
									  </tr>';

							}
						?>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
<script>
	$(document).ready( function () {
		$('#myTable').DataTable();
	} );
	$(document).ready( function () {
		$('#uptab').DataTable();
	} );
	function toggle(source) {
		var checkboxes = document.querySelectorAll('input[type="checkbox"]');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source)
				checkboxes[i].checked = source.checked;
		}
	}
</script>
<?php
	if($message){
		if($message['success']){
			echo '<script type="text/javascript">
					swal("", "'.$message['success'].'", "success");
				</script>
				<script type="text/javascript">
					setTimeout(function () {
						window.location.href = "playlist?p='.$sv[0]['portbase'].'&list='.$playlist.'";
					}, 2000); //will call the function after 2 secs.
				</script>';
		}
		if($message['error']){
			echo '<script type="text/javascript">
					swal("", "'.$message['error'].'", "error");
				</script>';
		}
	}
?>