<div class="card card-profile">
	<form method="POST" >
		<div class="section-wrapper">
			<div class="form-layout">
				<div class="row mg-b-25">
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Server IP: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="ip" value="<?php echo $config[0]['host_add']; ?>" disabled="disabled">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Server Port: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="port" value="<?php echo $sv[0]['portbase']; ?>" disabled="disabled">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Parola Server: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="pass" value="<?php echo $sv[0]['password']; ?>" disabled="disabled">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Bitrate: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="bitrate" value="<?php echo $sv[0]['bitrate']; ?>" disabled="disabled">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Server public: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="public" tabindex="-1" aria-hidden="true">
								<option value="0" <?php if($sv[0]['public'] == 0){echo 'selected="selected"';} ?>>Flux de afisare privat</option>
								<option value="1" <?php if($sv[0]['public'] == 1){echo 'selected="selected"';} ?>>Flux de afisare public</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Titlu Radio: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="streamtitle" value="<?php echo $sv[0]['streamtitle']; ?>" placeholder="Enter Title Radio">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">Flux URL: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="streamurl" value="<?php echo $sv[0]['streamurl']; ?>" placeholder="Enter flux URL">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Flux Gen: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="genre" tabindex="-1" aria-hidden="true">
							<?php 
								foreach($gen as $g){
									echo '<option value="'.$g.'"';
									if($sv[0]['genre'] == $g){
										echo ' selected="selected"';
									}
									echo '>'.$g.'</option>';
								}
							?>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Mod de redare: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="shuffle" tabindex="-1" aria-hidden="true">
								<option value="0" <?php if($sv[0]['shuffle'] == 0){echo 'selected="selected"';} ?>>Redare aleatorie oprit</option>
								<option value="1" <?php if($sv[0]['shuffle'] == 1){echo 'selected="selected"';} ?>>Redare aleatorie pornit</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Afisare Melodie: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="displaymetadatapattern" tabindex="-1" aria-hidden="true">
								<option value="%u" <?php if($sv[0]['displaymetadatapattern'] == '%u'){echo 'selected="selected"';} ?>>Off (Stream url)</option>
								<option value="%R" <?php if($sv[0]['displaymetadatapattern'] == '%R'){echo 'selected="selected"';} ?>>Artist</option>
								<option value="%N" <?php if($sv[0]['displaymetadatapattern'] == '%N'){echo 'selected="selected"';} ?>>Titlu</option>
								<option value="%R [-] %N" <?php if($sv[0]['displaymetadatapattern'] == '%R [-] %N'){echo 'selected="selected"';} ?>>Artist - Titlu</option>
								<option value="%R [-] %N [-] %Y" <?php if($sv[0]['displaymetadatapattern'] == '%R [-] %N [-] %Y'){echo 'selected="selected"';} ?>>Artist - Titlu - Gen</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Bitrate: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="samplerate" tabindex="-1" aria-hidden="true">
							<?php 
								foreach($bitrate as $b){
									echo '<option value="'.$b.'"';
									if($sv[0]['samplerate'] == $b){
										echo ' selected="selected"';
									}
									echo '>'.$b.' Hz</option>';
								}
							?>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Canal: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="channels" tabindex="-1" aria-hidden="true">
								<option value="1" <?php if($sv[0]['channels'] == 1){echo 'selected="selected"';} ?>>Mono</option>
								<option value="2" <?php if($sv[0]['channels'] == 2){echo 'selected="selected"';} ?>>Stereo</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Audio Format: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="encoder" tabindex="-1" aria-hidden="true">
								<option value="mp3" <?php if($sv[0]['encoder'] == 'mp3'){echo 'selected="selected"';} ?>>MP3</option>
								<option value="aacp" <?php if($sv[0]['encoder'] == 'aacp'){echo 'selected="selected"';} ?>>AAC+Plus</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">MP3 Quality: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="mp3quality" tabindex="-1" aria-hidden="true">
								<option value="1" <?php if($sv[0]['mp3quality'] == 1){echo 'selected="selected"';} ?>>Repede (preferat)</option>
								<option value="0" <?php if($sv[0]['mp3quality'] == 0){echo 'selected="selected"';} ?>>High Quality</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Mp3 Mode: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="mp3mode" tabindex="-1" aria-hidden="true">
								<option value="0" <?php if($sv[0]['mp3mode'] == 0){echo 'selected="selected"';} ?>>CBR</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Xfade: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="xfade" tabindex="-1" aria-hidden="true">
							<?php 
								foreach($fade as $f){
									echo '<option value="'.$f.'"';
									if($sv[0]['xfade'] == $f){
										echo ' selected="selected"';
									}
									if($f == 2){
										echo '>Nu xFade</option>';
									}else{
										$ff = $f - 2;
										echo '>'.$ff.' Secunde</option>';
									}
								}
							?>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Xfadethreshol: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="xfadethreshol" tabindex="-1" aria-hidden="true">
							<?php 
								foreach($xfadet as $fx){
									echo '<option value="'.$fx.'"';
									if($sv[0]['xfadethreshol'] == $fx){
										echo ' selected="selected"';
									}
									echo '>min. '.$fx.' Secunde</option>';
								}
							?>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">AIM: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="aim" value="<?php echo $sv[0]['aim']; ?>" placeholder="AIM server data">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">ICQ: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="icq" value="<?php echo $sv[0]['icq']; ?>" placeholder="ICQ server data">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">IRC: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="irc" value="<?php echo $sv[0]['irc']; ?>" placeholder="IRC server data">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Calendarrewrite: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="calendarrewrite" tabindex="-1" aria-hidden="true">
								<option value="0" <?php if($sv[0]['calendarrewrite'] == '0'){echo 'selected="selected"';} ?>>OFF</option>
								<option value="1" <?php if($sv[0]['calendarrewrite'] == '1'){echo 'selected="selected"';} ?>>ON</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Stream Recording: <span class="tx-danger">*</span></label>
							<select class="form-control select2 select2-hidden-accessible" name="djcapture" tabindex="-1" aria-hidden="true">
								<option value="0" <?php if($sv[0]['djcapture'] == '0'){echo 'selected="selected"';} ?>>OFF</option>
								<option value="1" <?php if($sv[0]['djcapture'] == '1'){echo 'selected="selected"';} ?>>ON</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">DJ IP / URL: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="idps" value="<?php echo $config[0]['host_add']; ?>" placeholder="Ip dj" readonly="readonly">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label class="form-control-label">DJ-Port: <span class="tx-danger">*</span></label>
							<input class="form-control" type="text" name="djport_1" value="<?php echo $sv[0]['djport_1']; ?>" placeholder="Port dj" readonly="readonly">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group mg-b-10-force">
							<label class="form-control-label">Playlist: <span class="tx-danger">*</span></label>
							<?php
								echo '<td>';
								$dirlisting = @scandir("./temp/".$sv[0]['portbase']."/playlist/");
								echo '<select class="form-control select2 select2-hidden-accessible" name="playlists"';
								if (count((array)$dirlisting) == 1){
									echo ' disabled';
								}
								echo '>';
								foreach($dirlisting as $f){
									if (($f!=".") and ($f!="..") and ($f!="")) {
										$thisfilename = substr($f, 0, 55);
										if(strlen($f) > 55 ){
											$thisfilename = $thisfilename."...";
										}
										echo "<option class=\"playlistselectdrop\" value=\"" . $f . "\">" . $thisfilename . "</option>";
									}
								}
								if($dirlisting == NULL){
									echo "<option class=\"playlistselectdrop\" value=\"\">Not Fond!</option>";
								}
								echo '</select>';
								echo '</td>';
							?>
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
						window.location.href = "/autodj?id='.$sv[0]['id'].'";
					}, 2000); //will call the function after 2 secs.
				  </script>';
		}
	}
?>