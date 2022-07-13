	<hr>
		<h4 class="tx-white mg-b-3"><center>Register New</center></h4>
	<hr>
	<div class="card card-profile">
		<?php if ($message['text']): ?>
			<center>
				<font color="<?php echo $message['status']; ?>"><strong><?php echo $message['text']; ?></strong></font>
			</center>
		<?php endif ; ?>
		<div class="card-body">
			<form method="POST" >
				<label  class="form-control-label">Username</label>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Eg: myregister"  name="user">
				</div>
				<label  class="form-control-label">Password</label>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Eg: ******"  name="pass">
				</div>
				<label  class="form-control-label">Email</label>
				<div class="form-group">
					<input type="email" class="form-control" placeholder="Eg: hello@gmail.com"  name="email">
				</div>
				<label  class="form-control-label">Mobile</label>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Eg: 07000000"  name="mobile">
				</div>
				<label  class="form-control-label">Name Complet</label>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Eg: Name"  name="Name">
				</div>
				<button type="submit" name="register" value="yes" class="btn btn-primary mr-2">Register</button>
			</form>
		</div>
	</div>