<div class="section-wrapper">
	<table class="table mb-0">
		<thead>
			<tr>
				<th>Setari</th>
				<th>Maxim</th>
				<th>Actual</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Spatiu web</td>
				<td><?php echo round(($sv[0]['webspace']/1024), 2)." MB";?></td>
				<td><?php echo number_format($space / 1048576, 2) . ' MB';?></td>
				<?php
				 $bytes = number_format($space / 1048576, 2) . ' MB';
				 $result = explode('.',$bytes);
				echo '<td>
						<div class="progress mg-b-20">
							<div class="progress-bar wd-'.$result[0].'p" role="progressbar" aria-valuenow="'.$result[0].'" aria-valuemin="0" aria-valuemax="100">'.$result[0].' MB</div>
						</div>
					</td>';
				?>
			</tr>
			<tr>
				<td>Tip fisier permis</td>
				<td>MP3</td>
			</tr>
			<tr>
				<td>Shoutcast Port</td>
				<td><?php echo $sv[0]['portbase']?></td>
			</tr>
		</tbody>
	</table>
	<br>
	<form method="post" enctype="multipart/form-data">
		<div class="col-lg-3 mg-t-40 mg-lg-t-0">
			<div class="custom-file">
				<input type="file" class="custom-file-input" name="doc[]" multiple>
				<label class="custom-file-label custom-file-label-primary">Upload files mp3</label>
			</div>
		</div>
		<br>
		<center><input name="mp3" class="btn btn-primary mr-2" type="submit" value="Submit" /></center>
	</form>
</div>
<br>
<div class="section-wrapper">
	<table class="table mb-0" id="myTable">
		<thead>
			<tr>
				<th>Nume fisier</th>
				<th>Dimensiunea fisierului	</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$dirlisting = @scandir("./uploads/".$sv[0]['portbase']) or $errors[] = "<h2>Not Font</h2>";
				foreach($dirlisting as $f){
					if (($f!=".") and ($f!="..") and ($f!="")) {
						$thisfilename = substr($f, 0, 55);
						if(strlen($f) > 55 ) $thisfilename = $thisfilename."...";
						echo '<tr>';
						echo '<td>'. $thisfilename .'</td>';
						echo '<td>'. round((filesize("./uploads/".$sv[0]['portbase']."/".$f)/1024), 2) .' KB ( '.round((filesize("./uploads/".$sv[0]['portbase']."/".$f)/1024/1024), 2).' MB )</td>';
						echo '<td><form method="POST" ><button name="delete" class="btn btn-danger btn-sm btn-block mg-b-10" type="submit" value="'.base64_encode($f).'">Delete</button></form></td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	</table>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
<script>
	$(document).ready( function () {
		$('#myTable').DataTable();
	} );
</script>
<?php
	if($message){
		if($message['success']){
			echo '<script type="text/javascript">
					swal("", "'.$message['success'].'", "success");
				</script>
				<script type="text/javascript">
					setTimeout(function () {
						window.location.href = "/upload?port='.$sv[0]['portbase'].'";
					}, 4000); //will call the function after 4 secs.
				</script>';
		}
	}
?>