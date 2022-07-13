<div class="card card-profile">
	<form method="POST">
		<div class="section-wrapper">
			<div class="form-layout">
				<div class="row mg-b-25">
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">User: <span class="tx-danger">*</span></label> 
							<input class="form-control" type="text" name="own" value="<?php echo $own; ?>" placeholder="own" readonly="readonly">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Subject: <span class="tx-danger">*</span></label> 
							<input class="form-control" type="text" name="sub" value="" placeholder="Subject ...">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Help Topic: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="topic" tabindex="-1" aria-hidden="true">
								<option value="1" selected="selected">Raport Error</option>
								<option value="2">Raport Bug</option>
								<option value="3">Raport Problem</option>
								<option value="4">Payment</option>
								<option value="5">Update Radio</option>
							</select>
						</div>
					</div>
				</div>
				<br>
				<div class="col-lg-4">
					<div class="form-group">
						<label class="form-control-label">Messages: <span class="tx-danger">*</span></label>  
							<textarea class="form-control" rows="3" name="msg" placeholder="What's on your mind?"></textarea>
					</div>
				</div>
				<div class="form-layout-footer">
					<center><input name="send" class="btn btn-primary mr-2" type="submit" value="Send"></center>
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
						window.location.href = "/ticket";
					}, 2000); //will call the function after 2 secs.
				  </script>';
		}
	}
?>