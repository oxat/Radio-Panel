<div class="section-wrapper">
	<table class="table mb-0">
		<thead>
			<tr>
				<th>IP-Adresa</th>
				<th>Port</th>
				<th>Spatiu web</th>
				<th>Trafic</th>
				<th>Incarcare</th>
				<th>Playlist</th>
			</tr>
		</thead>
		<tbody>
		<?php Foreach($list AS $l){ ?>
			<tr>
				<td><a href="<?php echo $l['streamurl']; ?>:<?php echo $l['port']; ?>" target="_blank"><?php echo str_replace('http://', '', $l['streamurl']); ?></a></td>
				<td><a href="<?php echo $l['streamurl']; ?>:<?php echo $l['port']; ?>" target="_blank"><?php echo $l['port']; ?></a></td>
				<?php
				 $bytes = number_format($l['space'] / 1048576, 2) . ' MB';
				 $result = explode('.',$bytes);
				echo '<td>
						<div class="progress mg-b-20">
							<div class="progress-bar wd-'.$result[0].'p" role="progressbar" aria-valuenow="'.$result[0].'" aria-valuemin="0" aria-valuemax="100">'.$result[0].' MB</div>
						</div>
					</td>';
				?>
				<td>
					<div class="progress mg-b-20">
						<div class="progress-bar progress-bar-striped wd-25p" role="progressbar" data-progress-percent="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</td>
				<td><a href="/upload?port=<?php echo $l['port']; ?>" class="btn btn-success btn-sm btn-block mg-b-10">Incarcare</a></td>
				<td><a href="/playlist?port=<?php echo $l['port']; ?>" class="btn btn-warning btn-sm btn-block mg-b-10">Playlist</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>