<div class="section-wrapper">
	<table class="table mb-0">
		<thead>
			<tr>
				<th>IP-Adresa</th>
				<th>Port</th>
				<th>ADRESA Completa</th>
				<th>Start</th>
				<th>Restart</th>
				<th>Stop</th>
				<th>Status</th>
				<th>Music</th>
				<th>DJ</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
		<?php Foreach($servers AS $s){ ?>
			<tr>
				<td><a href="<?php echo $s['streamurl']; ?>:<?php echo $s['port']; ?>" target="_blank"><?php echo str_replace('https://', '', $s['streamurl']); ?></a></td>
				<td><a href="<?php echo $s['streamurl']; ?>:<?php echo $s['port']; ?>" target="_blank"><?php echo $s['port']; ?></a></td>
				<td><a href="<?php echo $s['streamurl']; ?>:<?php echo $s['port']; ?>" target="_blank"><?php echo str_replace('https://', '', $s['streamurl']); ?>:<?php echo $s['port']; ?></a></td>
				<form method="POST" >
					<td><button name="start" class="btn btn-success btn-icon" type="submit" data-oceanid="1" data-action="start" value="<?php echo $s['port']; ?>"><div><i class="fa fa-play"></i></div></button></td>
					<td><button name="restart" class="btn btn-warning btn-icon" data-oceanid="1" data-action="restart" value="<?php echo $s['port']; ?>"> <div><i class="fa fa-refresh fa-spin"></i></div> </button></td>
					<td><button name="stop" class="btn btn-danger btn-icon" data-oceanid="1" data-action="stop" value="<?php echo $s['port']; ?>"> <div><i class="fa fa-stop"></i></div> </button></td>
				</form>
				<td>
					<?php if($s['status']){
						echo '<span class="badge badge-success">Online</span>';
					}else{
						echo '<span class="badge badge-danger">Offline</span>';
					}
					?>
				</td>
				<td><a href="/music" class="btn btn-info btn-icon rounded-circle"><div><i class="icon ion-upload"></i></div></a></td>
				<td><a href="/dj?port=<?php echo $s['port']; ?>" class="btn btn-dark btn-icon rounded-circle"><div><i class="fa fa-music"></i></div></a></td>
				<td><a href="/autodj?id=<?php echo $s['id']; ?>" class="tx-gray-600 tx-24"><i class="icon ion-android-more-horizontal"></i></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
<?php
echo "<div class=\"pagination-wrapper\">
              <nav aria-label=\"Page navigation\">
                <ul class=\"pagination mg-b-0\">";
    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"" . ($pagina == 1 ? "#" : ("/autodj?p=" . ($pagina - 1))) . "\" aria-label=\"Next\"><i class=\"fa fa-angle-left\"></i></a></li>";
		For($i = $inicio; $i <= $fim; $i++)
	echo ($i == $pagina ? "<li class=\"page-item active\"><a class=\"page-link\" href=\"/autodj?p={$i}\">{$i}</a></li>" : "<li class=\"page-item\"><a class=\"page-link\" href=\"/autodj?p={$i}\">{$i}</a></li>");
	echo "<li class=\"page-item\"><a class=\"page-link\" href=\"" . ($pagina == $paginas ? "#" : ("/autodj?p=" . ($pagina + 1))) . "\" aria-label=\"Next\"><i class=\"fa fa-angle-right\"></i></a></li>";
	echo "</ul>
        </nav>
    </div>";

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