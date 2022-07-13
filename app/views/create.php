<div class="card card-profile">
	<form method="POST" >
		<div class="section-wrapper">
			<div class="form-layout">
				<div class="row mg-b-25">
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Client server: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="owner" tabindex="-1" aria-hidden="true">
								<?php 
									foreach($users as $u){
										echo '<option value="'.$u['user'].'">'.$u['user'].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Password Admin: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="adminpassword" value="<?php echo rand(0000000,9999999); ?>" placeholder="Admin Password">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Broadcast Password: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="password" value="<?php echo rand(0000000,9999999); ?>" placeholder="Broadcast Password">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">DJ-Port: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="djport_1" value="<?php echo $newportdj; ?>" placeholder="Enter port dj">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Port server: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="portbase" value="<?php echo $nextport; ?>" placeholder="Enter Port">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">W3CLog: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="w3clog" readonly="readonly" value="sc_<?php echo $nextport; ?>.log">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Fisier jurnal: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="logfile" readonly="readonly" value="sc_<?php echo $nextport; ?>.log">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Banfile: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="banfile" value="" disabled="disabled">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Ripfile: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="ripfile" value="" disabled="disabled">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Max ascultatori: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="maxuser" value="32" placeholder="Enter max ascultatori">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Flux bitrate: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="bitrate" tabindex="-1" aria-hidden="true">
								<option value="320000">320 kbps</option>
								<option value="256000">256 kbps</option>
								<option value="192000">192 kbps</option>
								<option value="160000">160 kbps</option>
								<option value="128000">128 kbps</option>
								<option value="96000">96 kbps</option>
								<option value="64000">64 kbps</option>
								<option value="56000">56 kbps</option>
								<option value="48000">48 kbps</option>
								<option value="40000">40 kbps</option>
								<option value="32000">32 kbps</option>
								<option value="24000">24 kbps</option>
								<option value="16000">16 kbps</option>
								<option value="8000">8 kbps</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Panou public: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="sitepublic" tabindex="-1" aria-hidden="true">
								<option value="1">Server Panel public</option>
								<option value="0">Server Panel privat</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">AutoDJ: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="autopid" tabindex="-1" aria-hidden="true">
								<option selected="selected" value="">Pornit</option>
								<option value="9999999">Oprit</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Spatiu Web (MB): <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="webspace" value="20" placeholder="Enter max space">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Timp real: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="realtime" tabindex="-1" aria-hidden="true">
								<option value="1">Stream info Pornit</option>
								<option value="0">Stream info Oprit</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Jurnal info: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="screenlog" tabindex="-1" aria-hidden="true">
								<option value="0">Stream info Oprit</option>
								<option value="1">Stream info Pornit</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Last Song: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="showlastsongs" value="10" placeholder="last song">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">YP Tracks: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="tchlog" tabindex="-1" aria-hidden="true">
								<option value="no">YP Tracks ignora</option>
								<option value="yes">YP Tracks record in Log</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Weblog: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="weblog" tabindex="-1" aria-hidden="true">
								<option value="no">Activitate Web neautentificata</option>
								<option value="yes">Activitate Web autentificata</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">W3CEnable: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="w3cenable" tabindex="-1" aria-hidden="true">
								<option value="no">W3C Log out</option>
								<option value="yes">W3C Log in</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Sursa IP: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="srcip" value="ANY">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Destinatie IP: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="destip" value="ANY">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">YPort: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="yport" value="80" placeholder="YPort ptr. conect. la yp.shoutcast.com">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">DNS: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="namelookups" tabindex="-1" aria-hidden="true">
								<option value="0">DNS off</option>
								<option value="1">DNS on</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Port releu: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="relayport" value="0" placeholder="Port releu SHOUTcast">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Server releu: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="relayserver" value="" placeholder="Adresa IP catre releu">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">AutoDumpUser: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="autodumpusers" value="0" placeholder="Nr. de ascultatori catre Log off">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">AutoDumpUserTime: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="autodumpsourcetime" value="30" placeholder="Nr. de sec. kick ptr. ascultatori">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">ContentDir: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="contentdir" value="" placeholder="Locatia continutului director">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Fisier adaugat: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="introfile" value="" placeholder="Amplasare fisier adaugat">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Format nume: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="titleformat" value="Radio Station Name - %s" placeholder="Nume Server SHOUTcast">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Adresa stream Url: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="urlformat" value="" placeholder="ex. https://ip:port/listen.pls">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Server public: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="namelookups" tabindex="-1" aria-hidden="true">
								<option value="0">DNS off</option>
								<option value="1">DNS on</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Server public: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="publicserver" tabindex="-1" aria-hidden="true">
								<option value="default">default</option>
								<option value="always">always</option>
								<option value="never">never</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Permite releu: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="allowrelay" tabindex="-1" aria-hidden="true">
								<option value="1">Releu Pornit</option>
								<option value="0">Releu Oprit</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Permite releu: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="allowpublicrelay" tabindex="-1" aria-hidden="true">
								<option value="1">Server privat</option>
								<option value="0">Server public</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Metainterval: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="metainterval" tabindex="-1" aria-hidden="true">
								<option value="8192">8192</option>
								<option value="32768">32768</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-layout-footer">
					 <center><input name="create" class="btn btn-primary mr-2" type="submit" value="Create" /></center>
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
						window.location.href = "/AllServers";
					}, 2000); //will call the function after 2 secs.
				  </script>';
		}
	}
?>