<?php

class Laporan_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	private function jika($atau,$medan,$fix,$cariApa,$akhir)
	{
		$dimana = null;
		if($atau==null ) $dimana .= null;
		elseif($cariApa==null )
			$dimana .= ($fix=='x!=') ? " $atau`$medan` != '' $akhir\r"
					: " $atau`$medan` is null $akhir\r";
		elseif($fix=='xnull')
			$dimana .= " $atau`$medan` is not null  $akhir\r";
		elseif($fix=='x=')
			$dimana .= " $atau`$medan` = '$cariApa' $akhir\r";
		elseif($fix=='x<=')
			$dimana .= " $atau`$medan` <= '$cariApa' $akhir\r";
		elseif($fix=='x>=')
			$dimana .= " $atau`$medan` >= '$cariApa' $akhir\r";
		elseif($fix=='x!=')
			$dimana .= " $atau`$medan` != '$cariApa' $akhir\r";
		elseif($fix=='like')
			$dimana .= " $atau`$medan` like '$cariApa' $akhir\r";
		elseif($fix=='xlike')
			$dimana .= " $atau`$medan` not like '$cariApa' $akhir\r";	
		elseif($fix=='%like%')
			$dimana .= " $atau`$medan` like '%$cariApa%' $akhir\r";	
		elseif($fix=='x%like%')
			$dimana .= " $atau`$medan` not like '%$cariApa%' $akhir\r";	
		elseif($fix=='like%')
			$dimana .= " $atau`$medan` like '$cariApa%' $akhir\r";	
		elseif($fix=='xlike%')
			$dimana .= " $atau`$medan` not like '$cariApa%' $akhir\r";	
		elseif($fix=='%like')
			$dimana .= " $atau`$medan` like '%$cariApa' $akhir\r";	
		elseif($fix=='x%like')
			$dimana .= " $atau`$medan` not like '%$cariApa' $akhir\r";	
		elseif($fix=='in')
			$dimana .= " $atau`$medan` in $cariApa $akhir\r";				
		elseif($fix=='xin')
			$dimana .= " $atau`$medan` not in $cariApa $akhir\r";				
		elseif($fix=='khas1')
			$dimana .= " $atau`$medan` REGEXP CONCAT('(^| )','',$cariApa) $akhir\r";	
		elseif($fix=='xkhas1')
			$dimana .= " $atau`$medan` NOT REGEXP CONCAT('(^| )','',$cariApa) $akhir\r";	
		elseif($fix=='khas2')
			$dimana .= " $atau`$medan` REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]') $akhir\r";	
		elseif($fix=='xkhas2')
			$dimana .= " $atau`$medan` NOT REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]') $akhir\r";	
		elseif($fix=='z=')
			$dimana .= " $atau$medan = $cariApa $akhir\r";
		elseif($fix=='zlike')
			$dimana .= " $atau$medan like $cariApa $akhir\r";
		elseif($fix=='zxlike')
			$dimana .= " $atau$medan not like $cariApa $akhir\r";
		elseif($fix=='zxnull')
			$dimana .= " $atau$medan IS NOT NULL $akhir\r";
		elseif($fix=='zin')
			$dimana .= " $atau$medan in $cariApa $akhir\r";
		elseif($fix=='zxin')
			$dimana .= " $atau$medan not in $cariApa $akhir\r";	
			
		return $dimana;
	}
	
	private function dimana($carian)
	{
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
		$where = null;
		if($carian==null || $carian=='' || empty($carian)):
			$where .= null;
		else:
			foreach ($carian as $key=>$value)
			{
				   $atau = isset($carian[$key]['atau'])  ? $carian[$key]['atau'] . ' ' : null;
				  $medan = isset($carian[$key]['medan']) ? $carian[$key]['medan']      : null;
				    $fix = isset($carian[$key]['fix'])   ? $carian[$key]['fix']        : null;			
				$cariApa = isset($carian[$key]['apa'])   ? $carian[$key]['apa']        : null;
				  $akhir = isset($carian[$key]['akhir']) ? $carian[$key]['akhir']      : null;
				//echo "\r$key => ($fix) $atau $medan -> '$cariApa' |";
				$where .= $this->jika($atau,$medan,$fix,$cariApa,$akhir);
			}
		endif; //echo "<hr>$where";
	
		return $where;
	
	}

	private function dibawah($carian)
	{
		$susunan = null;
		if($carian==null || empty($carian) ):
			$susunan .= null;
		else:
				$kumpul = isset($carian[0]['kumpul'])? $carian[0]['kumpul'] : null;
				 $order = isset($carian[0]['susun']) ? $carian[0]['susun']  : null;
				  $dari = isset($carian[0]['dari'])  ? $carian[0]['dari']   : null;			
				   $max = isset($carian[0]['max'])   ? $carian[0]['max']    : null;

			   if ($kumpul!=null)$susunan .= "\r GROUP BY $kumpul";
				if ($order!=null) $susunan .= "\r ORDER BY $order";
				if ($max!=null)   $susunan .= ($dari==0) ? 
						"\r LIMIT $max" : "\r LIMIT $dari,$max";
		endif; 
		
		//echo "<pre>\$carian=>".print_r($carian)."</pre>";
		//echo "<hr>\$kumpul:$kumpul \$order:$order \$dari:$dari \$max:$max hahaha<hr>";
		return $susunan;
		
	}
	
	public function kiraMedan($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);

		//echo $sql . '<br>';
		$result = $this->db->columnCount($sql);
		//echo json_encode($result);
		
		return $result;	
	}

	public function kiraBaris($myTable, $medan, $carian, 
		$item = 30, $ms = 1, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);
		
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$bilSemua = $this->db->rowCount($sql);
		//echo json_encode($result);
		
        # tentukan bilangan mukasurat & jumlah rekod
		//echo '$bilSemua:'.$bilSemua.', $item:'.$item.', $ms:'.$ms.'<br>';
        $jum = pencamSqlLimit($bilSemua, $item, $ms);
		//echo '<pre>$jum->', print_r($jum, 1) . '</pre>';
		return $jum;
	}

	public function kiraKes($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);
		
		//echo $sql . '<br>';
		$result = $this->db->rowCount($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function paparSemua($myTable, $medan, $carian, $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);
		
		//echo '<pre>class Laporan::paparSemua() | $sql->', print_r($sql, 1) . '</pre>';
		$result['kiraBaris'] = $this->db->rowCount($sql);
		$result['kiraMedan'] = $this->db->columnCount($sql);
		$result['kiraData'] = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;		
	}

	public function kesSemua($myTable, $medan, $carian,  $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSelesai($myTable, $medan, $carian,  $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);			
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesBelum($myTable, $medan, $carian,  $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);
			
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesTegar($myTable, $medan, $carian,  $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kiraKesUtama($myTable, $medan, $cari)
	{
		$cariUtama = ( !isset($cari['utama']) ) ? 
		'' : ' WHERE b.newss=c.newss and b.utama = "' . $cari['utama'] . '"';
		$cariFe = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';
		$respon = ( !isset($cari['respon']) ) ? null : $cari['respon'] ;
		$AN=array('A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13');
		
		if  ($respon=='a1')
			$cariRespon = " AND c.respon='A1' and b.terima like '20%' \r";
		elseif ($respon=='xa1')
			$cariRespon = " AND b.terima is null \r";
		elseif ($respon=='tegar')
			$cariRespon = " AND(`respon` IN ('" . implode("','",$AN) . "')) \r";
		else $cariRespon = '';

		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable 
			 . ' b, `mdt_rangka13` as c '
			 . $cariUtama . $cariRespon . $cariFe;

		//echo $sql . '<br>';
		$result = $this->db->rowcount($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function kesUtama($myTable, $medan, $cari, $susun)		
	{
		//$jum['dari'] . ', ' . $jum['max']
		$cariUtama = ( !isset($cari['utama']) ) ? 
		'' : ' WHERE b.newss=c.newss and b.utama = "' . $cari['utama'] . '"';
		$respon = ( !isset($cari['respon']) ) ? null : $cari['respon'] ;
		$cariFe = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';
		$AN=array('A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13');
		
		if  ($respon=='a1')
			$cariRespon = " AND c.respon='A1' and b.terima like '20%' \r";
		elseif ($respon=='xa1')
			$cariRespon = " AND b.terima is null \r";
		elseif ($respon=='tegar')
			$cariRespon = " AND(`c.respon` IN ('" . implode("','",$AN) . "')) \r";
		else $cariRespon = '';

		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable 
			 . ' b, `mdt_rangka13` as c '
			 . $cariUtama . $cariRespon . $cariFe
			 . $this->dibawah($susun);

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSemak($myTable, $myJoin, $medan, $susun)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$sql = 'SELECT ' . $medan . ' FROM ' 
		     . $myTable . ' a, '.$myJoin.' b ' 
			 . ' WHERE a.newss=b.newss ' 
			 . $this->dibawah($susun);
			
		$result = $this->db->selectAll($sql);
		//echo '<pre>' . $sql . '</pre><br>';
		//echo json_encode($result);
		
		return $result;
	}

	public function kumpulRespon($medanR, $f2, $r = 'respon', 
		$medan, $myTable, $carian, $susun)
	{
		$sql = 'SELECT ' . $medanR . ' FROM ' . $f2 
			 . ' WHERE kod not in ("X","5P") GROUP BY 1 ORDER BY no';
		//echo '<pre>$sql->' . $sql . '</pre><br>';
		$hasil = $this->db->selectAll($sql);
		
		/*** loop over the object directly ***/
		$kumpul = null;
		foreach($hasil as $key=>$val)
		{
			foreach($val as $key2=>$p)
			{
				//$kumpul .= ",\r '' as '" . $p . "'";
				$kumpul .= ",\r if($r='".$p."','X','&nbsp;') as '" . $p . "'";
				//$jumlah_kumpul.="+count(if($r='".$papar[0]."' and b.terima is not null,$r,null))\r";
			}
		} //echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		
		# sql kedua, khas untuk cetak F3 : senarai kes pegawai kerja luar
		$sql2 = "SELECT $medan$kumpul\r FROM $myTable\r"
			  . $this->dimana($carian)
			  . $this->dibawah($susun);
		
		//echo '<pre>$sql2->' . $sql2 . '</pre><br>';
		//echo '<pre>$sql2->' . htmlentities($sql2) . '</pre><br>';
		$result['kiraData'] = $this->db->selectAll($sql2);
		//echo json_encode($result);
		
		return $result;		
		
	}

	public function laporan_bulanan($myTable, $susun)
	{
		// pembolehubah yg terlibat
		$r = 'respon'; $kumpul = null; 
		$AN=array(11=>'A1',12=>'A2',31=>'A3',40=>'A4',50=>'A5',60=>'A6',
			13=>'A7',14=>'A8',21=>'A9',22=>'A10',23=>'A11',32=>'A12',15=>'A13');
		$RN=array('11','12','13','14','15','21','22','23','31','32','40','50','60');
		$B=array(71=>'B1',71=>'B2',73=>'B3',74=>'B4',75=>'B5',76=>'B6',77=>'B7');
		foreach($RN as $k=>$p)
		{
			//echo " $p -> " . $AN[$p]. " <br>";
			$kumpul .= ",\r format(sum(if($r='".$AN[$p]."',1,null) ),0)  as '&nbsp;$p'";
		}
		$jumlah_kumpul = 843;
		$ALL="format(count(*),0)";
		$A1="count(if($r='A1' and b.terima is not null,$r,null))";
		$B1="count(if($r='B1',$r,null))";
		///////////////////////////////////////////////////////////////////////////////////////////////////
		// a1 bahagi (jumlah rangka - (a2-a6)
		$sasaran=array('A2','A3','A4','A5','A6'); //
		$SSR="count(if($r IN ('".implode("','",$sasaran)."') and b.terima is not null,$r,null))"; // kpi negatif
		$KPI="($A1 / ($ALL - $SSR) )*100";
		///////////////////////////////////////////////////////////////////////////////////////////////////
		$JANJI="count(if($r='B1' or b.terima is null,$r,null))";
		$AN="count(if($r NOT in ('A1','B1'),$r,null))";
		$BBU="count(if(b.utama='BBU',b.utama,null))";
		$BBU1="count(if($r='A1' and b.utama='BBU' and b.terima is not null,$r,null))";
		$BBUX="count(if($r!='A1' and b.utama='BBU' and  b.terima is not null,$r,null))";
		$SBU="count(if(b.utama='SBU',b.utama,null))";
		$SBU1="count(if($r='A1' and b.utama='SBU' and b.terima is not null,$r,null))";
		$SBUX="count(if($r!='A1' and b.utama='SBU' and b.terima is not null,$r,null))";
		$dpt="format(sum(if($r='A1',hasil,null)),0)";
		$p="if (format(((($jumlah_kumpul)/$ALL)*100),2)=100.00,'Ya',':(' )";
		// mula cari sql berasaskan respon ,$ALL-($jumlah_kumpul) as `B1`
		///////////////////////////////////////////////////////////////////////////////////////////////////
		$sql = "SELECT kp, nama_kp, "
			 //. " $p as `Dah`,\r$dpt AS `Hasil`,\r"
			 //. "$JANJI as Janji,"
			 . "$ALL as Kes $kumpul\r"
			 //. "($jumlah_kumpul) as `Siap`,\r"
			 //. "format(((($jumlah_kumpul)/count(*))*100),2) as `% Siap`,\r"
			 //. "format((($A1/count(*))*100),2) as `% A1`,\r"
			 //. "format($KPI,2) as `% KPI`,\r"
			 //. "$AN `A-`, format((($AN/count(*))*100),2) as `% A-`,\r"
			 //. "$BBU as `BBU`,\r$BBU1 as `BOK`,\r$BBUX as `BAN`,\r"
			 //. "($BBU-$BBU1-$BBUX) as `BB`,\r"
			 //. "format((($BBU1/$BBU)*100),2) as `%B`,\r"
			 //. "$SBU as `SBU`,\r$SBU1 as `SOK`,\r$SBUX as `SAN`,\r"
			 //. "($SBU-$SBU1-$SBUX) as `S`,\r"
			 //. "format((($SBU1/$SBU)*100),2) as `%S`\r"
			 . "FROM $myTable as b\r"
			 . "GROUP BY 1 with rollup "; 
		//echo '<pre>' . $sql . '</pre><br>';
		
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		return $result;	
	}

	public function laporan_daerah($myTable, $susun)
	{
		// pembolehubah yg terlibat
		$r = 'respon'; $kumpul = null; 
		$AN=array(11=>'A1',12=>'A2',31=>'A3',40=>'A4',50=>'A5',60=>'A6',
			13=>'A7',14=>'A8',21=>'A9',22=>'A10',23=>'A11',32=>'A12',15=>'A13');
		$RN=array('11','12','13','14','15','21','22','23','31','32','40','50','60');
		$B=array(71=>'B1',71=>'B2',73=>'B3',74=>'B4',75=>'B5',76=>'B6',77=>'B7');
		foreach($RN as $k=>$p)
		{
			//echo " $p -> " . $AN[$p]. " <br>";
			$kumpul .= ",\r format(sum(if($r='".$AN[$p]."',1,null) ),0)  as '&nbsp;$p'";
		}
		$jumlah_kumpul = 843;
		$ALL="format(count(*),0)";
		$A1="count(if($r='A1' and b.terima is not null,$r,null))";
		$B1="count(if($r='B1',$r,null))";
		$dpt="format(sum(if($r='A1',hasil,null)),0)";
		$p="if (format(((($jumlah_kumpul)/$ALL)*100),2)=100.00,'Ya',':(' )";
		///////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////
		$sql = "SELECT kp,bandar, $p as `Dah`,\r$dpt AS `Hasil`,\r"
			 . "$ALL as Kes $kumpul\r"
			 . "FROM $myTable as b\r"
			 . "GROUP BY 1,2 with rollup "; 

		$result = $this->db->selectAll($sql);
		//echo '<pre>' . $sql . '</pre><br>';
		//echo json_encode($result);
		
		return $result;	
	}
	
	public function laporan_fe($myTable, $susun)
	{
		// pembolehubah yg terlibat
		$r = 'respon'; $kumpul = null; 
		$AN=array(11=>'A1',12=>'A2',31=>'A3',40=>'A4',50=>'A5',60=>'A6',
			13=>'A7',14=>'A8',21=>'A9',22=>'A10',23=>'A11',32=>'A12',15=>'A13');
		$RN=array('11','12','13','14','15','21','22','23','31','32','40','50','60');
		$B=array(71=>'B1',71=>'B2',73=>'B3',74=>'B4',75=>'B5',76=>'B6',77=>'B7');
		foreach($RN as $k=>$p)
		{
			//echo " $p -> " . $AN[$p]. " <br>";
			$kumpul .= ",\r format(sum(if($r='".$AN[$p]."',1,null) ),0)  as '&nbsp;$p'";
		}
		$jumlah_kumpul = 843;
		$ALL="format(count(*),0)";
		$A1="count(if($r='A1' and b.terima is not null,$r,null))";
		$B1="count(if($r='B1',$r,null))";
		$dpt="format(sum(if($r='A1',hasil,null)),0)";
		$p="if (format(((($jumlah_kumpul)/$ALL)*100),2)=100.00,'Ya',':(' )";
		///////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////
		$sql = "SELECT fe,borang, $p as `Dah`,\r$dpt AS `Hasil`,\r"
			 . "$ALL as Kes $kumpul\r"
			 . "FROM $myTable as b\r"
			 . "GROUP BY 1,2 with rollup "; 

		$result = $this->db->selectAll($sql);
		//echo '<pre>' . $sql . '</pre><br>';
		//echo json_encode($result);
		
		return $result;	
	}
	
	public function laporan_utama($r, $kumpul, $jumlah_kumpul, $myTable)
	{
		// pembolehubah yg terlibat
		$ALL="count(*)";
		$A1="count(if($r='A1' and b.terima is not null,$r,null))";
		///////////////////////////////////////////////////////////////////////////////////////////////////
		// a1 bahagi (jumlah rangka - (a2-a6)
		$sasaran=array('A2','A3','A4','A5','A6'); //
		$SSR="count(if($r IN ('".implode("','",$sasaran)."') and b.terima is not null,$r,null))"; // kpi negatif
		$KPI="($A1 / ($ALL - $SSR) )*100";
		///////////////////////////////////////////////////////////////////////////////////////////////////
		$AN="count(if($r<>'A1' and b.terima is not null,$r,null))";
		$dpt="format(sum(if($r='A1' and b.terima is not null,b.hasil,null)),0)";
		$p="if (format(((($jumlah_kumpul)/$ALL)*100),2)=100.00,'Ya',':(' )";
		// mula cari sql berasaskan respon
		///////////////////////////////////////////////////////////////////////////////////////////////////
		$sql = "SELECT c.utama U,c.fe, $p as `Selesai`, $dpt AS `Hasil`,\r"
			 . "$ALL as Kes,$ALL-($jumlah_kumpul) as `B1` $kumpul,\r"
			 . "($jumlah_kumpul) as `Siap`,\r"
			 . "format(((($jumlah_kumpul)/count(*))*100),2) as `% Siap`,\r"
			 . "format((($A1/count(*))*100),2) as `% A1`,\r"
			 . "format($KPI,2) as `% KPI`,\r"
			 . "$AN `A-`, format((($AN/count(*))*100),2) as `% A-`\r"
			 . "FROM mdt_rangka13 as c INNER JOIN mdt_$myTable as b\r"
			 . "ON c.newss=b.newss\r"
			 . "GROUP BY c.utama,c.fe with rollup "; 

		$result = $this->db->selectAll($sql);
		//echo '<pre>' . $sql . '</pre><br>';
		//echo json_encode($result);
		
		return $result;	
	}

	public function laporanProsesan($myTable, $medan, $r11, $susun)
	{	
		# pembolehubah yg terlibat // berasaskan kp dan tarikh
		## medan
		$po = "`Pejabat Operasi Baru`";
		## Pejabat Operasi
		$pjb = "$po='PJB'";
		$kiraPjb = "count(if($pjb,'PJB',null))";
		$pok = "$po='POK'";
		$kiraPok = "count(if($pok,'POK',null))";
		$pom = "$po='POM'";
		$kiraPom = "count(if($pom,'POM',null))";
		## rangka
		$rangka = "$kiraPjb `PJB`,\r"
			 . "$kiraPok `POK`,\r"
			 . "$kiraPom `POM`,\r";
		## kod 11 mko
		$mko = "count(if($pjb AND $r11,'PJB11',null)) `PJB11`,\r"
			 . "count(if($pok AND $r11,'POK11',null)) `POK11`,\r"
			 . "count(if($pom AND $r11,'POM11',null)) `POM11`,\r";
		## penerimaan borang
		$terima = "count(if($pjb AND $r11,'PJB1',null)) `tPJB`,\r"
			 . "(format ((count(if($pjb AND $r11,'PJB1',null)) / count(*)) * 100, 2))`t%PJB`,\r"
			 . "count(if($pok AND $r11,'POK1',null)) `tPOK`,\r"
			 . "(format ((count(if($pok AND $r11,'POK1',null)) / count(*)) * 100, 2))`t%POK`,\r"
			 . "count(if($pom AND $r11,'POM1',null)) `tPOM`,\r"
			 . "(format ((count(if($pom AND $r11,'POM1',null)) / count(*)) * 100, 2))`t%POM`,\r";
		## baki borang 
		$baki = "(format ( \r"
			 . "	count(if($pjb,'PJB',null)) -\r"
			 . "	count(if($pjb AND $r11,'xPJB',null)),0)\r"
			 . ")`bPJB`,\r"
			 . "(format ( \r"
			 . "	((count(if($pjb,'PJB',null)) -\r"
			 . "	count(if($pjb AND $r11,'xPJB',null)))\r"
			 . "	/ count(*)) * 100,2)\r"
			 . ")`b%PJB`,\r"
			 . "(format ( \r"
			 . "	count(if($pok,'POK',null)) -\r"
			 . "	count(if($pok AND $r11,'xPOK',null)), 0)\r"
			 . ")`bPOK`,\r"
			 . "(format ( \r"
			 . "	((count(if($pok,'POK',null)) -\r"
			 . "	count(if($pok AND $r11,'xPOK',null)))\r"
			 . "	/ count(*)) * 100,2)\r"
			 . ")`b%POK`,\r"
			 . "(format ( \r"
			 . "	count(if($pom,'POM',null)) -\r"
			 . "	count(if($pom AND $r11,'xPOM',null)), 0)\r"
			 . ")`bPOM`,\r"
			 . "(format ( \r"
			 . "	((count(if($pom,'POM',null)) -\r"
			 . "	count(if($pom AND $r11,'xPOM',null)))\r"
			 . "	/ count(*)) * 100,2)\r"
			 . ")`b%POM`\r";
		## mula cari sql berasaskan respon ///////////////////////////////////////////////////////////////////////////////////////////////
		$sql = 'SELECT ' . $medan . $rangka . $mko . $terima . $baki
			 . 'FROM '. $myTable 
			 //. $this->dimana($carian) 
			 . $this->dibawah($susun)
			 . '';
		$result = $this->db->selectAll($sql);
		echo '<pre>' . $sql . '</pre><br>'; //echo json_encode($result);
		
		return $result;	
	}
	
	public function cariSql($myTable, $medan, $carian, $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);
		
		echo htmlentities($sql) . '<br>';
		//echo '<pre>$sql:'; print_r($sql) . '</pre><br>';
		//echo json_encode($result);		
		
		return $result = null;
	}

	public function cariSemuaData($myTable, $medan, $carian, $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);
		
		return $this->db->selectAll($sql);
		
	}

	public function cariSatuSahaja($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian);	

		return $this->db->select($sql);

	}
	
	public function ubahSimpan($data, $myTable)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';
		$senarai = null;
		$medanID = 'newss';
		
		foreach ($data as $medan => $nilai)
		{
			//$postData[$medan] = $nilai;
			if ($medan == $medanID)
				$cariID = $medan;
			elseif ($medan != $medanID)
				$senarai[] = ($nilai==null) ? " `$medan`=null" : " `$medan`='$nilai'"; 
			if(($medan == 'fe'))
				$fe = ($nilai==null) ? " `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		$where = "`$cariID` = '{$data[$cariID]}' ";
		
		// set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r WHERE $where";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->update($sql);
	}
/*
	public function senarai($)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' WHERE fe = "' . $fe . '"';
		$sql = 'SELECT ' . $medan . ' FROM ' . 
		$sv . $myTable . $carife;
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
//*/
#####################################################################################################################
}
