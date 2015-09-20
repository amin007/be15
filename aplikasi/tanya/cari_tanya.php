<?php

class Cari_Tanya extends Tanya 
{
# mula - class Cari_Tanya extends Tanya
	public function __construct() 
	{
		parent::__construct();
	}
########################################################################################################
	private function cariApa($fix, $atau, $medan, $cariApa)
	{
		$where = null;
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
		elseif($fix=='likeMedan')
			$where .= " $atau$medan like '%$cariApa%'\r";	
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
		elseif($fix=='in')
			$where .= " $atau`$medan` in $cariApa\r";						
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
		
		return $where;
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
				
				//echo "\r$key => ($fix) $atau $medan = '$apa' ";
				$where = $this->cariApa($fix, $atau, $medan, $cariApa);
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
########################################################################################################
	private function dimanaPOST($myTable)
	{
		//echo '<pre>$_POST->'; print_r($_POST) . '</pre>'; 
		// //' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
		$where = null;
		if($_POST==null || empty($_POST) ):
			$where .= null;
		else:
			foreach ($_POST['pilih'] as $key=>$cari)
			{
				$apa = $_POST['cari'][$key];
				$f = isset($_POST['fix'][$key]) ? $_POST['fix'][$key] : null;
				$atau = isset($_POST['atau'][$key]) ? $_POST['atau'][$key] : 'WHERE';
				
				//$sql.="\r$key => $f  | ";

				if ($apa==null) 
					$where .= " $atau `$cari` is null\r";
				elseif ($myTable=='msic2008') 
				{
					if ($cari=='msic') $where .= ($f=='x') ?
					" $atau (`$cari`='$apa' or msic2000='$apa')\r" :
					" $atau (`$cari` like '%$apa%' or msic2000 like '%$apa%')\r";
					else $where .= ($f=='x') ?
					" $atau (`$cari`='$apa' or notakaki='$apa')\r" :
					" $atau (`$cari` like '%$apa%' or notakaki like '%$apa%')\r";
				}
				else 
					$where .= ($f=='x') ? " $atau `$cari`='$apa'\r" : 
					" $atau `$cari` like '%$apa%'\r";						
			}
		endif;

		return $where;
	} // private function dimanaPOST()

	public function paparMedan($myTable)
	{
		return $this->db->selectAll('SHOW COLUMNS FROM ' . $myTable);
	}
	
	public function kiraMedan($myTable, $medan = '*', $carian = null)
	{	
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable
			 . $this->dimana($carian);
		
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$result = $this->db->columnCount($sql);
		return $result;
	}

	public function kiraKes($myTable, $medan = '*', $carian = null)
	{	
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable
			 . $this->dimana($carian);
		
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$result = $this->db->rowCount($sql);
		return $result;
	}
	
	public function cariSql($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun)
			 . '';
		
		echo htmlentities($sql) . '<br>';
	
	}

	public function cariSemuaData($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun)
			 . '';
		
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function cariPOST($myTable, $medan)
	{
		$sql = 'SELECT ' . $medan . "\r" . ' FROM ' . $myTable . "\r"
			 . $this->dimanaPOST($myTable);
		
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		//echo json_encode($result);
		return $this->db->selectAll($sql);
	}
	
	public function ubahSimpan($medanID, $data, $myTable)
	{
		//echo '<pre>$data->', print_r($data, 1) . '</pre>';
		$cariID = null;
		$senarai = null;
		foreach ($data as $medan => $nilai)
		{//$postData[$medan] = $nilai;
			if ( in_array($medan,$medanID) )
				$cariID[] = " `$medan` = '{$data[$medan]}'";
			else//if ($medan != $medanID)
				$senarai[] = ($nilai==null) ? 
				" `$medan`=null" : " `$medan`='$nilai'"; 
		}

		# semak data medanID & $cariID
		//echo '<pre>$medanID->', print_r($medanID, 1) . '</pre>';
		//echo '<pre>$cariID->', print_r($cariID, 1) . '</pre>';
		
		# cantumkan array 
		$senaraiData = implode(",\r",$senarai);
		$where = implode("\r AND",$cariID);
		
		# set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r WHERE $where";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->update($sql);
	}
	
	public function tambahSimpanBanyak($myTable, $namaMedan, $posmen)
	{
		$sql2 = null;
		# mula bentuk sql dari array
		foreach ($posmen as $kunci => $nilai):
			foreach ($nilai as $medan => $data):
				$sql2 .= ($data == null) ? "null," : "'$data',";
			endforeach;
			$senarai[] = '(' . substr($sql2, 0, -1) . ")";
		endforeach;
		# cantumkan array
		$senaraiData = implode(",\r",$senarai);
		## $sql = "INSERT INTO $table (`$namaMedan`) VALUES ($fieldValues),($fieldValues),");
		# set sql
		$sql = 'INSERT INTO ' . $myTable 
			. ' (' . $namaMedan  . ') VALUES ' 
			. "\r" . $senaraiData;

		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->insert($sql);
	}
# tamat - class Cari_Tanya extends Tanya
}