<?php 
echo "<br>Alamat IP : <font color='red'>" . $this->ip . "</font> |" .
//"<br>Alamat IP2 : <font color='red'>" . $this->ip2 . "</font> |" .
"\r<br>Nama PC : <font color='red'>" . $this->hostname . "</font> |" .
//"\r<br>Server : <font color='red'>" . $this->server . "</font>" .
"<br>\r";

//$senaraiIP=array('192.168.1.', '10.69.112.', '127.0.0.1', '10.72.112.');
if ( in_array($this->ip2,$this->senaraiIP) )
{
	$pegawai = senarai_kakitangan();
	foreach ($pegawai as $key => $fe): 
?>
		<a href="#<?php echo $fe ?>" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" 
		data-icon="check" data-theme="a" data-transition="flip"><?php echo $fe ?></a>
<?php 
	endforeach; 
	$kakitangan = senarai_kakitangan();
	$fe = $key = null;
	foreach ($kakitangan as $key => $fe):  
		$imej = 'http://' . $_SERVER['SERVER_NAME'] . '/private_html/bg/kakitangan/' . $fe . '.jpg';
		$nama = ($fe=='amin') ? 'amin007' : $fe;
		$password = ($fe=='amin') ? null : $fe;
?>
	<div data-demo-html="true">	
	<div data-role="popup" id="popupMenu" data-theme="a">
	<div data-role="popup" id="<?php echo $fe ?>" data-theme="a" class="ui-corner-all">
		<form data-ajax="false" method="POST" action="login/semakid">
		<div style="padding:10px 20px;">
			<img src="<?php echo $imej ?>">
			<label for="un" class="ui-hidden-accessible">Nama Anda:</label>
				<input type="text" name="username" id="un" value="<?php echo $nama ?>" placeholder="Nama Anda" data-theme="a" />
			<label for="pw" class="ui-hidden-accessible">Kata Laluan:</label>
				<input type="password" name="password" id="pw" value="<?php echo $password ?>" placeholder="Kata Laluan" data-theme="a" />
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
