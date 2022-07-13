<div class="section-wrapper">
	<form method="POST" >
		<label class="form-control-label">Playlist Name</label>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Eg: playlist name" name="playlist" value="demoplaylist">
		</div>
		<p>Select your song for new playlist!</p>
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
								echo '<tr>
											<td><input type="checkbox" name="check[]" value="'.$f.'" /></td>
											<td><span class="tx-success">'. $f .'</span><td>
										</tr>';
								}
							}
				?>
			</tbody>
		</table>
		<div class="form-layout-footer">
			<center><input name="update" class="btn btn-primary mr-2" type="submit" value="Update" /></center>
		</div>
	</form>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
<script>
	$(document).ready( function () {
		$('#myTable').DataTable();
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
						window.location.href = "/playlist?port='.$sv[0]['portbase'].'";
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