<?php

class Mobile extends Kawal 
{

	function __construct() 
	{
		parent::__construct();
        //Kebenaran::kawalMasuk();
		$this->papar->tajuk = 'SSE 2015';
	}
	
	function index() 
	{//echo 'class Mobile::index() extends Kawal <br>';
		// pergi papar kandungan
		$this->papar->baca('mobile/mobile');
	}
		
	function icon() 
	{
		// pergi papar kandungan
		$this->papar->baca('mobile/iconjqm');
	}

	function cari() 
	{
		// pergi papar kandungan
		$this->papar->baca('mobile/cari');
	}

	function cariNama() 
	{
		// pergi papar kandungan
		$this->papar->baca('mobile/carinama');
	}
// function yang bukan dicapai secara terus dari URL	
	function carian() 
	{
		$cariNama = $this->semakData(bersih($_POST['cariNama']));
		//$paparData = $this->paparData($cariNama);
		$paparData = $this->paparMSIC($cariNama);
		
		$cari1 = (is_numeric($cariNama)) ?
			"newss:{$cariNama}"	: "nama:{$cariNama}";
		
		$carian  = null; //$cari1; 
		$carian .= json_encode($this->papar->kawalan);
		echo $carian;
		
	}

	function semakData($cariNama) 
	{	
		if (is_numeric($cariNama)):
			$carian = str_pad($cariNama, 12, "0", STR_PAD_LEFT);
		else:
			$carian = $cariNama;
		endif;
	
		return $carian;
		
	}
	
	function paparMSIC($cariID)
	{
		$jadual = dpt_senarai('msicbaru');
		$cari[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'keterangan','apa'=>$cariID);
		// mula cari $cariID dalam $jadual
		foreach ($jadual as $key => $namaPanjang)
		{// mula ulang table
			//$rest = substr("abcdef", 2, -1);  // returns "cde"
			$myTable = substr($namaPanjang, 16);  
			// senarai nama medan
			$medan = ($myTable=='msic2008') ? 
				'seksyen S,bahagian B,kumpulan Kpl,kelas Kls,' .
				'msic2000,msic,keterangan,notakaki' 
				: '*'; 
			
			$this->papar->kawalan['kes'] = $this->tanya->
				cariSemuaData($myTable, $medan, $cari);

		}// tamat ulang table

	}
	
	function paparData($cariID)
	{
        // senaraikan tatasusunan jadual dan setkan pembolehubah
        $jadualKawalan = 'msic2008';//'mfg15_kawal';
        $medanKawalan = '*'
			//.'newss,concat_ws("|",nama,operator) nama,'
			//. '( if (hasil is null, "", '
			/*. ' concat_ws("|",' . "\r"
			. ' 	concat_ws("="," hasil",format(hasil,0)),' . "\r"
			. ' 	concat_ws("="," belanja",format(belanja,0)),' . "\r"
			. ' 	concat_ws("="," gaji",format(gaji,0)),' . "\r"
			. ' 	concat_ws("="," aset",format(aset,0)),' . "\r"
			. ' 	concat_ws("="," staf",format(staf,0)),' . "\r"
			. ' 	concat_ws("="," stok akhir",format(stok,0))' . "\r"
 			. ' ) as data5P,'//*/
			//. 'fe,respon,'		
			//. 'concat_ws(" ",alamat1,alamat2,poskod,bandar) as alamat,' . "\r"
			//. 'concat_ws("-",kp,msic2008) keterangan' 
			. '';
        $this->papar->kesID = array();

        if (!empty($cariID)) 
        {
            //echo '$id:' . $id . '<br>';
            $this->papar->carian='newss';
			//$cari[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'newss','apa'=>$cariID);
			$cari[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'keterangan','apa'=>$cariID);
        
            // 1. mula semak dalam rangka 
            $this->papar->kawalan['kes'] = $this->tanya->
				cariSemuaData($jadualKawalan, $medanKawalan, $cari);

			if(isset($this->papar->kawalan['kes'][0]['newss'])):
				// 1.1 ambil nilai msic & msic08
				//$msic00 = $this->papar->kawalan['kes'][0]['msic'];
				$newss = $this->papar->kawalan['kes'][0]['newss'];
				$msic = $this->papar->kawalan['kes'][0]['keterangan'];
				//326-46312  substr("abcdef", 0, -1);  // returns "abcde"
				$msic08 = substr($msic, 4);  // returns "46312"
				//$cariM6[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'msic','apa'=>$msic08);
			/*
				// 1.2 cari nilai msic & msic08 dalam jadual msic2008
				$jadualMSIC = dpt_senarai('msicbaru');
				// mula cari $cariID dalam $jadual
				foreach ($jadualMSIC as $m6 => $msic)
				{// mula ulang table
					//echo "\$msic=$msic|";
					$jadualPendek = substr($msic, 16);
					//echo "\$jadualPendek=$jadualPendek<br>";
					// senarai nama medan
					if($jadualPendek=='msic2008') //bahagian B,kumpulan K,kelas Kls,
						$medanM6 = 'seksyen S,msic2000,msic,keterangan,notakaki';
					elseif($jadualPendek=='msic2008_asas') 
						$medanM6 = 'msic,survey kp,keterangan,keterangan_en';
					elseif($jadualPendek=='msic_v1') 
						$medanM6 = 'msic,survey kp,bil_pekerja staf,keterangan,notakaki';
					else $medanM6 = '*'; 
					//echo "cariMSIC($msic, $medanM6,<pre>"; print_r($cariM6) . "</pre>)<br>";
					$this->papar->_cariIndustri[$jadualPendek] = $this->tanya->
						cariSemuaData($msic, $medanM6, $cariM6);
				}// tamat ulang table
			//*/
			endif;
		
		}
        else
        {
            $this->papar->carian='[tiada id diisi]';
        }

	}
	
	function cetakData()
	{
		foreach ($this->cariApa as $myTable => $row)
		{
			if ( count($row)==0 )
				echo '';
			else
			{
####################################################################################################################
				?>	<!-- Jadual <?php echo $myTable ?> ########################################### -->	
				<table border="1" class="excel" id="example"><?php
				$printed_headers = false; // mula bina jadual
				#-----------------------------------------------------------------
				for ($kira=0; $kira < count($row); $kira++)
				{	//print the headers once: 	
					if ( !$printed_headers ) 
					{
						?><thead><tr><th>#</th><?php
						foreach ( array_keys($row[$kira]) as $tajuk ) 
						{	
							if ($tajuk=='newss'):
								?><th colspan=1><?php echo $tajuk ?></th><?php 
							else:
								?><th><?php echo $tajuk ?></th><?php
							endif;
						}
						?></tr></thead><?php
						$printed_headers = true; 
					} 
				#-----------------------------------------------------------------		 
					//print the data row 
					?><tbody><tr><td><?php echo $kira+1 ?></td><?php
					foreach ( $row[$kira] as $key=>$data ) 
					{		
						if ($key=='newss')
						{
							$k1 = URL . 'kawalan/ubah/' . $data;
							/*?><td><a target="_blank" href="<?php echo $k1 ?>" class="btn btn-primary btn-mini">Ubah</a></td><?php*/
							?><td><?php echo $data ?></td><?php
						}
						else
							?><td><?php echo $data ?></td><?php
					} 
					?></tr></tbody><?php
				}// endfor
				#-----------------------------------------------------------------
				?></table><?php
####################################################################################################################
			}// end if
		} // end foreach
	}
}