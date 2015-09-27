<?php

class Kawalan_Tanya extends Tanya 
{
	public function __construct() 
	{
		parent::__construct();
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
	}

	private function dimana($carian)
	{
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
		$where = null;
		if($carian==null || $carian=='' || empty($carian) ):
			$where .= null;
		else:
			foreach ($carian as $key=>$value)
			{
				   $atau = isset($carian[$key]['atau'])  ? $carian[$key]['atau'] . ' ' : null;
				  $medan = isset($carian[$key]['medan']) ? $carian[$key]['medan']      : null;
				    $fix = isset($carian[$key]['fix'])   ? $carian[$key]['fix']        : null;			
				$cariApa = isset($carian[$key]['apa'])   ? $carian[$key]['apa']        : null;
				//echo "\r$key => ($fix) $atau $medan = '$apa'  ";
				
				if ($cariApa==null) 
					$where .= " $atau`$medan` is null\r";
				elseif($fix=='xnull')
					$where .= " $atau`$medan` is not null \r";
				elseif($fix=='x=')
					$where .= " $atau`$medan` = '$cariApa'\r";
				elseif($fix=='x!=')
					$where .= " $atau`$medan` != '$cariApa'\r";
				elseif($fix=='like')
					$where .= " $atau`$medan` like '%$cariApa%'\r";	
				elseif($fix=='xlike')
					$where .= " $atau`$medan` not like '%$cariApa%'\r";	
				elseif($fix=='like%')
					$where .= " $atau`$medan` like '$cariApa%'\r";	
				elseif($fix=='xlike%')
					$where .= " $atau`$medan` not like '$cariApa%'\r";	
				elseif($fix=='%like')
					$where .= " $atau`$medan` like '%$cariApa'\r";	
				elseif($fix=='x%like')
					$where .= " $atau`$medan` not like '%$cariApa'\r";	
				elseif($fix=='xin')
					$where .= " $atau`$medan` not in $cariApa\r";						
				elseif($fix=='khas')
					$where .= " $atau`$medan` not like $cariApa\r";	
				elseif($fix=='khas2')
					$where .= " $atau`$medan` REGEXP CONCAT('(^| )','',$cariApa)\r";	
				elseif($fix=='xkhas2')
					$where .= " $atau`$medan` NOT REGEXP CONCAT('(^| )','',$cariApa)\r";	
				elseif($fix=='khas3')
					$where .= " $atau`$medan` REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]')\r";	
				elseif($fix=='xkhas3')
					$where .= " $atau`$medan` NOT REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]')\r";	
			}
		endif;
	
		return $where;
	
	}
	
	private function dibawah($carian)
	{
		$susun = null;
		if($carian==null || empty($carian) ):
			$susun .= null;
		else:
			foreach ($carian as $key=>$cari)
			{
				$kumpul = isset($carian['kumpul'])? $carian['kumpul'] : null;
				 $order = isset($carian['susun']) ? $carian['susun']  : null;
				  $dari = isset($carian['dari'])  ? $carian['dari']   : null;
				   $max = isset($carian['max'])   ? $carian['max']    : null;
				
				//echo "\$cari = $cari, \$key=$key <br>";
				if ($kumpul!=null)  $susun = " GROUP BY concat('%',$kumpul,'%')\r";
				elseif($order!=null)$susun = " ORDER BY $order\r";
				elseif($dari!=null) $susun = " LIMIT $dari";	
				elseif($max!=null)  $susun .= ",$max\r";
			}
		endif;
		
		return $susun;
	
	}
	
	public function kiraMedan($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);

		//echo htmlentities($sql) . '<br>';
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
        $jum = pencamSqlLimit($bilSemua, $item, $ms, $susun);
		//echo '<pre>$jum->', print_r($jum, 1) . '</pre>';
		return $jum;
	}

	public function kiraKes($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);
		
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->rowCount($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function paparSemua($myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : 
			(	($myTable=='rangka13') ?
				' WHERE fe = "' . $fe . '"'
				: 	' and c.fe = "' . $fe . '"'
			);
		$jadual = ($myTable=='rangka13') ? $sv . $myTable
			: $sv . $myTable
				. ' b, `mm_rangka13` as c WHERE b.newss = c.newss';

		$sql = 'SELECT ' . $medan . ' FROM ' . $jadual . $carife;
		
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSemua($myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : 
			(	($myTable=='rangka13') ?
				' WHERE fe = "' . $fe . '"'
				: 	' and c.fe = "' . $fe . '"'
			);

		$jadual = ($myTable=='rangka13') ? $sv . $myTable
			: $sv . $myTable
				. ' b, `mm_rangka13` as c WHERE b.newss = c.newss';

		$sql = 'SELECT ' . $medan . ' FROM ' . $jadual 
			. $carife
			. ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSelesai($myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';
		$jadual = //($myTable=='rangka13') ? $sv . $myTable :
			$sv . $myTable . ' b, `mm_rangka13` as c WHERE b.newss = c.newss';

		$sql = 'SELECT ' . $medan . ' FROM ' . $jadual
			 . ' and terima is not null ' . $carife 
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function kesJanji($myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . $sv . $myTable 
		     . ' b, `' . $sv .'rangka13` as c WHERE b.newss = c.newss '
			 . ' and (b.terima is null and c.respon != "A1") ' 
			 . $carife
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesBelum($myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . $sv . $myTable 
		     . ' b, `mm_rangka13` as c WHERE b.newss = c.newss '
			 . ' and (b.terima is null or b.terima like "0000%") ' 
			 . $carife
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesTegar($myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . $sv . $myTable 
		     . ' b, `mm_rangka13` as c WHERE b.newss = c.newss'
			 . ' and (`c.respon` not like "A1" '
			 . ' and `c.respon` not like "B%") ' . $carife .
			' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo htmlentities($sql) . '<br>';
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
			 . ' b, `mm_rangka13` as c '
			 . $cariUtama . $cariRespon . $cariFe;

		//echo htmlentities($sql) . '<br>';
		$result = $this->db->rowcount($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function kesUtama($myTable, $medan, $cari, $jum)
	{
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
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSemak($myTable, $myJoin, $medan, $jum)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . 
			$myTable . ' a, '.$myJoin.' b ' .
			' WHERE a.newss=b.newss ' . 
			' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];
			
		$result = $this->db->selectAll($sql);
		//echo '<pre>' . $sql . '</pre><br>';
		//echo json_encode($result);
		
		return $result;
	}
	
	public function cariAlamat($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . "\r" . $this->dibawah($susun)
			 . '';
		
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function cariSql($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 //. $this->dibawah($susun)
			 . '';
		
		echo htmlentities($sql) . '<br>';
	}

	public function cariSemuaData($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 //. $this->dibawah($susun)
			 . '';
		
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function cariSatuSahaja($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable . $this->dimana($carian);
		
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->select($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function ubahSimpan($data, $myTable, $medanID)
	{
		//echo '<pre>$data->', print_r($data, 1) . '</pre>';
		$senarai = null;
		
		foreach ($data as $medan => $nilai)
		{
			//$postData[$medan] = $nilai;
			if ($medan == $medanID)
				$cariID = $medan;
			elseif ($medan != $medanID)
				$senarai[] = ($nilai==null) ? " `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		$where = "`$cariID` = '{$data[$cariID]}' ";
		
		# set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r WHERE $where";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->update($sql);
	}
	/*
	public function buangTerus($data, $myTable)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';
		$cariID = 'newss';
				
		// set sql
		//$sql = " DELETE `$myTable` WHERE `$cariID` = '{$data[$cariID]}' ";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->delete($myTable, "`$cariID` = '{$data[$cariID]}' ");
			
	}

	public function senarai($)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' WHERE fe = "' . $fe . '"';
		$sql = 'SELECT ' . $medan . ' FROM ' . 
		$sv . $myTable . $carife;
		
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
*/
#####################################################################################
}