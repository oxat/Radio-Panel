	<hr>
		<h4 class="tx-white mg-b-3"><center>Create New DJ to [<?php echo $port; ?>]</center></h4>
	<hr>
	<div class="card card-profile">
		<div class="card-body">
			<form method="POST" >
				<label  class="form-control-label">DJ user</label>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Eg: myregister"  name="user">
				</div>
				<label  class="form-control-label">DJ Password</label>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Eg: ******"  name="pass">
				</div>
				<label  class="form-control-label">Priority</label>
				<div class="form-group">
					<select class="form-control select2 select2-hidden-accessible" name="priority" tabindex="-1" aria-hidden="true">
					   <option value="0">No Priority</option>
					   <option value="1">Yes Priority</option>
					</select>
				</div>
				<button type="submit" name="news" value="yes" class="btn btn-primary mr-2">Create</button>
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
						window.location.href = "/dj?port='.$port.'";
					}, 2000); //will call the function after 2 secs.
				  </script>';
		}
	}
?>