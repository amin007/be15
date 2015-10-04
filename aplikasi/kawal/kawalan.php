<?php

class Kawalan extends Kawal 
{
    public function __construct() 
    {
        parent::__construct();
        Kebenaran::kawalKeluar();
        
        $this->papar->js = array(
            /*'bootstrap-transition.js','bootstrap-alert.js','bootstrap-modal.js','bootstrap-dropdown.js',
			'bootstrap-scrollspy.js','bootstrap-tab.js','bootstrap-tooltip.js','bootstrap-popover.js',
			'bootstrap-button.js','bootstrap-collapse.js','bootstrap-carousel.js','bootstrap-typeahead.js',
			'bootstrap-affix.js',*/
			'bootstrap-datepicker.js','bootstrap-datepicker.min.js',
			'bootstrap-datepicker.ms.js','bootstrap-editable.min.js');
        $this->papar->css = array(
            'bootstrap-datepicker.css',
            'bootstrap-editable.css');			
    }
    
    public function index() { echo '<br>class Kawalan::index() extend Kawal<br>'; }
    
	function medanKawalan($cariID) 
	{ 
		$news1 = 'http://sidapmuar/ekonomi/ckawalan/ubah/' . $cariID;
		$news2 = 'http://sidapmuar/ekonomi/cprosesan/ubah/000/'.$cariID.'/2010/2015/'; 
		$news3 = 'http://sidapmuar/ekonomi/semakan/ubah/",kp,"/'.$cariID.'/2010/2015/'; 
		$url1 = '" <a target=_blank href=' . $news1 . '>SEMAK 1</a>"';
		$url2 = '" <a target=_blank href=' . $news2 . '>SEMAK 2</a>"';
		$url3 = 'concat("<a target=_blank href=' . $news3 . '>SEMAK 3</a>")';
        $medanKawalan = 'newss,'
			//. '( if (hasil is null, "", '
			. 'concat_ws("|",nama,operator,'.$url1 . ',' . $url3 .') nama,'
			. ' concat_ws("|",' . "\r"
			. ' 	concat_ws("="," hasil",format(hasil,0)),' . "\r"
			. ' 	concat_ws("="," belanja",format(belanja,0)),' . "\r"
			. ' 	concat_ws("="," gaji",format(gaji,0)),' . "\r"
			. ' 	concat_ws("="," aset",format(aset,0)),' . "\r"
			. ' 	concat_ws("="," staf",format(staf,0)),' . "\r"
			. ' 	concat_ws("="," stok akhir",format(stok,0))' . "\r"
 			. ' ) as data5P,'
			. ' concat_ws("|",' . "\r"
			. ' 	"hubungi",' . "\r"
			. ' 	concat_ws("="," responden",responden),' . "\r"
			. ' 	concat_ws("="," tel",tel),' . "\r"
			. ' 	concat_ws("="," fax",fax),' . "\r"
			. ' 	concat_ws("="," orang",orang),' . "\r"
			. ' 	concat_ws("="," notel",notel),' . "\r"
			. ' 	concat_ws("="," nofax",nofax)' . "\r"
 			. ' ) as mko5P,'
			. 'concat_ws(" | ",ssm,kp,sv,nama_kp) as nossm,' . "\r"
			. 'mko,batchProses,respon,nota,nota_prosesan,fe,'		
			. 'concat_ws(" ",alamat1,alamat2,poskod,bandar) as alamat,' . "\r"
			//. 'no,batu,jalan,tmn_kg,dp_baru,' . "\r"
			//. 'concat_ws(" ",no,batu,( if (jalan is null, "", concat("JALAN ",jalan) ) ),tmn_kg,poskod,dp_baru) alamat_baru,' . "\r"
			. 'concat_ws("-",kp,msic2008) msic2008,' 
			. 'concat_ws("-",kp,msic2008) keterangan,' 
			//. 'concat_ws("=>ngdbbp baru=",ngdbbp,ngdbbp_baru) ngdbbp,ngdbbp_baru,' . "\r"
			//. 'batchAwal,dsk,mko,batchProses,'
			. 'tel,notel,fax,nofax,responden,orang,email,esurat,'
			//. 'respon2,lawat,terima,hantar,hantar_prosesan,' . "\r" 
			. 'hasil,belanja,gaji,aset,staf,stok' . "\r" 
			. '';	
		return $medanKawalan;
	}
    
    public function ubah($cariID = null) 
    {//echo '<br>Anda berada di class Imej extends Kawal:ubah($cari)<br>';
                
        // senaraikan tatasusunan jadual dan setkan pembolehubah
        $jadualKawalan = 'sse15_kawal';
        $medanKawalan = $this->medanKawalan($cariID);
	
        if (!empty($cariID)) 
        {
            $this->papar->carian='newss';
			$this->papar->kesID = array();
			$cari[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'newss','apa'=>$cariID);
        
            // 1. mula semak dalam rangka 
            $this->papar->kawalan['kes'] = $this->tanya->
				cariSemuaData($jadualKawalan, $medanKawalan, $cari);
				//cariSql($jadualKawalan, $medanKawalan, $cari);

			if(isset($this->papar->kawalan['kes'][0]['newss'])):
				// 1.1 ambil nilai msic & msic08
				//$msic00 = $this->papar->kawalan['kes'][0]['msic'];
				$newss = $this->papar->kawalan['kes'][0]['newss'];
				$msic = $this->papar->kawalan['kes'][0]['msic2008'];
				//326-46312  substr("abcdef", 0, -1);  // returns "abcde"
				$msic08 = substr($msic, 4);  // returns "46312"
				$cariM6[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'msic','apa'=>$msic08);
			
				// 1.2 cari nilai msic & msic08 dalam jadual msic2008
				$jadualMSIC = dpt_senarai('msicbaru');
				// mula cari $cariID dalam $jadual
				foreach ($jadualMSIC as $m6 => $msic)
				{// mula ulang table
					$jadualPendek = substr($msic, 16);
					//echo "\$msic=$msic|\$jadualPendek=$jadualPendek<br>";
					// senarai nama medan
					if($jadualPendek=='msic2008') /*bahagian B,kumpulan K,kelas Kls,*/
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
			endif;
		
		}
        else
        {
            $this->papar->carian='[tiada id diisi]';
        }
        
        # isytihar pemboleubah
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		$this->papar->cari = (isset($this->papar->kawalan['kes'][0]['newss'])) ? $newss : $cariID;
		$this->papar->_jadual = $jadualKawalan;
		
        
		/*# semak data
		echo '<pre>';
		//echo '$this->papar->kawalan:<br>'; print_r($this->papar->kawalan); 
		echo '$this->papar->cariIndustri:<br>'; print_r($this->papar->_cariIndustri); 
		echo '$this->papar->cari:<br>'; print_r($this->papar->cari); 
		echo '</pre>'; //*/
		
        # pergi papar kandungan
        $this->papar->baca('kawalan/ubah', 0);

    }
    
	public function ubahCari()
	{
		//echo '<pre>$_GET->', print_r($_GET, 1) . '</pre>';
		# bersihkan data $_POST
		$input = bersih($_GET['cari']);
		$dataID = str_pad($input, 12, "0", STR_PAD_LEFT);
		
		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		# pergi papar kandungan
		//echo '<br>location: ' . URL . 'kawalan/ubah/' . $dataID . '';
		header('location: ' . URL . 'kawalan/ubah/' . $dataID);

	}

    public function ubahSimpan($dataID)
    {
        $posmen = array();
        $medanID = 'newss';
		$tahunan = array('sse15_kawal');
    
        foreach ($_POST as $myTable => $value)
        {   if ( in_array($myTable,$tahunan) )
            {   foreach ($value as $kekunci => $papar)
				{	$posmen[$myTable][$kekunci]= 
						( in_array($kekunci,array('hasil','belanja','gaji','aset','staf','stok')) ) ?
						str_replace( ',', '', bersih($papar) )// buang koma	
						: bersih($papar);
				}	$posmen[$myTable][$medanID] = $dataID;
            }
        }
        
		# ubahsuai $posmen
			# buat peristiharan
			$rangka = 'sse15_kawal'; // jadual rangka kawalan
			if (isset($posmen[$rangka]['respon']))
				$posmen[$rangka]['respon']=strtoupper($posmen[$rangka]['respon']);
			if (isset($posmen[$rangka]['fe']))				
				$posmen[$rangka]['fe']=strtolower($posmen[$rangka]['fe']);
			if (isset($posmen[$rangka]['email']))
				$posmen[$rangka]['email']=strtolower($posmen[$rangka]['email']);
			if (isset($posmen[$rangka]['responden']))
				$posmen[$rangka]['responden']=mb_convert_case($posmen[$rangka]['responden'], MB_CASE_TITLE);
			if (isset($posmen[$rangka]['hasil']))
			{
				eval( '$hasil = (' . $posmen[$rangka]['hasil'] . ');' );
				$posmen[$rangka]['hasil'] = $hasil;
			}
			if (isset($posmen[$rangka]['belanja']))			
			{
				eval( '$belanja = (' . $posmen[$rangka]['belanja'] . ');' );
				$posmen[$rangka]['belanja'] = $belanja;
			}
			if (isset($posmen[$rangka]['gaji']))
			{
				eval( '$gaji = (' . $posmen[$rangka]['gaji'] . ');' );
				$posmen[$rangka]['gaji'] = $gaji;
			}
			if (isset($posmen[$rangka]['aset']))			
			{
				eval( '$aset = (' . $posmen[$rangka]['aset'] . ');' );
				$posmen[$rangka]['aset'] = $aset;
			}
			if (isset($posmen[$rangka]['staf']))
			{
				eval( '$staf = (' . $posmen[$rangka]['staf'] . ');' );
				$posmen[$rangka]['staf'] = $staf;
			}
			if (isset($posmen[$rangka]['stok']))			
			{
				eval( '$stok = (' . $posmen[$rangka]['stok'] . ');' );
				$posmen[$rangka]['stok'] = $stok;
			}
			/*if (isset($posmen[$rangka]['no']))
				$posmen[$rangka]['no']=strtoupper($posmen[$rangka]['no']);
			if (isset($posmen[$rangka]['batu']))
				$posmen[$rangka]['batu']=strtoupper($posmen[$rangka]['batu']);
			if (isset($posmen[$rangka]['jalan']))
				$posmen[$rangka]['jalan']=strtoupper($posmen[$rangka]['jalan']);
			if (isset($posmen[$rangka]['tmn_kg']))
				$posmen[$rangka]['tmn_kg']=strtoupper($posmen[$rangka]['tmn_kg']);
			if (isset($posmen[$rangka]['dp_baru']))
				$posmen[$rangka]['dp_baru']=ucwords(strtolower($posmen[$rangka]['dp_baru']));//*/
        //echo '<br>$dataID=' . $dataID . '<br>';
        //echo '<pre>$_POST='; print_r($_POST) . '</pre>';
        //echo '<pre>$posmen='; print_r($posmen) . '</pre>';
 
        # mula ulang $tahunan
        foreach ($tahunan as $kunci => $jadual)
        {// mula ulang table
            $this->tanya->ubahSimpan($posmen[$jadual], $jadual, $medanID);
        }// tamat ulang table
        
        # pergi papar kandungan
		//$this->papar->baca('kawalan/ubah/' . $dataID);
		header('location: ' . URL . 'kawalan/ubah/' . $dataID);
 //*/       
    }

	function buang($id) 
    {//echo '<br>Anda berada di class Imej extends Kawal:buang($cari)<br>';
                
        if (!empty($id)) 
        {       
            // mula cari $cariID dalam $bulanan
            foreach ($bulanan as $key => $myTable)
            {// mula ulang table
                $this->papar->kesID[$myTable] = 
                    $this->tanya->cariSemuaMedan($sv . $myTable, 
                    $medanData, $cari);
            }// tamat ulang table
			
        }
        else
        {
            $this->papar->carian='[tiada id diisi]';
        }
        
        # pergi papar kandungan
        $this->papar->baca('kawalan/buang', 1);

    }

}