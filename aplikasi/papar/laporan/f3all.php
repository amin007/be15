<?php
include 'diatas.php';
	$pegawai = senarai_kakitangan(); // kumpul nama fe
	$sv = isset($this->sv) ? $this->sv : null;
	$namaOrg['penyelia'] = 'Abdul Razak';
	$namaOrg['pegawai'] = $this->fe;
	if (count($this->hasil)==0):
		$fields = null; 
		$rows = null; 
		$hasil = null; 
	else:
		$fields = count($this->hasil[0]); 
		$rows = count($this->hasil); 
		$hasil = $this->hasil;
	endif;
	$allRows = $this->kiraSemuaBaris;
	$item = $this->item;
	$baris = isset($this->baris) ? $this->baris : 30;
	$ms = $this->ms;
	$hasil = $this->hasil;
	$tajukRespon=array();	
	//echo '<pre>$hasilLaporan:'; print_r($this->hasil) . '</pre>';
	//echo '<br>$baris:' . $rows . '|' . count($this->hasil) . '<br>';
	//echo '<br>$lajur:' . $fields . '|' . count($this->hasil[0]) . '<br>';
	
if (count($this->hasil) == 0):
	echo 'Tiada data';
else:
?>
	<table border="1" class="excel" width="100%" height="100%">
	<?php
	paparJadualF3_Data($sv,$namaOrg,$allRows,$rows,$fields,$hasil,$item,$ms,$baris);
	paparJadualF3_TajukBawah($rows,$fields);
	?>
	</table>
<?php
endif;
echo "\n"; ?>
</body>
</html>