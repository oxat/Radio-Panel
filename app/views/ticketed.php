<div class="card card-invoice">
	<div class="card-body">
		<div class="invoice-header">
			<h1 class="invoice-title">Ticket [<?php echo $t[0]['id'];?>]</h1>
			<div class="billed-from">
				<h6><?php echo $t[0]['subiect'];?></h6>
			</div>
		</div>
		<br>
		<?php foreach($msg as $m){
				echo '<div class="media media-author">
							<div class="media-body">
							<h6><a href="">[ '.$m['user'].' ]</a></h6>
							<p>'.$m['msg'].'</p>
						</div><!-- media-body -->
						<span>';
						echo date("H:i:s d-m-Y",$m['data']);
						echo '</span>
					</div>
					<hr class="mg-b-60">';
				}
			?>
			<form method="POST">
				<div class="form-group">
					<label class="form-control-label">Messages: <span class="tx-danger">*</span></label>  
						<textarea class="form-control" rows="3" name="msg" placeholder="What's on your mind?"></textarea>
				</div>
				<center>
					<input name="send" class="btn btn-primary mr-2" type="submit" value="Send">
					<?php if($rank == 1){
						echo '<input name="close" class="btn btn-danger mr-2" type="submit" value="Close">';
					}?>
				</center>
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
						window.location.href = "/ticket?id='.$t[0]['id'].'";
					}, 2000); //will call the function after 2 secs.
				  </script>';
		}
	}
?>