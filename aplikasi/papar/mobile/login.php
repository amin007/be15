<?php 
echo "<br>Alamat IP : <font color='red'>" . $this->ip . "</font> |" .
//"<br>Alamat IP2 : <font color='red'>" . $this->ip2 . "</font> |" .
"\r Nama PC : <font color='red'>" . $this->hostname . "</font> |" .
//"\r<br>Server : <font color='red'>" . $this->server . "</font>" .
"\r";

//$senaraiIP=array('192.168.1.', '10.69.112.', '127.0.0.1', '10.72.112.');
if ( in_array($this->ip2,$this->senaraiIP) )
{
	//$pegawai = senarai_kakitangan();
	$pegawai = array('shima','khairani','noraini','adam',
	'khairi','musa','amin','ariff',/*'azim','fendi',*/'irwan',
	'norita','mustaffa','shukor'/*,'suhaida'*/);;

	foreach ($pegawai as $key => $fe): 
		$fail = 'http://' . $_SERVER['SERVER_NAME'] . '/private_html/bg/kakitangan/' . $fe . '.jpg';
		$file_headers = @get_headers($fail);
		$imej = (($file_headers[0] == 'HTTP/1.1 404 Not Found')) ? $fe:'<img src="'.$fail.'">'; ?>
		<a href="#<?php echo $fe ?>" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" 
		data-icon="user" data-theme="a" data-transition="flip"><?php echo $imej ?></a><?php 
	endforeach; 
	$kakitangan = senarai_kakitangan();
	$fe = $key = null;
	foreach ($kakitangan as $key => $fe):  
		$fail = 'http://' . $_SERVER['SERVER_NAME'] . '/private_html/bg/kakitangan/' . $fe . '.jpg';
		$file_headers = @get_headers($fail);
		$imej = (($file_headers[0] == 'HTTP/1.1 404 Not Found')) ? 
			'<a class="ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext ui-btn-inline">Delete</a>'
			:'<img src="'.$fail.'">';
?>
	<div data-demo-html="true">	
	<div data-role="popup" id="popupMenu" data-theme="a">
	<div data-role="popup" id="<?php echo $fe ?>" data-theme="a" class="ui-corner-all">
		<form data-ajax="false" method="POST" action="login/semakid">
		<div style="padding:10px 20px;">
<?php if ( $fe=='amin' ): $nama='amin007'?>
			<?php echo $imej ?>
				<input type="hidden" name="username" value="<?php echo $nama ?>" placeholder="Nama Anda" data-theme="a" />
				<input type="password" name="password" id="pw" placeholder="Kata Laluan" data-theme="a" />
<?php else: ?>
			<?php echo $imej 
			. '';
			?><br>anda ada kebenaran masuk sistem
				<input type="hidden" name="username" value="<?php echo $fe ?>" />
				<input type="hidden" name="password" value="<?php echo $fe ?>" />
<?php endif; ?>
			<input type="submit" name="masuk" value="Masuk" data-theme="b" data-icon="check">
			<!-- <button type="submit" data-theme="b" data-icon="check">Sign in</button> -->
		</div>
		</form>
	</div>
	</div>
	</div><!--/data-demo-html -->
<?php 
	endforeach; 
}
else
{	
	echo 'ip anda ' . $ip . ', anda tiada kebenaran masuk sistem';
}

?>