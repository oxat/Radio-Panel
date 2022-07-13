<div class="card card-profile">
	<form method="POST" >
		<div class="section-wrapper">
			<div class="form-layout">
				<div class="row mg-b-25">
					<div class="col-lg-4">
						<label  class="form-control-label">Client server</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['owner']?>"  name="user" readonly="readonly">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Maximum de ascultatori</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['maxuser']?>"  name="maxuser" readonly="readonly">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Server Port</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['portbase']?>"  name="portbase" readonly="readonly">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Streambitrate</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['bitrate']?>"  name="bitrate" readonly="readonly">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Parola</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['password']?>"  name="password">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Parola admin</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['adminpassword']?>"  name="passadm">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Arata ultimele cantece</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['showlastsongs']?>"  name="showlastsongs">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Name Lookups</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['namelookups']?>"  name="namelookups">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Relay Port</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['relayport']?>"  name="relayport">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Relay Server</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['relayserver']?>"  name="relayserver">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Introfile</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['introfile']?>"  name="introfile">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Titleformat</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['titleformat']?>"  name="titleformat">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Adresa stream Url</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['urlformat']?>"  name="urlformat">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Allow Relay</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['allowrelay']?>"  name="allowrelay">
						</div>
					</div>
					<div class="col-lg-4">
						<label  class="form-control-label">Allow Public Relay</label>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $sv[0]['allowpublicrelay']?>"  name="allowpublicrelay">
						</div>
					</div>
				</div>
				<div class="form-layout-footer">
					 <center><input name="update" class="btn btn-primary mr-2" type="submit" value="Submit" /></center>
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
								window.location.href = "/Server?id='.$sv[0]['id'].'";
							}, 2000); //will call the function after 2 secs.
						</script>';
			}
		}
	?>