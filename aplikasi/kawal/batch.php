<?php

class Batch extends Kawal 
{

    public function __construct() 
    {
        parent::__construct();
        Kebenaran::kawalKeluar();
        
        $this->papar->js = array(
            /*'bootstrap.js',
            'bootstrap-transition.js',
            'bootstrap-alert.js',
            'bootstrap-modal.js',
            'bootstrap-dropdown.js',
            'bootstrap-scrollspy.js',
            'bootstrap-tab.js',
            'bootstrap-tooltip.js',
            'bootstrap-popover.js',
            'bootstrap-button.js',
            'bootstrap-collapse.js',
            'bootstrap-carousel.js',
            'bootstrap-typeahead.js',
            'bootstrap-affix.js',*/
            'bootstrap-datepicker.js',
            'bootstrap-datepicker.ms.js',
            'bootstrap-editable.min.js');
        $this->papar->css = array(
            'bootstrap-datepicker.css',
            'bootstrap-editable.css');
			
        $this->medanRangka = 'newss,nossm,concat_ws("<br>",nama,operator) as nama,'
			. 'fe,hantar_prosesan,respon R,msic2008,kp,nama_kp,'
			. 'concat_ws("<br>",alamat1,alamat2,poskod,bandar,negeri) as alamat' 
			//. 'concat_ws("<br>",semak1,mdt,notamdt2014,notamdt2012,notamdt2011) as nota_lama'
			. "\r";
		$this->medanData = 'newss,nama,fe,respon R,nama_kp,kp,msic2008,fe,' . "\r"
		   . 'format(gaji,0) gaji,format(staf,0) staf,format(hasil,0) hasil,nota';
		$this->pengguna = Sesi::get('namaPegawai');
		$this->level = Sesi::get('levelPegawai');
    }
    
    public function index() 
    { 
		echo 'class Batchawal::index() extends Kawal ';
    }
	
// UNTUK KES POM
	public function buangBatchAwal($cariBatch = null, $dataID = null)
	{
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'sse15_kawal';
			//$jadual = 'cdt_pom_baki';
			$medanID = 'newss';
			$posmen[$jadual]['fe'] = null;
			$posmen[$jadual]['respon'] = null;
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$this->tanya->ubahSimpan($posmen[$jadual], $jadual, $medanID);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
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
			$medanID = 'newss';
			$posmen[$jadual]['fe'] = $cariBatch;
			$posmen[$jadual]['respon'] = 'B7';
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$data = $posmen[$jadual];
			$this->tanya->ubahSimpan($data, $jadual, $medanID);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'SSE 2015 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/awal/$cariBatch/$dataID" . '';
		header('location: ' . URL . "batch/awal/$cariBatch/$dataID");

	}
	
	public function awal($cariBatch = null, $cariID = null) 
    {    
		# setkan pembolehubah untuk $this->tanya
			//echo "\$cariBatch = $cariBatch . \$cariID = $cariID <br>";
			$item = 1000; $ms = 1;
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
			$medan = $medanData;
			$senaraiJadual = array('sse15_kawal');
		# cari $cariBatch wujud tak
		if (!isset($cariBatch) || empty($cariBatch) ):
			$paparError = 'Tiada batch<br>';
		else:
			if((!isset($cariID) || empty($cariID) ))
				$paparError = 'Tiada id<br>';
			else
			{
				$paparMedan = 'newss,nossm,nama,operator,'
					. 'concat_ws(" ",alamat1,alamat2,poskod,bandar,negeri) as alamat';
				$cariNama[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'newss','apa'=>$cariID);
				$dataKes = $this->tanya->cariSatuSahaja($senaraiJadual[0], $paparMedan, $cariNama);
				//echo '<pre>', print_r($dataKes, 1) . '</pre><br>';
				$paparError = 'Ada id:' . $dataKes['newss'] 
							. '| ssm:' . $dataKes['nossm']
							. '<br> nama:' . $dataKes['nama'] 
							. '| operator:' . $dataKes['operator']
							. '<br> alamat:' . $dataKes['alamat']; 
			}			
		endif;
		
			# mula papar semua dalam $myTable
			$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			foreach ($senaraiJadual as $key => $myTable)
			{# mula ulang table
				# dapatkan bilangan jumlah rekod
				//echo "\$myTable:$myTable | \$medan:$medan | \$cariBatch:$cariBatch<br>";
				$bilSemua = $this->tanya->kiraKes($myTable, $medan, $carian);
				# tentukan bilangan mukasurat. bilangan jumlah rekod
				//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
				$jum = pencamSqlLimit($bilSemua, $item, $ms);
				$cantumSusun[] = array_merge($jum, array('kumpul'=>null,'susun'=>'fe DESC,respon DESC,nama') );
				$this->papar->bilSemua[$myTable] = $bilSemua;
				# sql guna limit //$this->papar->cariApa = array();
				$this->papar->cariApa[$myTable] = $this->tanya->
					kesBatchAwal($myTable, $medan, $carian, $cantumSusun);
				# halaman
				$this->papar->halaman[$myTable] = halaman($jum);
			}# tamat ulang table
			
			# batchAwal = null, mdt = not null
			# tentukan bilangan mukasurat. bilangan jumlah rekod
			//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
			$jum2 = pencamSqlLimit(300, $item, $ms);
			$susun2[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'nama') );
			$jadualGroup = $senaraiJadual[0];
			/*
			# sql semula
			$carian[] = array('fix'=>'xnull','atau'=>'AND','medan'=>'mdt','apa'=>'-');
			$this->papar->cariApa['batchAwalnullMdt'] = $this->tanya->
				kesBatchAwal($jadualGroup, $medan, $carian, $susun2);
			# sql semula untuk cdtmdt
			$cariMDTCDT[] = array('fix'=>'xnull','atau'=>'WHERE','medan'=>'mdt','apa'=>'-');
			$this->papar->cariApa['cdtMdt'] = $this->tanya->
				kesBatchAwal($jadualGroup, $medan, $cariMDTCDT, $susun2);
			//*/
			# buat group ikut fe
			$susun3[] = array_merge($jum2, array('kumpul'=>'fe','susun'=>'fe') );
			# sql semula
			$this->papar->cariApa['kiraBatchAwal'] = $this->tanya->
				cariGroup($jadualGroup, $medan = 'fe, count(*) as kira', $carian = null, $susun3);

        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

        # Set pemboleubah utama
		## untuk menubar
		$this->papar->pegawai = senarai_kakitangan();
		
		## untuk dalam class Papar
		$this->papar->error = $paparError; //echo ' Error : ' . $paparError . '<br>';
		$this->papar->cariBatch = $cariBatch;
		$this->papar->cariID = $cariID;
		$this->papar->carian = 'semua';
        
        # pergi papar kandungan
        $this->papar->baca('kawalan/batchawal', 0);
    }
// untuk data negeri johor
	public function buangBatchJohor($cariBatch = null, $dataID = null)
	{
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'cdt2014_johor';
			$medanID = 'newss';
			$posmen[$jadual]['batchAwal'] = null;
			$posmen[$jadual]['respon'] = null;
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$this->tanya->ubahSimpan($posmen[$jadual], $jadual, $medanID);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/johor/$cariBatch" . '';
		header('location: ' . URL . "batch/johor/$cariBatch");

	}

	public function ubahBatchJohor($cariBatch)
	{
		//echo '<pre>$_GET->', print_r($_GET, 1) . '</pre>';
		# bersihkan data $_POST
		$dataID = bersihGET('cari');
		
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'cdt2014_johor';
			$medanID = 'newss';
			$posmen[$jadual]['batchAwal'] = $cariBatch;
			$posmen[$jadual]['respon'] = 'B7';
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$this->tanya->ubahSimpanSemua($posmen[$jadual], $jadual, $medanID);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/johor/$cariBatch/$dataID" . '';
		header('location: ' . URL . "batch/johor/$cariBatch/$dataID");

	}
	
	public function johor($cariBatch = null, $cariID = null) 
    {    
		# setkan pembolehubah untuk $this->tanya
			//echo "\$cariBatch = $cariBatch . \$cariID = $cariID <br>";
			$item = 500; $ms = 1;
			$senaraiJadual = array('cdt2014_johor');

		if (!isset($cariBatch) || empty($cariBatch) ):
			$paparError = 'Tiada batch<br>';
		else:
			if((!isset($cariID) || empty($cariID) ))
				$paparError = 'Tiada id<br>';
			else
			{
				$paparMedan = 'newss,nossm,nama,operator,'
					. 'concat_ws(" ",alamat1,alamat2,poskod,bandar,negeri) as alamat' . "\r";
				$cariNama[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'newss','apa'=>$cariID);
				$dataKes = $this->tanya->cariSatuSahaja($senaraiJadual[0], $paparMedan, $cariNama);
				//echo '<pre>', print_r($dataKes, 1) . '</pre><br>';
				$paparError = 'Ada id:' . $dataKes['newss'] 
							. '| ssm:' . $dataKes['nossm']
							. '<br> nama:' . $dataKes['nama'] 
							. '| operator:' . $dataKes['operator']
							. '<br> alamat:' . $dataKes['alamat']; 
			}			
		endif;
		
			# mula papar semua dalam $myTable
			$medan = 'newss,nossm,nama,operator,batchAwal,msic2008,kp,respon r,'
			       . 'concat_ws("<br>",alamat1,alamat2,poskod,bandar,negeri) as alamat' . "\r";
			$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
			foreach ($senaraiJadual as $key => $myTable)
			{# mula ulang table
				# dapatkan bilangan jumlah rekod
				//echo "\$myTable:$myTable | \$medan:$medan | \$cariBatch:$cariBatch<br>";
				$bilSemua = $this->tanya->kiraKes($myTable, $medan, $carian);
				# tentukan bilangan mukasurat. bilangan jumlah rekod
				//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
				$jum = pencamSqlLimit($bilSemua, $item, $ms);
				$cantumSusun[] = array_merge($jum, array('kumpul'=>null,'susun'=>'nama DESC') );
				$this->papar->bilSemua[$myTable] = $bilSemua;
				# sql guna limit
				$this->papar->cariApa[$myTable] = $this->tanya->
					kesBatchJohor($myTable, $medan, $carian, $cantumSusun);
				# halaman
				//$this->papar->halaman = halamanf3($jum);
			}# tamat ulang table
			//$this->papar->cariApa = array();
			
			# buat group ikut batchAwal
			//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
			$jum2 = pencamSqlLimit(300, $item, $ms);
			$susun[] = array_merge($jum2, array('kumpul'=>'batchAwal','susun'=>'batchAwal') );
			$jadualGroup = $senaraiJadual[0];
			# sql semula
			$this->papar->cariApa['kiraBatchAwal'] = $this->tanya->
				cariGroup($jadualGroup, $medan = 'batchAwal, count(*) as id', $carian = null, $susun);

			# buat semakan ikut batch JOHOR
			$jadualA = 'cdt2014_johor a, sse15_kawal b';
			$medanA = 'a.newss,a.nama,a.batchAwal batchAwalJ,b.batchAwal,b.batchJohor';
			$susunA[] = array_merge($jum2, array('kumpul'=>null,'susun'=>'a.batchAwal') );
			
				# buat semakan ikut batchPJB
				$cari2[] = array('fix'=>'xkhas','atau'=>'WHERE','medan'=>'a.newss','apa'=>'b.newss');
				$cari2[] = array('fix'=>'xkhas2','atau'=>'AND','medan'=>'a.batchAwal','apa'=>'batchPJB');
				# sql semula
				$this->papar->cariApa['kiraBatchPJB'] = $this->tanya->
					cariGroup($jadualA, $medanA, $cari2, $susunA);

				# buat semakan ikut batchPOK
				$cari3[] = array('fix'=>'xkhas','atau'=>'WHERE','medan'=>'a.newss','apa'=>'b.newss');
				$cari3[] = array('fix'=>'xkhas2','atau'=>'AND','medan'=>'a.batchAwal','apa'=>'batchPOK');
				# sql semula
				$this->papar->cariApa['kiraBatchPOK'] = $this->tanya->
					cariGroup($jadualA, $medanA, $cari3, $susunA);
				
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

        # Set pemboleubah utama
		## untuk menubar
		$this->papar->pegawai = senarai_kakitangan();
		
		## untuk dalam class Papar
		$this->papar->error = $paparError; //echo ' Error : ' . $paparError . '<br>';
		$this->papar->cariBatch = $cariBatch;
		$this->papar->cariID = $cariID;
		$this->papar->carian = 'semua';
        
        # pergi papar kandungan
        $this->papar->baca('kawalan/batchjohor', 0);
    }

	public function tukarBatch($tukarBatch)
	{
/*			echo '<pre>$sql jangkaan->
			UPDATE sse15_kawal INNER JOIN cdt_sambilan 
			ON sse15_kawal.newss = cdt_sambilan.newss 
			SET 
			sse15_kawal.batchAwal = [dataAwal]
			WHERE (((cdt_sambilan.dataAwal) Is Not Null));
			</pre>';*/
		//echo '<pre>$_GET->', print_r($_GET, 1) . '</pre>';
		# bersihkan data $_GET
		$asalBatch = $_GET['asal'];//bersihGET('asal');			
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'sse15_kawal';
			$medanID = 'batchAwal';
			$posmen[$jadual]['batchAwal'] = $tukarBatch;
			$dimana[$jadual]['batchAwal'] = $asalBatch;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$this->tanya->ubahSimpanSemua($posmen[$jadual], $jadual, 
				$medanID, $dimana[$jadual]);
  
		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/awal/$tukarBatch" . '';
		//header('location: ' . URL . "batch/awal/$tukarBatch");
		//*/
	}
	
// semak kes JB hantar Muar	
	public function ubahBatchSemak($cariBatch)
	{
		//echo '<pre>$_GET->', print_r($_GET, 1) . '</pre>';
		# bersihkan data $_POST
		$dataID = bersihGET('cari');
		
		# masuk dalam database
			# ubahsuai $posmen
			//$jadual = 'sse15_kawal';
			$jadual = 'cdt_pom_baki';
			$medanID = 'newss';
			$posmen[$jadual]['batchAwal'] = $cariBatch;
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$data = $posmen[$jadual];
			$this->tanya->ubahSimpan($data, $jadual, $medanID);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		header('location: ' . URL . "batchawal/semak/$cariBatch/$dataID");

	}
	
	public function semak($cariBatch = null, $cariID = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $fe = null // set $fe = pegawai kerja luar tiada
         */
		
		# setkan pembolehubah untuk $this->tanya
			//echo "\$cariBatch = $cariBatch . \$cariID = $cariID <br>";
			$item = 500; $ms = 1;
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
			$medan = $medanRangka;
			$senaraiJadual = array('sse15_kawal');
			//$senaraiJadual = array('cdt_pom_baki');

		if (!isset($cariBatch) || empty($cariBatch) ):
			$paparError = 'Tiada batch<br>';
		else:
			$paparError = ((!isset($cariID) || empty($cariID) )) ?
				'Tiada id<br>' : 'Ada id:' . $cariID . '<br>';
		endif;
		
			# mula papar semua dalam $myTable
			$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
			$carian[] = array('fix'=>'x=','atau'=>'AND','medan'=>'hantar','apa'=>'2014-09-20');
			foreach ($senaraiJadual as $key => $myTable)
			{# mula ulang table
				# dapatkan bilangan jumlah rekod
				//echo "\$myTable:$myTable | \$medan:$medan | \$cariBatch:$cariBatch<br>";
				$bilSemua = $this->tanya->kiraKes($myTable, $medan, $carian);
				# tentukan bilangan mukasurat. bilangan jumlah rekod
				//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
				$jum = pencamSqlLimit($bilSemua, $item, $ms);
				$cantumSusun[] = array_merge($jum, array('kumpul'=>null,'susun'=>'nama DESC') );
				$this->papar->bilSemua[$myTable] = $bilSemua;
				# sql guna limit
				$this->papar->cariApa[$myTable] = $this->tanya->
					kesBatchAwal($myTable, $medan, $carian, $cantumSusun);
				# halaman
				$this->papar->halaman[$myTable] = halaman($jum);
			}# tamat ulang table
			//$this->papar->cariApa = array();
        
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

        # Set pemboleubah utama
		## untuk menubar
		$this->papar->pegawai = senarai_kakitangan();
		
		## untuk dalam class Papar
		$this->papar->error = $paparError; //echo ' Error : ' . $paparError . '<br>';
		$this->papar->cariBatch = $cariBatch;
		$this->papar->cariID = $cariID;
		$this->papar->carian = 'semua';
        
        # pergi papar kandungan
        $this->papar->baca('kawalan/batchawal', 0);
    }
// untuk penghantaran ke prosesan
	public function ubahBatchProses($cariBatch)
	{
		//echo '<pre>$_GET->', print_r($_GET, 1) . '</pre>';
		# bersihkan data $_POST
		$dataID = bersihGET('cari');
		
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'sse15_kawal';
			//$jadual = 'cdt_pom_baki';
			$medanID = 'newss';
			$posmen[$jadual]['batchProses'] = $cariBatch;
			//$posmen[$jadual]['respon'] = 'A1';
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$this->tanya->ubahSimpan($posmen[$jadual], $jadual, $medanID);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		# pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/proses/$cariBatch/$dataID" . '';
		header('location: ' . URL . "batch/proses/$cariBatch/$dataID");

	}
	
	public function proses($cariBatch = null, $cariID = null) 
    {    	
		# setkan pembolehubah untuk $this->tanya
			//echo "\$cariBatch = $cariBatch . \$cariID = $cariID <br>";
			$item = 500; $ms = 1;
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
			$medan = $medanData;
			$senaraiJadual = array('sse15_kawal');

		if (!isset($cariBatch) || empty($cariBatch) ):
			$paparError = 'Tiada batch<br>';
		else:
			if((!isset($cariID) || empty($cariID) ))
				$paparError = 'Tiada id<br>';
			else
			{
				$paparMedan = 'newss,nossm,nama,operator,'
					. 'concat_ws(" ",alamat1,alamat2,poskod,bandar,negeri) as alamat';
				$cariNama[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'newss','apa'=>$cariID);
				$dataKes = $this->tanya->cariSatuSahaja($senaraiJadual[0], $paparMedan, $cariNama);
				//echo '<pre>', print_r($dataKes, 1) . '</pre><br>';
				$paparError = 'Ada id:' . $dataKes['newss'] 
							. '| ssm:' . $dataKes['nossm']
							. '<br> nama:' . $dataKes['nama'] 
							. '| operator:' . $dataKes['operator']
							. '<br> alamat:' . $dataKes['alamat']; 
			}			
		endif;
		
			# mula papar semua dalam $myTable
			//$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
			$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'hantar_prosesan','apa'=>$cariBatch);
			foreach ($senaraiJadual as $key => $myTable)
			{# mula ulang table
				# dapatkan bilangan jumlah rekod
				//echo "\$myTable:$myTable | \$medan:$medan | \$cariBatch:$cariBatch<br>";
				$bilSemua = $this->tanya->kiraKes($myTable, $medan, $carian);
				# tentukan bilangan mukasurat. bilangan jumlah rekod
				//echo "\$bilSemua:$bilSemua, \$item:$item, \$ms:$ms <br>";
				$jum = pencamSqlLimit($bilSemua, $item, $ms);
				$cantumSusun[] = array_merge($jum, array('kumpul'=>null,'susun'=>'hantar_prosesan,respon') );
				$this->papar->bilSemua[$myTable] = $bilSemua;
				# sql guna limit //$this->papar->cariApa = array();
				$this->papar->cariApa[$myTable] = $this->tanya->
					kesBatchAwal($myTable, $medan, $carian, $cantumSusun);
				# halaman
				$this->papar->halaman[$myTable] = null; 
			}# tamat ulang table
			
			# buat group hantar/respon 
			# tentukan bilangan mukasurat. bilangan jumlah rekod
			//echo "\$bilSemua:$bilSemua, \$item:$item, \$ms:$ms <br>";
			$jum = pencamSqlLimit(300, $item, $ms);
			$susun[] = array_merge($jum, array('kumpul'=>'hantar_prosesan,respon','susun'=>'hantar_prosesan,respon') );
			$jadualGroup = $senaraiJadual[0];
			# sql semula
			$this->papar->cariApa['kiraBatchProses'] = $this->tanya->
				cariGroup($jadualGroup, $medan = 'hantar_prosesan, respon, count(*) as kira', $carian = null, $susun);

			# buat group respon 
			$susun2[] = array_merge($jum, array('kumpul'=>'respon','susun'=>'respon') );
			$jadualGroup = $senaraiJadual[0];
			# sql semula
			$this->papar->cariApa['kiraRespon'] = $this->tanya->
				cariGroup($jadualGroup, $medan = 'respon, count(*) as kira', $carian = null, $susun2);
        
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

        # Set pemboleubah utama
		## untuk menubar
		$this->papar->pegawai = senarai_kakitangan();
		
		## untuk dalam class Papar
		$this->papar->error = $paparError; //echo ' Error : ' . $paparError . '<br>';
		$this->papar->cariBatch = $cariBatch;
		$this->papar->cariID = $cariID;
		$this->papar->carian = 'semua';
        
        # pergi papar kandungan
        $this->papar->baca('kawalan/batchprosesan', 0);
    }

}