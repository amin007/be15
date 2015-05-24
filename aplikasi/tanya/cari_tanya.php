<?php

class Cari_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	private function dimana($carian)
	{
		//echo '<pre>$carian->'; print_r($carian) . '</pre>'; 
		/*' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
					 $atau = isset($carian[$key]['atau'])  ? $carian[$key]['atau'] . ' ' : null;
				$cariMedan = isset($carian[$key]['medan']) ? $carian[$key]['medan']      : null;
				      $fix = isset($carian[$key]['fix'])   ? $carian[$key]['fix']        : null;			
				  $cariApa = isset($carian[$key]['apa'])   ? $carian[$key]['apa']        : null;
		//*/
		$where = null;
		if($carian==null || empty($carian) ):
			$where .= null;
		else:
			foreach ($carian as $key=>$cari)
			{
				//echo '<pre>$cari->'; print_r($cari) . '</pre>'; 			
				    $atau = isset($cari['atau'])  ? $cari['atau'] . ' ' : null;
				$medanApa = isset($cari['medan']) ? $cari['medan']      : null;
				     $fix = isset($cari['fix'])   ? $cari['fix']        : null;			
				 $cariApa = isset($cari['apa'])   ? $cari['apa']        : null;
				//echo "\r$key => $cari ($fix) $atau $cariMedan = '$cariApa' <br>";
				
				if ($cariApa==null) 
					$where .= " $atau$medanApa is null\r";
				else 
					$where .= ($fix=='=') ? " $atau$medanApa='$cariApa'\r" : 
						" $atau$medanApa like '%$cariApa%'\r";	
			}
		endif;
		
		return $where;
	}

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
/* ulang cari2 hingga n...			
		$sql.=($c2==null)?'':($f2==1?"\r$a2 $m2 $p2='$c2' $t2"
							:"\r$a2 $m2 $p2 like '%$c2%' $t2");
*/		
		return $where;
	} // private function dimanaPOST()

	public function paparMedan($myTable)
	{
		return //$result =
		$this->db->selectAll('SHOW COLUMNS FROM ' . $myTable);
	}
	
	public function kiraMedan($myTable, $medan = '*', $carian = null)
	{	
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable
			 . $this->dimana($carian);
		
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$result = $this->db->columnCount($sql);
		//echo '<br>Bil hasil = ' . $result . '<br>';
		//echo json_encode($result);	
		return $result;
	}

	public function kiraKes($myTable, $medan = '*', $carian = null)
	{	
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable
			 . $this->dimana($carian);
		
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$result = $this->db->rowCount($sql);
		//echo '<br>Bil hasil = ' . $result . '<br>';
		//echo json_encode($result);	
		return $result;
	}
	
	public function cariBanyakLimit($myTable, $medan, $susun, $jum)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable
			 . ' ' . $susun
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];
		
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function cariBanyak($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable
			 . $this->dimana($carian);
		
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
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
	
}