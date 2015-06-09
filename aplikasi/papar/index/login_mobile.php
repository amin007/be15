<?php 
$pegawai = senarai_kakitangan();
foreach ($pegawai as $key => $fe): 
$imej = 'http://' . $_SERVER['SERVER_NAME'] . '/private_html/bg/kakitangan/' . $fe . '.jpg';
?>
		<a href="#<?php echo $fe ?>" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" 
		data-icon="check" data-theme="a" data-transition="flip"><?php echo $fe ?></a>
<?php endforeach; ?>
<?php foreach ($pegawai as $key => $fe):  ?>

	<div data-demo-html="true">	
	<div data-role="popup" id="popupMenu" data-theme="a">
	<div data-role="popup" id="<?php echo $fe ?>" data-theme="a" class="ui-corner-all">
		<form>
		<div style="padding:10px 20px;">
			<h3>Please sign in</h3>
			<img src="<?php echo $imej ?>">
			<label for="un" class="ui-hidden-accessible">Nama Anda:</label>
				<input type="text" name="user" id="un" value="<?php echo $fe ?>" placeholder="username" data-theme="a" />
			<label for="pw" class="ui-hidden-accessible">Kata Laluan:</label>
				<input type="password" name="pass" id="pw" value="" placeholder="password" data-theme="a" />
			<button type="submit" data-theme="b" data-icon="check">Sign in</button>
		</div>
		</form>
	</div>
	</div>
	</div><!--/demo-html -->
<?php endforeach; ?>
