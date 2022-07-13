<div class="card card-profile">
	<form method="POST" >
		<div class="section-wrapper">
			<div class="form-layout">
				<div class="row mg-b-25">
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Title Site: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="title" value="<?php echo $conf[0]['title']; ?>" placeholder="Title Site">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Host Addres: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="host_add" value="<?php echo $conf[0]['host_add']; ?>" placeholder="Host Addres">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Os Panel: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="os" value="<?php echo $conf[0]['os']; ?>" placeholder="os" disabled="disabled">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Director: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="dir" value="<?php echo $conf[0]['dir_to_cpanel']; ?>" placeholder="Director Panel">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">SSH nume utilizator: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="ssh_user" value="<?php echo $conf[0]['ssh_user']; ?>">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">SSH nume parola: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="ssh_pass" value="<?php echo $conf[0]['ssh_pass']; ?>">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">SSH port: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="ssh_port" value="<?php echo $conf[0]['ssh_port']; ?>">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Server public: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="shellset" tabindex="-1" aria-hidden="true">
								<option value="shellexec" <?php if($conf[0]['shellset'] == 'shellexec'){echo 'selected="selected"';} ?>>shellexec</option>
								<option value="ssh2" <?php if($conf[0]['shellset'] == 'ssh2'){echo 'selected="selected"';} ?>>ssh2</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Timp de executie: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="php_exe" value="<?php echo $conf[0]['php_exe']; ?>" placeholder="Timp de executie">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Limita de listare: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="display_limit" value="<?php echo $conf[0]['display_limit']; ?>" placeholder="Limita de listare">
						</div>
					</div>
				</div>
				<div class="form-layout-footer">
					<center><input name="update" class="btn btn-primary mr-2" type="submit" value="Update" /></center>
				</div>
			</div>
		</div>
	</form>
</div>
<?php
	if($message){
		if($message['success']){
			echo '<script type="text/javascript">
					swal("", "'.$message['success'].'", "success");
				  </script>
				  <script type="text/javascript">
						setTimeout(function () {
						window.location.href = "/Settings";
					}, 2000); //will call the function after 2 secs.
				  </script>';
		}
	}
?>