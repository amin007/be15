<?php
function paparJadualF10_TajukMedan($kodsv,$KP,$nama_penyelia,$nama_pegawai,$rows,$fields,$hasil,$item,$ms)
{
	$tr = '<tr><td colspan=' . ($fields+1) . '><br>';
	$tr2 = '</td></tr>' . "\r";
	$tr = null; $tr2 = null;
	echo '<tr style="page-break-before:always"><td colspan=' . ($fields+1) . ' valign="top">'
		. '<h2 align="right">Lampiran F : F10 </h2>' 
		. '<h2 align="center">JABATAN PERANGKAAN MALAYSIA NEGERI JOHOR</h2>'
		. '<h2 align="center">PENGHANTARAN BATCH KE KAWALAN : <small>' . date('d-m-Y') . '</small> </h2>'
		. "</td></tr>\r";

	## tajuk besar
	switch ($kodsv):
		case 'MDT': $SV='PENYIASATAN PERDAGANGAN EDARAN BULANAN'; break;
		case 'CDT': $SV='BANCI PERDAGANGAN EDARAN'; break;
		case 'MM':  $SV='PENYIASATAN PEMBUATAN BULANAN'; break;
		case 'QSS': $SV='PENYIASATAN PERKHIDMATAN SUKU TAHUNAN'; break;
		case 'MFG':  $SV='PENYIASATAN PEMBUATAN TAHUNAN'; break;
		case 'SERVIS':  $SV='PENYIASATAN PERKHDIMATAN TAHUNAN'; break;
		case 'SSE':  $SV='PENYIASATAN PEMBUATAN/PERKHDIMATAN TAHUNAN'; break;
		case 'PPPMAS':  $SV='PENYIASATAN PERBELANJAAN UNTUK PELINDUNGAN ALAM SEKITAR'; break;
		default: $SV=null;
	endswitch;

	## tajuk medan - keputusan 
	echo "<tr>\n<th rowspan=2>Bil</th>\n";
	echo '<th rowspan=2>NO SIRI NEWSS</th>' . "\n";
	echo '<th rowspan=2>Nama Syarikat</th>' . "\n";
	echo '<th rowspan=2>Kod Peny.</th>' . "\n";
	echo '<th rowspan=1 colspan=2>RESPON</th>' . "\n";
	echo '<th rowspan=2>Catatan</th>' . "\n";
	echo "</tr>\n<tr>"; 
	//$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	//$space2 = '&nbsp;&nbsp;';
	$space = $space2 = null;
	echo "<th>$space A1 $space</th>\n";
	echo "<th>$space2 NON&nbsp;A1 $space2</th>\n";
	echo '</tr>';
//*/
}
function paparJadualF10_TajukBawah($rows,$fields)
{
	## pecah muka surat
	//$cetak=($bil==$rows)?'style="page-break-after:always">':'>';
	//'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
	$cetak='style="page-break-after:always">';
	## tajuk medan - keputusan 
	echo "<tr>\n<th colspan=\"2\">JUMLAH TERKUMPUL</th>\n"
		. "<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>\n"
		. "</tr>\n<tr><th colspan=\"2\">JUMLAH KESELURUHAN</th>\n"
		. "<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>\n"
		. '</tr>';

	echo '<tr style="page-break-after:always"><td colspan=3>' .
		'Dihantar Oleh Operasi Luar:' .
		'<br><br>Nama Penghantar:' .
		'<br><br>T.Tangan:____________________' .
		'<br><br>Tarikh Hantar:___________________' . '</td>' . "\r" .
		'<td colspan=1>&nbsp;</td><td colspan=3>' .
		'Diterima Oleh Unit Kawalan:' .
		'<br><br>Nama Penerima:' .
		'<br><br>T.Tangan:____________________' .
		'<br><br>Tarikh Terima:___________________' . '</td>' . "\r" .
		'</tr>' . "\r";
}
function paparJadualF10_Data($rows,$fields,$hasil,$kodsv,$KP,$nama_penyelia,$nama_pegawai)
{	
	// nak cari $rows
	if ($rows=='0'): echo "\n";
	else: // mula kalau jumpa
		# PEMBOLEH UBAH
		$highlight="onmouseover=\"this.className='tikusatas';\" onmouseout=\"this.className='tikuslepas1';\"";
		$highlight2=" onmouseover=\"this.className='tikusatas';\" onmouseout=\"this.className='tikuslepas2';\"";
		$bilBaris = 20;
		# nilai dari isi
		//echo "<tbody>\n"; # mula tbody
		foreach ($hasil as $kira => $nilai)
		{	//$mula = ($ms==1) ? $ms : ($ms*$item)-$ms;
			// style="page-break-after:always"
			if ($kira%$bilBaris=='0')
			{
				$ms = ($kira/$bilBaris)+1;
				$item = ceil($rows/$bilBaris);
				if ($kira!=0) paparJadualF10_TajukBawah($rows,$fields);
				paparJadualF10_TajukMedan($kodsv,$KP,$nama_penyelia,$nama_pegawai,$rows,$fields,$hasil,$item,$ms);
				echo "\r<tr><td><a target='_blank' href='" . URL . 'kawalan/ubah/'
				. $nilai['newss']."'>".($kira+1)."</a></td>\n";
			}
			else
			{
				echo "\r<tr><td><a target='_blank' href='"
				. URL . 'kawalan/ubah/'
				. $nilai['newss']."'>".($kira+1)."</a></td>\n";		
			}
			foreach ($nilai as $key => $data)
			{
				echo '<td>' . $data . '</td>';
			}
			echo "</tr>\n";
		}
		## cukupkan 30 rows
			$mula = $rows+1;
			//$bilAwal = ($item-1)*30;  # dpt bil muka surat akhir
			//$bilAkhir = $rows - $bilAwal; # $rows tolak bil tadi
			//$terakhir = 30 - $bilAkhir; # 30 tolak beza tadi
			$akhir = $rows + ( $bilBaris - ($rows - (($item-1)*$bilBaris) ) );
			//$mula = $rows+1;
			for($i = $mula; $i <= ($akhir); $i++)
			{
				echo '<tr><td>' . $i . '</td>';
				/*echo "<td><font color=\"white\">"
					. $rows . '-' .(($item-1)*$bilBaris)." = ".($bilBaris - ($rows - (($item-1)*$bilBaris) )).", "
					. " nombor terakhir > $rows + ".($bilBaris - ($rows - (($item-1)*$bilBaris) ))." => $akhir</td>";//*/
					for($j = 1; $j <= (6); $j++)
					echo '<td>&nbsp;</td>';
				echo '</tr>' . "\n";
			}
		//*/
		
	endif;
	
}
?>
<style type="text/css">
table.excel {
	border-style:ridge;
	border-width:1;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:11px;
}
table.excel thead th, table.excel tbody th {
	background:#CCCCCC;
	border-style:ridge;
	border-width:1;
	text-align: center;
	vertical-align: top;
}
table.excel tbody th { text-align:center; vertical-align: top; }
table.excel tbody td { vertical-align:bottom; }
table.excel tbody td 
{ 
	padding: 0 3px; border: 1px solid #aaaaaa;
	background:#ffffff;
}
</style>
<?php
$pegawai = senarai_kakitangan(); // kumpul nama fe
	$kodsv = $this->kodkp;
	$nama_penyelia = 'Abdul Razak';
	$nama_pegawai = null;
	if (count($this->hasil)==0):
		$fields = null; 
		$rows = null; 
		$hasil = null; 
		$KP = null;
	else:
		$fields = count($this->hasil[0]); 
		$rows = count($this->hasil); 
		$hasil = $this->hasil;
		$KP = $this->hasil[0]['kp'];
	endif;
	//echo '<pre>$hasilLaporan:'; print_r($this->hasil) . '</pre>';
	//echo '<br>$baris:' . $rows . '|' . count($this->hasil) . '<br>';
	//echo '<br>$lajur:' . $fields . '|' . count($this->hasil[0]) . '<br>';
/*
            [newss] => 000000021807
            [nama] => KEDAI RUNCIT TALIB
			[kp] =>
            [respon] => 
            [non a1] => 
            [catatan] => 327-SBU
*/
if (count($this->hasil) == 0):
	echo 'Tiada data';
else:
?>
	<table border="1" class="excel" width="100%" height="100%">
	<?php
	paparJadualF10_Data($rows,$fields,$hasil,$kodsv,$KP,$nama_penyelia,$nama_pegawai);
	$akhir = 0;
	$mula = $rows+1;
	for($i = $mula; $i <= ($akhir); $i++)
	{
		echo '<tr><td>' . $i . '</td>';
			for($j = 1; $j <= (6); $j++)
			echo '<td>&nbsp;</td>';
		echo '<tr>';
	}
	paparJadualF10_TajukBawah($rows,$fields);
	?>
	</table>
<?php
endif;