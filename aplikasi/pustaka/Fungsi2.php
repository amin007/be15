<?php
/*
 * ini adalah fungsi yang belum lengkap lagi.
 */
function s11($keterangan, $kunci, $nilaiKunci, $row)
{
		$s11 = tatasusunanJenis();
		if ($kunci=='F1659'):
		?><tr><td align="right" colspan="2">Jum Kuantiti / Nilai <table><tr>
		<td colspan="1">Jenis</td>
		<td colspan="1">Aup</td>
		<td colspan="2">Dulu</td>
		<td colspan="2">Anggar</td></tr><?php
		foreach($s11 as $key2 => $medan2):
			//foreach($medan2 as $key3 => $medan):
			?><tr>
			<td align="right"><?php echo $s11[$key2]['jenis'] ?></td>
			<td align="right"><?php echo $s11[$key2]['aup'] ?></td>
			<td align="right"><?php echo 'F15' . $key2 ?></td>
			<td align="right"><?php echo 'F16' . $key2 ?></td>
			<td align="right"><?php echo 'F15' . $key2 ?></td>
			<td align="right"><?php echo 'F16' . $key2 ?></td>
			</tr><?php	
	
		//endforeach;
		endforeach;
		?></table></td></tr><?php
		endif;
}
function tatasusunanJenis()
{
				/*echo " array('keterangan'=> '" . $p2[$k2]['jenis'] . "',
				'aup'=> '" . $p2[$k2]['aup'] . "',
				'key'=>'F16$k2','nilai'=>$nilaiKunci) <br>";*/

		$p = array(41,42,43,44,45,46,47,48,49,50,59);
		
		foreach($p as $k2):
			if($k2==41): $data[$k2] = array('keterangan'=> 'Air','aup'=> 2.6,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==42): $data[$k2] = array('keterangan'=> 'Pelincir','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==43): $data[$k2] = array('keterangan'=> 'Minyak diesel','aup'=> 1.8,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==44): $data[$k2] = array('keterangan'=> 'Petrol','aup'=> 1.9,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==45): $data[$k2] = array('keterangan'=> 'Minyak relau/Minyak pembakar','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==46): $data[$k2] = array('keterangan'=> 'Gas petroleum cecair (LPG)','aup'=> 1200,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==47): $data[$k2] = array('keterangan'=> 'Gas asli/Gas asli untuk kenderaan (NGV)','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==48): $data[$k2] = array('keterangan'=> 'Bahan pembakar lain','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==49): $data[$k2] = array('keterangan'=> 'Tenaga elektrik yang dibeli','aup'=> 0.43,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==50): $data[$k2] = array('keterangan'=> 'Tenaga elektrik yang dijana','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==59): $data[$k2] = array('keterangan'=> 'Jum Kuantiti / nilai','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			endif;
		endforeach;*/
	
		//echo '<pre>data='; print_r($data, 1) . '</pre>'; 

		return $data;
}
