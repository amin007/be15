<?php

class Batch_Tanya extends Tanya 
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
			$dimana .= ($fix=='x!=') ? " $atau`$medan` !='' $akhir\r"
					: " $atau`$medan` is null $akhir\r";
		elseif($fix=='xnull')
			$dimana .= " $atau`$medan` is not null  $akhir\r";
		elseif($fix=='x=')
			$dimana .= " $atau`$medan` = '$cariApa' $akhir\r";
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
		elseif($fix=='khas2')
			$dimana .= " $atau`$medan` REGEXP CONCAT('(^| )','',$cariApa) $akhir\r";	
		elseif($fix=='xkhas2')
			$dimana .= " $atau`$medan` NOT REGEXP CONCAT('(^| )','',$cariApa) $akhir\r";	
		elseif($fix=='khas3')
			$dimana .= " $atau`$medan` REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]') $akhir\r";	
		elseif($fix=='xkhas4')
			$dimana .= " $atau`$medan` NOT REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]') $akhir\r";	
		elseif($fix=='z1')
			$dimana .= " $atau$medan = $cariApa $akhir\r";
		elseif($fix=='z2')
			$dimana .= " $atau$medan like '$cariApa' $akhir\r";
		elseif($fix=='z2x')
			$dimana .= " $atau$medan not like '$cariApa' $akhir\r";
		elseif($fix=='z3x')
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
		endif; 
	
		return $where;
	
	}

	private function dibawah($carian)
	{
		$susunan = null;
		if($carian==null || empty($carian) ):
			$susunan .= null;
		else:
			foreach ($carian as $key=>$cari)
			{
				$kumpul = isset($carian[$key]['kumpul'])? $carian[$key]['kumpul'] : null;
				 $order = isset($carian[$key]['susun']) ? $carian[$key]['susun']  : null;
				  $dari = isset($carian[$key]['dari'])  ? $carian[$key]['dari']   : null;			
				   $max = isset($carian[$key]['max'])   ? $carian[$key]['max']    : null;
				
				//echo "\$cari = $cari, \$key=$key <br>";
			}
				if ($kumpul!=null)$susunan .= " GROUP BY $kumpul\r";
				if ($order!=null) $susunan .= " ORDER BY $order\r";
				if ($max!=null)   $susunan .= ($dari==0) ? 
						" LIMIT $max\r" : " LIMIT $dari,$max\r";
		endif; 
		
		//echo "<hr>\$kumpul:$kumpul \$order:$order \$dari:$dari \$max:$max hahaha<hr>";
		return $susunan;
		
	}

	public function kiraMedan($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);
		
		//echo $sql . '<br>';
		$result = $this->db->columnCount($sql);
		
		return $result;
	}

	public function kiraBaris($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);
		
		//echo $sql . '<br>';
		$result = $this->db->rowCount($sql);
		
		return $result;
	}

	public function paparMedan($myTable)
	{
		//return $this->db->select('SHOW COLUMNS FROM ' . $myTable);
		$sql = 'SHOW COLUMNS FROM ' . $myTable;
		return $this->db->selectAll($sql);
	}
	
	public function kiraKes($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);
		
		//echo $sql . '<br>';
		$result = $this->db->rowCount($sql);
		
		return $result;
	}
	
	public function kesBatchAwal($myTable, $medan, $carian, $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
		     . $this->dimana($carian) . $this->dibawah($susun)
			. '';
		
		//echo $sql . '<br>';
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesBatchProses($myTable, $medan, $carian, $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
		     . $this->dimana($carian) . $this->dibawah($susun)
			 . '';			
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		
		return $result;
	}
	
	public function kumpulRespon($medanR, $f2, $r = 'respon', 
		$medan, $myTable, $carian, $jum)
	// kumpulRespon('kod','f2',$jadual,$carian,$jum);
	{	// sql untuk 
		$kod = 'SELECT ' . $medanR . ' FROM ' . $f2 
			 . ' WHERE kod not in ("X","5P") GROUP BY 1 ORDER BY no';
		$hasil = $this->db->selectAll($kod);
		
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
		
		# sql kedua
		$sql2 = "SELECT $medan$kumpul\r"
			. ' FROM ' . $myTable . $this->dimana($carian)
			. ' ORDER BY '. $jum['susun']
			. ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];
		
		//echo '$carian:'; print_r($carian) . '<br>';
		//echo '<pre>' . $sql2 . '</pre><br>';
		$result['kiraBaris'] = $this->db->rowCount($sql2);
		$result['kiraMedan'] = $this->db->columnCount($sql2);
		$result['kiraData'] = $this->db->selectAll($sql2);
		
		return $result;		
		
	}

	public function cariGroup($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian) . $this->dibawah($susun)
			 . '';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		
		return $result;
	}

	public function cari2jadual($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = 'SELECT ' . $medan 
			 . ' FROM ' . $myTable 
			 . $this->dimana($carian) 
			 . $this->dibawah($susun) . '';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo '<pre>result:' . print_r($result) . '</pre>';
		
		return $result;
	}
	
	public function cariSemuaData($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian) . $this->dibawah($susun)
			 . '';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		
		return $result;
	}

	public function cariSatuSahaja($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable . $this->dimana($carian);
		
		//echo $sql . '<br>';
		$result = $this->db->select($sql);
		
		return $result;
	}
	
	public function ubahSimpan($data, $myTable, $medanID = null)
	{
		//echo '<pre>$data->', print_r($data, 1) . '</pre>';
		$senarai = null;
		
		foreach ($data as $medan => $nilai)
		{
			if ($medan == $medanID)
				$where = " WHERE `$medanID` = '{$data[$medanID]}' ";
			elseif ($medan != $medanID)
				$senarai[] = ($nilai==null) ? 
				" `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		
		# set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r $where";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->update($sql);
	}

	public function ubahSimpanSemua($data, $myTable, $medanID, $dimana)
	{
		//echo '<pre>$data->', print_r($data, 1) . '</pre>';
		//echo '<pre>$dimana->', print_r($dimana, 1) . '</pre>';
		$senarai = null;
		
		foreach ($data as $medan => $nilai)
		{
			if ($medan == $medanID)
				$where = " WHERE `$medanID` = '{$dimana[$medanID]}' ";
			$senarai[] = ($nilai==null) ? 
				" `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		
		# set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r $where";
		echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		//$this->db->update($sql);
		//*/
	}

	/*
	public function buangTerus($data, $myTable)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';
		$cariID = 'newss';
				
		//$sql = " DELETE `$myTable` WHERE `$cariID` = '{$data[$cariID]}' ";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->delete($myTable, "`$cariID` = '{$data[$cariID]}' ");
			
	}

*/

}