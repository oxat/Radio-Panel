	<hr>
		<h4 class="tx-white mg-b-3"><center>Edit User : <?php echo $user[0]['user']?></center></h4>
	<hr>
	<div class="card card-profile">
		<div class="card-body">
			<form method="POST" >
				<label  class="form-control-label">Username</label>
				<div class="form-group">
					<input type="text" class="form-control"  value="<?php echo $user[0]['user']?>"  name="user" readonly="readonly">
				</div>
				<label  class="form-control-label">Email</label>
				<div class="form-group">
					<input type="text" class="form-control"  value="<?php echo $user[0]['email']?>"  name="email">
				</div>
				<label  class="form-control-label">Mobile</label>
				<div class="form-group">
					<input type="text" class="form-control"  value="<?php echo $user[0]['mobile']?>"  name="mobile">
				</div>
				<label  class="form-control-label">Name Complet</label>
				<div class="form-group">
					<input type="text" class="form-control"  value="<?php echo $user[0]['Name']?>"  name="name">
				</div>
				<label  class="form-control-label">Panel Rank Radio</label>
				<div class="form-group">
					<select class="form-control" name="rank">
						<?php
						$rank = array(0 => 'Client', 1 => 'Administrator');
						foreach($rank as $v => $n){
							$t = $user[0]['rank'] == 0 ? 0 : 1;
							$rnk = $v == $t ? 'selected' : '';
							echo "<option {$rnk} value=\"{$v}\">{$n}</option>";
						}
						?>
					</select>
				</div>
				<input name="update" class="btn btn-primary mr-2" type="submit" value="Submit" />
				<button class="btn btn-light">Cancel</button>
			</form>
		</div>
	</div>
	<?php
		if($message){
			if($message['success']){
				echo '<script type="text/javascript">
							swal("", "'.$message['success'].'", "success");
						</script>
						<script type="text/javascript">
							setTimeout(function () {
								window.location.href = "/Users?id='.$user[0]['id'].'";
							}, 2000); //will call the function after 2 secs.
						</script>';
			}
		}
	?>