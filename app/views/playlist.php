<div class="section-wrapper">
	<div class="report-summary-header">
		<div></div>
		<div><a href="<?php echo '/playlist?create='.$sv[0]['portbase']; ?>" class="btn btn-outline-secondary"><i class="icon ion-ios-gear-outline tx-24"></i> New playlist</a></div>
	</div>
	<table class="table mb-0">
		<thead>
			<tr>
				<th>Nume fisier</th>
				<th>Dimensiunea fisierului	</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$dirlisting = @scandir("./temp/".$sv[0]['portbase']."/playlist") or $errors[] = "<h2>Not Font</h2>";
				foreach($dirlisting as $f){
					if (($f!=".") and ($f!="..") and ($f!="")) {
						$thisfilename = substr($f, 0, 55);
						if(strlen($f) > 55 ) $thisfilename = $thisfilename."...";
						echo '<tr>';
						echo '<td>'. $thisfilename .'</td>';
						echo '<td>'. round((filesize("./temp/".$sv[0]['portbase']."/playlist/".$f)/1024), 2) .' KB ( '.round((filesize("./temp/".$sv[0]['portbase']."/playlist/".$f)/1024/1024), 2).' MB )</td>';
						echo '<td><a href="playlist?p='.$sv[0]['portbase'].'&list='.base64_encode($f).'" class="btn btn-success btn-sm btn-block mg-b-10">Edit</a></td>';
						echo '<td><form method="POST" ><button name="delete" class="btn btn-danger btn-sm btn-block mg-b-10" type="submit" value="'.base64_encode($f).'">Delete</button></form></td>';
						echo '</tr>';
					}
				}
			?>
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
						window.location.href = "/playlist?port='.$sv[0]['portbase'].'";
					}, 2000); //will call the function after 2 secs.
				</script>';
		}
	}
?>