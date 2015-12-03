<?php

class Batch extends Kawal 
{

	public function __construct() 
	{
		parent::__construct();
		Kebenaran::kawalKeluar();

		$this->pengguna = Sesi::get('namaPegawai');
		$this->level = Sesi::get('levelPegawai');
		# untuk $this->papar
		$this->papar->js = array(
			/*'bootstrap.js','bootstrap-transition.js','bootstrap-alert.js','bootstrap-modal.js',
			'bootstrap-dropdown.js','bootstrap-scrollspy.js','bootstrap-tab.js','bootstrap-tooltip.js',
			'bootstrap-popover.js','bootstrap-button.js','bootstrap-collapse.js','bootstrap-carousel.js',
			'bootstrap-typeahead.js','bootstrap-affix.js',*/
			'bootstrap-datepicker.js','bootstrap-datepicker.ms.js','bootstrap-editable.min.js');
		$this->papar->css = array('bootstrap-datepicker.css','bootstrap-editable.css');
		# istihar pembolehubah untuk class 
		$this->medanRangka = 'newss,ssm,concat_ws("<br>",nama,operator) as nama,'
			. 'fe,batchProses,hantar_prosesan,mko,respon R,msic2008,kp,nama_kp,'
			. 'concat_ws("<br>",alamat1,alamat2,poskod,bandar,negeri) as alamat' 
			//. 'concat_ws("<br>",semak1,mdt,notamdt2014,notamdt2012,notamdt2011) as nota_lama'
			. "\r";
		$this->medanData = 'newss,ssm,nama,fe,batchProses hantar,"<input type=\"checkbox\">" as tik,mko, ' . "\r"
			//. 'concat_ws("<br>",alamat1,alamat2,poskod,bandar,negeri) as alamat,' 
			. 'respon R,nama_kp,kp,msic2008,'
			//. 'format(gaji,0) gaji,format(staf,0) staf,format(hasil,0) hasil,nota'
			. ' concat_ws("|",' . "\r"
			. ' 	concat_ws("="," hasil",format(hasil,0)),' . "\r"
			. ' 	concat_ws("="," belanja",format(belanja,0)),' . "\r"
			. ' 	concat_ws("="," gaji",format(gaji,0)),' . "\r"
			. ' 	concat_ws("="," aset",format(aset,0)),' . "\r"
			. ' 	concat_ws("="," staf",format(staf,0)),' . "\r"
			. ' 	concat_ws("="," stok akhir",format(stok,0))' . "\r"
 			. ' ) as data5P,nota'
			. "\r";
	}
    
	public function index()
	{ 
		echo 'class Batchawal::index() extends Kawal ';
		# pergi papar kandungan
		$this->papar->baca('kawalan/io', 1);
	}
	
// UNTUK KES POM
	public function buangBatchAwal($cariBatch = null, $dataID = null)
	{
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'sse15_kawal';
			$posmen[$jadual]['fe'] = null;
			$posmen[$jadual]['respon'] = null;
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
	
		$this->tanya->ubahSimpan($posmen, $jadual, $medanID = 'newss');

		# Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->lokasi = 'SSE 2015 - Ubah';
		
		# pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/awal/$cariBatch" . '';
		header('location: ' . URL . "batch/awal/$cariBatch");

	}

	public function ubahBatchAwal($cariBatch)
	{
		//echo '<pre>$_GET->', print_r($_GET, 1) . '</pre>';
		$dataID = bersihGET('cari'); # bersihkan data $_POST
		
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'sse15_kawal'; //$jadual = 'cdt_pom_baki';
			$posmen[$jadual]['fe'] = $cariBatch;
			$posmen[$jadual]['respon'] = 'B7';
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$this->tanya->ubahSimpan($posmen, $jadual, $medanID = 'newss');

		# Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->lokasi = 'SSE 2015 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/awal/$cariBatch/$dataID" . '';
		header('location: ' . URL . "batch/awal/$cariBatch/$dataID");

	}
	
	private function wujudBatchAwal($senaraiJadual, $cariBatch = null, $cariID = null) 
	{
		if (!isset($cariBatch) || empty($cariBatch) ):
			$paparError = 'Tiada batch<br>';
		else:
			if((!isset($cariID) || empty($cariID) ))
				$paparError = 'Tiada id<br>';
			else
			{
				$paparMedan = 'newss,ssm,nama,operator,'
					. 'concat_ws(" ",alamat1,alamat2,poskod,bandar) as alamat';
				$cariNama[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'newss','apa'=>$cariID);
				$dataKes = $this->tanya->cariSatuSahaja($senaraiJadual[0], $paparMedan, $cariNama);
				//echo '<pre>', print_r($dataKes, 1) . '</pre><br>';
				$paparError = 'Ada id:' . $dataKes['newss'] 
					. '| ssm:' . $dataKes['ssm']
					. '<br> nama:' . $dataKes['nama'] 
					. '| operator:' . $dataKes['operator']
					. '<br> alamat:' . $dataKes['alamat']; 
			}			
		endif;
	
		return $paparError;
	}

	public function awal($cariBatch = null, $cariID = null) 
	{    
		//echo "\$cariBatch = $cariBatch . \$cariID = $cariID <br>";	
			$senaraiJadual = array('sse15_kawal'); # set senarai jadual yang terlibat
			# cari $cariBatch atau cariID wujud tak
			$this->papar->error = $this->wujudBatchAwal($senaraiJadual, $cariBatch, $cariID);
			# mula carian dalam jadual $myTable
			$this->cariAwal($senaraiJadual, $cariBatch, $cariID, $this->medanData);
			$this->cariGroup($senaraiJadual, $cariBatch, $cariID, $this->medanData);
			
		# semak pembolehubah $this->papar->cariApa
		//echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

		# Set pemboleubah utama
		## untuk dalam class Papar
		$this->papar->cariBatch = $cariBatch;
		$this->papar->cariID = $cariID;
		$this->papar->carian = 'semua';
        
		# pergi papar kandungan
		$this->papar->baca('kawalan/batchawal', 0);
	}

	private function cariAwal($senaraiJadual, $cariBatch, $cariID, $medan)
	{
		$item = 1000; $ms = 1; ## set pembolehubah utama
			# sql 1
			$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			foreach ($senaraiJadual as $key => $myTable)
			{# mula ulang table
				# dapatkan bilangan jumlah rekod
				$bilSemua = $this->tanya->kiraKes($myTable, $medan, $carian);
				# tentukan bilangan mukasurat. bilangan jumlah rekod
				//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
				$jum = pencamSqlLimit($bilSemua, $item, $ms);
				$cantumSusun[] = array_merge($jum, array('kumpul'=>null,'susun'=>'kp DESC,respon DESC,nama') );
				$this->papar->bilSemua[$myTable] = $bilSemua;
				# sql guna limit //$this->papar->cariApa = array();
				$this->papar->cariApa['sse'] = $this->tanya->
					kesBatchAwal($myTable, $medan, $carian, $cantumSusun);
				# halaman
				$this->papar->halaman[$myTable] = halaman($jum);
			}# tamat ulang table
			
		## tentukan bilangan mukasurat. bilangan jumlah rekod
			//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
			$jum2 = pencamSqlLimit(300, $item, $ms);
			$susunMfg[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'respon,nama') );
			$susunPpt[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'batchProses DESC,mko DESC,kp,nama') );
			$susunNama[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'kp,nama') );
			$susunBandar[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'bandar desc,nama') );
			$susunNota[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'nota asc,nama') );
			$jadual = $senaraiJadual[0];
			
			# sql 2 - cari kes MFG
			$cariMFG[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$cariMFG[] = array('fix'=>'zin','atau'=>'AND','medan'=>'kp','apa'=>'("205","800")');
			$this->papar->cariApa['mfg'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariMFG, $susunMfg);
			# sql 3 - cari kes PPT
			$cariPPT[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$cariPPT[] = array('fix'=>'x!=','atau'=>'and','medan'=>'kp','apa'=>'205');
			$this->papar->cariApa['ppt'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariPPT, $susunPpt);
			# sql 4.1 - buat group ikut alamat // "<input type=\"checkbox\">" as tik,
			$medanA = 'newss,nama,alamat1,alamat2,bandar';
			$cariA[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$this->papar->cariApa['alamat'] = $this->tanya->
				kesBatchAwal($jadual, $medanA, $cariA, $susunBandar);
			# sql 4.2 - buat group ikut alamat // "<input type=\"checkbox\">" as tik,
			$medanABtPht = 'newss,lower(nama) nama,concat_ws(" ",lower(alamat1),lower(alamat2)) alamat,lower(bandar) bandar'
				. ',mko,respon,nota'
				. '';
			$cariABtPht[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$cariABtPht[] = array('fix'=>'%like%','atau'=>'AND','medan'=>'bandar','apa'=>'batu pahat');
			$this->papar->cariApa['BtPahat'] = $this->tanya->
				kesBatchAwal($jadual, $medanABtPht, $cariABtPht, null);
			# sql 4.3 - buat group ikut alamat // "<input type=\"checkbox\">" as tik,
			$medanASgt = 'newss,lower(nama) nama,concat_ws(" ",lower(alamat1),lower(alamat2)) alamat,lower(bandar) bandar'
				. ',mko,respon,nota'
				. '';
			$cariASgt[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$cariASgt[] = array('fix'=>'%like%','atau'=>'AND','medan'=>'bandar','apa'=>'segamat');
			$this->papar->cariApa['Segamat'] = $this->tanya->
				kesBatchAwal($jadual, $medanASgt, $cariASgt, null);
			# sql 4.4 - buat group ikut alamat // "<input type=\"checkbox\">" as tik,
			$medanAMuo = 'newss,lower(nama) nama,concat_ws(" ",lower(alamat1),lower(alamat2)) alamat,lower(bandar) bandar'
				. ',mko,respon,nota'
				. '';
			$cariAMuo[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$cariAMuo[] = array('fix'=>'%like%','atau'=>'AND (','medan'=>'bandar','apa'=>'muar');
			$cariAMuo[] = array('fix'=>'%like%','atau'=>' OR ','medan'=>'bandar','apa'=>'parit jawa','akhir'=>')');
			$this->papar->cariApa['Muar'] = $this->tanya->
				kesBatchAwal($jadual, $medanAMuo, $cariAMuo, $susunNota);
			# sql 5 - cari kes belum siap
			$cariBlm[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$cariBlm[] = array('fix'=>'in','atau'=>'and','medan'=>'respon','apa'=>"('B1','B2','B3','B4','B5','B7')");
			$this->papar->cariApa['belum'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariBlm, $susunNama);
			# sql 6 - cari kes B6 - proses lengkap
			$susunB6[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'kp,newss,hasil DESC,mko DESC') );
			$cariB6[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$cariB6[] = array('fix'=>'x=','atau'=>'and','medan'=>'respon','apa'=>'B6');
			$this->papar->cariApa['b6'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariB6, $susunB6);
			# sql 7 - cari kes A1
			$susunA1[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'batchProses DESC,mko DESC,kp,nama') );
			$cariA1[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$cariA1[] = array('fix'=>'x=','atau'=>'and','medan'=>'respon','apa'=>'A1');
			$this->papar->cariApa['a1'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariA1, $susunA1);
			# sql 8 - cari kes NEGATIF
			$susunNegatif[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'batchProses DESC,mko DESC,kp,nama') );
			$cariNegatif[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$cariNegatif[] = array('fix'=>'xin','atau'=>'and','medan'=>'respon','apa'=>"('A1','B1','B2','B3','B4','B5','B6','B7')");
			$this->papar->cariApa['-ve'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariNegatif, $susunNegatif);
	}

	private function cariGroup($senaraiJadual, $cariBatch, $cariID, $medan)
	{
		$jum2 = pencamSqlLimit(300, $item=30, $ms=1);
		$jadual = $senaraiJadual[0];
		## buat group, $medan set semua
			# sql 5 - buat group ikut fe
			$susunFE[] = array_merge($jum2, array('kumpul'=>'fe','susun'=>'fe') );
			$this->papar->cariApa['kiraBatchAwal'] = $this->tanya->
				cariGroup($jadual, $medan = 'fe as batchAwal, count(*) as kira', $carian = null, $susunFE);
			# sql 6 - buat group ikut pembuatan / perkhidmatan
			$cariKP[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$susunKP[] = array_merge($jum2, array('kumpul'=>'kp,sv,nama_kp','susun'=>'kp,sv,nama_kp') );
			$this->papar->cariApa['kiraKP' . $cariBatch] = $this->tanya->
				cariGroup($jadual, $medan = 'kp,sv,nama_kp, count(*) as kira', $cariKP, $susunKP);	
	}
##############################################################################################################	
	public function ubahBatchProses($tukarBatch)
	{
		//echo '<pre>$_GET->', print_r($_GET, 1) . '</pre>';
		# bersihkan data $_GET
		//$asalBatch = $_GET['asal'];//bersihGET('asal');			
		$asalBatch = $_GET['cari']; //bersihGET('cari');			
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'sse15_kawal';
			$medanID = 'batchProses';
			$posmen[$jadual]['batchProses'] = $tukarBatch;
			$dimana[$jadual]['newss'] = $asalBatch;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
			//echo '<pre>$dimana='; print_r($dimana) . '</pre>';
        
			$this->tanya->ubahSimpanSemua($posmen[$jadual], $jadual, $medanID, $dimana[$jadual]);
  
		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/awal/$tukarBatch" . '';
		//header('location: ' . URL . "batch/awal/$tukarBatch"); //*/
	}

	private function wujudBatchProses($senaraiJadual, $cariBatch = null, $cariID = null) 
	{
		if (!isset($cariBatch) || empty($cariBatch) ):
			$paparError = 'Tiada batch<br>';
		else:
			if((!isset($cariID) || empty($cariID) ))
				$paparError = 'Tiada id<br>';
			else
			{
				$paparMedan = 'newss,ssm,nama,operator,batchProses,'
					. 'concat_ws(" ",alamat1,alamat2,poskod,bandar) as alamat';
				$cariNama[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariID);
				$dataKes = $this->tanya->cariSatuSahaja($senaraiJadual[0], $paparMedan, $cariNama);
				//echo '<pre>', print_r($dataKes, 1) . '</pre><br>';
				$paparError = 'Ada id:' . $dataKes['newss'] 
					. '| ssm:' . $dataKes['ssm']
					. '<br> nama:' . $dataKes['nama'] 
					. '| operator:' . $dataKes['operator']
					. '<br> alamat:' . $dataKes['alamat']; 
			}			
		endif;
	
		return $paparError;
	}
	
	public function proses($cariBatch = null, $cariID = null) 
	{    
		//echo "\$cariBatch = $cariBatch . \$cariID = $cariID <br>";
			$senaraiJadual = array('sse15_kawal'); # set senarai jadual yang terlibat
			# cari $cariBatch atau cariID wujud tak
			$this->papar->error = $this->wujudBatchProses($senaraiJadual, $cariBatch, $cariID);
			# mula carian dalam jadual $myTable
			$this->cariProses($senaraiJadual, $cariBatch, $cariID, $this->medanData);
			$this->cariGroupProses($senaraiJadual, $cariBatch, $cariID, $this->medanData);
			
		# semak pembolehubah $this->papar->cariApa
		//echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

		# Set pemboleubah utama
		## untuk dalam class Papar
		$this->papar->cariBatch = $cariBatch;
		$this->papar->cariID = $cariID;
		$this->papar->carian = 'semua';
        
		# pergi papar kandungan
		$this->papar->baca('kawalan/batchprosesan', 0);
	}
	
	private function cariProses($senaraiJadual, $cariBatch, $cariID, $medan)
	{
		$item = 1000; $ms = 1; ## set pembolehubah utama	
		## tentukan bilangan mukasurat. bilangan jumlah rekod
			//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
			$jum2 = pencamSqlLimit(300, $item, $ms);
			$susunNama[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'kp,nama') );
			$susunBandar[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'bandar desc,nama') );
			$susunNota[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'nota asc,nama') );
			$jadual = $senaraiJadual[0];
			
		# sql 2 - cari kes MFG
			$cariMFG[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$cariMFG[] = array('fix'=>'zin','atau'=>'AND','medan'=>'kp','apa'=>'("205","800")');
			$this->papar->cariApa['mfg'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariMFG, $susunNama);
		# sql 3 - cari kes PPT
			$cariPPT[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$cariPPT[] = array('fix'=>'x!=','atau'=>'and','medan'=>'kp','apa'=>'205');
			$this->papar->cariApa['ppt'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariPPT, $susunNama);
		# sql 4.1 - buat group ikut alamat // "<input type=\"checkbox\">" as tik,
			$medanA = 'newss,nama,alamat1,alamat2,bandar';
			$cariA[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$this->papar->cariApa['alamat'] = $this->tanya->
				kesBatchAwal($jadual, $medanA, $cariA, $susunBandar);
		# sql 4.2 - buat group ikut alamat // "<input type=\"checkbox\">" as tik,
			$medanABtPht = 'newss,lower(nama) nama,concat_ws(" ",lower(alamat1),lower(alamat2)) alamat,lower(bandar) bandar'
				. ',mko,respon,batchProses,nota'
				. '';
			$cariABtPht[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$cariABtPht[] = array('fix'=>'%like%','atau'=>'AND','medan'=>'bandar','apa'=>'batu pahat');
			$this->papar->cariApa['BtPahat'] = $this->tanya->
				kesBatchAwal($jadual, $medanABtPht, $cariABtPht, null);
		# sql 4.3 - buat group ikut alamat // "<input type=\"checkbox\">" as tik,
			$medanASgt = 'newss,lower(nama) nama,concat_ws(" ",lower(alamat1),lower(alamat2)) alamat,lower(bandar) bandar'
				. ',mko,respon,batchProses,nota'
				. '';
			$cariASgt[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$cariASgt[] = array('fix'=>'%like%','atau'=>'AND','medan'=>'bandar','apa'=>'segamat');
			$this->papar->cariApa['Segamat'] = $this->tanya->
				kesBatchAwal($jadual, $medanASgt, $cariASgt, null);
		# sql 4.4 - buat group ikut alamat // "<input type=\"checkbox\">" as tik,
			$medanAMuo = 'newss,lower(nama) nama,concat_ws(" ",lower(alamat1),lower(alamat2)) alamat,lower(bandar) bandar'
				. ',mko,respon,batchProses,nota'
				. '';
			$cariAMuo[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$cariAMuo[] = array('fix'=>'%like%','atau'=>'AND (','medan'=>'bandar','apa'=>'muar');
			$cariAMuo[] = array('fix'=>'%like%','atau'=>' OR ','medan'=>'bandar','apa'=>'parit jawa','akhir'=>')');
			$this->papar->cariApa['Muar'] = $this->tanya->
				kesBatchAwal($jadual, $medanAMuo, $cariAMuo, $susunNota);
		# sql 5 - cari kes Selesai
			$cariSelesai[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$cariSelesai[] = array('fix'=>'in','atau'=>'and','medan'=>'respon','apa'=>"('A1','B1','B2','B3','B4','B5','B6','B7')");
			$this->papar->cariApa['selesai'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariSelesai, $susunNama);
		# sql 6 - cari kes NEGATIF
			$cariNegatif[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$cariNegatif[] = array('fix'=>'xin','atau'=>'and','medan'=>'respon','apa'=>"('A1','B1','B2','B3','B4','B5','B6','B7')");
			$this->papar->cariApa['-ve'] = $this->tanya->
				kesBatchAwal($jadual, $medan, $cariNegatif, $susunNama);
	}
	
	private function cariGroupProses($senaraiJadual, $cariBatch, $cariID, $medan)
	{
		$jum2 = pencamSqlLimit(300, $item=30, $ms=1);
		$jadual = $senaraiJadual[0];
		## buat group, $medan set semua
			# sql 5 - buat group ikut nombor batch
			//$cariKP[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$susunKP[] = array_merge($jum2, array('kumpul'=>'batchProses','susun'=>'batchProses') );
			$this->papar->cariApa['proses'] = $this->tanya->
				cariGroup($jadual, $medan = 'batchProses hantar_prosesan, count(*) as kira', $cariKP = null, $susunKP);	
	}
	
	public function terima($kp = null, $tarikh = null) 
	{
		//echo "\$kp = $kp . \$tarikh = $tarikh <br>";
			$senaraiJadual = array('sse15_prosesan'); # set senarai jadual yang terlibat
			# mula carian dalam jadual $myTable
			$this->terimaProses($senaraiJadual[0], $kp, $tarikh);
			
		# semak pembolehubah $this->papar->cariApa
		echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

		# Set pemboleubah utama
		## untuk dalam class Papar
		$this->papar->kp = $kp;
		$this->papar->tarikh = $tarikh;
		$this->papar->carian = 'semua';
        
		# pergi papar kandungan
		//$this->papar->baca('kawalan/batchprosesan', 0);
		
	}
	
	private function terimaProses($jadual, $kp, $tarikh)
	{
		$item = 1000; $ms = 1; ## set pembolehubah utama	
		## tentukan bilangan mukasurat. bilangan jumlah rekod
			//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
			$jum2 = pencamSqlLimit(300, $item, $ms);
			$susunNama[] = array_merge($jum2, array('kumpul'=>1,'susun'=>1) );

		# sql 1
		//$paparSemua[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
		$this->papar->cariApa['terimaKini'] = $this->tanya->
			terimaProses($jadual, $medan='`kp terkini` `KP`, tarikh,', null, $susunNama);
		# sql 2
		//$cariNegatif[] = array('fix'=>'xin','atau'=>'and','medan'=>'respon','apa'=>"('A1','B1','B2','B3','B4','B5','B6','B7')");
	}
# tamat class Batch extend Kawal
}