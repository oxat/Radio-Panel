<div class="table-responsive">
	<table class="table mg-b-0 tx-12">
		<thead>
			<tr class="tx-10">
				<th class="wd-10p pd-y-5">ID #</th>
				<th class="pd-y-5">Username</th>
				<th class="pd-y-5">Name Complet</th>
				<th class="pd-y-5">Email</th>
				<th class="pd-y-5">Mobile</th>
				<th class="pd-y-5">Status</th>
				<th class="pd-y-5">Delete</th>
				<th class="pd-y-5">Edit</th>
			</tr>
		</thead>
	<tbody>
	<?php
		Foreach($users AS $u){
				if($u['rank']){
					$status = '<span class="badge badge-success">Administrator</span>';
				}else{
					$status = '<span class="badge badge-danger">Client</span>';
				}
				echo "<tr>
							  <td class=\"pd-l-20\">
								{$u['id']}
							  </td>
							  <td>
								{$u['user']}
							  </td>
							  <td>{$u['Name']}</td>
							  <td class=\"tx-12\">
							  <span class=\"tx-11 d-block\"><span class=\"square-8 bg-danger mg-r-5 rounded-circle\"></span> {$u['email']}</span>
							  </td>
							  <td>{$u['mobile']}</td>
							  <td>{$status}</td>";
				echo '<td><form method="POST" ><button name="delete" class="btn btn-danger btn-sm btn-block mg-b-10" type="submit" value="'.base64_encode($u['id']).'">Delete</button></form></td>';
				echo "<td><a href=\"/Users?id={$u['id']}\" class=\"tx-gray-600 tx-24\"><i class=\"icon ion-android-more-horizontal\"></i></a></td>
					</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "<div class=\"pagination-wrapper\">
					  <nav aria-label=\"Page navigation\">
						<ul class=\"pagination mg-b-0\">";
			echo "<li class=\"page-item\"><a class=\"page-link\" href=\"" . ($pagina == 1 ? "#" : ("/Users?p=" . ($pagina - 1))) . "\" aria-label=\"Next\"><i class=\"fa fa-angle-left\"></i></a></li>";
				For($i = $inicio; $i <= $fim; $i++)
			echo ($i == $pagina ? "<li class=\"page-item active\"><a class=\"page-link\" href=\"/Users?p={$i}\">{$i}</a></li>" : "<li class=\"page-item\"><a class=\"page-link\" href=\"/Users?p={$i}\">{$i}</a></li>");
			echo "<li class=\"page-item\"><a class=\"page-link\" href=\"" . ($pagina == $paginas ? "#" : ("/Users?p=" . ($pagina + 1))) . "\" aria-label=\"Next\"><i class=\"fa fa-angle-right\"></i></a></li>";
			echo "</ul>
				</nav>
			</div>";
			
			if($message){
				if($message['success']){
					echo '<script type="text/javascript">
							swal("", "'.$message['success'].'", "success");
						  </script>
						  <script type="text/javascript">
								setTimeout(function () {
								window.location.href = "/users";
							}, 2000); //will call the function after 2 secs.
						  </script>';
				}
			}
	?>
</div>