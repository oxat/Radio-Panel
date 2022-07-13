<div class="section-wrapper">
	<table class="table mb-0">
		<thead>
			<tr>
				<th>ID</th>
				<th>Owner</th>
				<th>IP-Adresa</th>
				<th>Port</th>
				<th>Spatiu web</th>
				<th>Status</th>
				<th>Action</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
		<?php Foreach($servers AS $key => $s){ ?>
			<tr>
				<td><?php echo $key + 1; ?></td>
				<td><?php echo $s['own']; ?></td>
				<td><a href="<?php echo $s['streamurl']; ?>:<?php echo $s['port']; ?>" target="_blank"><?php echo str_replace('https://', '', $s['streamurl']); ?></a></td>
				<td><a href="<?php echo $s['streamurl']; ?>:<?php echo $s['port']; ?>" target="_blank"><?php echo $s['port']; ?></a></td>
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
				<td>
					<form method="POST" >
						<button name="start" class="btn btn-success btn-icon" type="submit" data-oceanid="1" data-action="start" value="<?php echo $s['port']; ?>"><div><i class="fa fa-play"></i></div></button>
						<button name="stop" class="btn btn-danger btn-icon" data-oceanid="1" data-action="stop" value="<?php echo $s['port']; ?>"> <div><i class="fa fa-stop"></i></div> </button>
					</form>
				</td>
				<td><a href="/Server?id=<?php echo $s['id']; ?>" class="tx-gray-600 tx-24"><i class="icon ion-android-more-horizontal"></i></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
<?php
echo "<div class=\"pagination-wrapper\">
              <nav aria-label=\"Page navigation\">
                <ul class=\"pagination mg-b-0\">";
    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"" . ($pagina == 1 ? "#" : ("/Server?p=" . ($pagina - 1))) . "\" aria-label=\"Next\"><i class=\"fa fa-angle-left\"></i></a></li>";
		For($i = $inicio; $i <= $fim; $i++)
	echo ($i == $pagina ? "<li class=\"page-item active\"><a class=\"page-link\" href=\"/Server?p={$i}\">{$i}</a></li>" : "<li class=\"page-item\"><a class=\"page-link\" href=\"/Server?p={$i}\">{$i}</a></li>");
	echo "<li class=\"page-item\"><a class=\"page-link\" href=\"" . ($pagina == $paginas ? "#" : ("/Server?p=" . ($pagina + 1))) . "\" aria-label=\"Next\"><i class=\"fa fa-angle-right\"></i></a></li>";
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