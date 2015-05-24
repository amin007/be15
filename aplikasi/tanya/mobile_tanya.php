<?php

class Mobile_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}
// fungsi gunasama
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

		//echo "$kumpul $order $dari $max hahaha<hr>";
		return $susun;
	
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
	
// data lama	
	public function xhrInsert() 
	{
		$text = $_POST['text'];
		
		$this->db->insert('data', array('text' => $text));
		
		$data = array('text' => $text, 'id' => $this->db->lastInsertId());
		echo json_encode($data);
	}
	
	public function xhrGetListings()
	{
		$result = $this->db->select("SELECT * FROM data");
		//echo $result;
		echo json_encode($result);
	}
	
	public function xhrDeleteListing()
	{
		$id = (int) $_POST['id'];
		$this->db->delete('data', "id = '$id'");
	}

}