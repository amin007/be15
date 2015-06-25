<?php

class Paparan extends Kawal 
{
    public function __construct() 
    {
        parent::__construct();
        Kebenaran::kawalKeluar();
        
        $this->papar->js = array(
            //'bootstrap.js',
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
            'bootstrap-affix.js',
            'bootstrap-datepicker.js',
            'bootstrap-datepicker.min.js',
            'bootstrap-datepicker.ms.js',
            'bootstrap-editable.min.js');
        $this->papar->css = array(
            'bootstrap-datepicker.css',
            'bootstrap-editable.css');
			
        $this->medanRangka = 'newss,ssm,concat_ws("<br>",nama,operator) as nama,'
			. 'fe,batchProses,respon R,msic2008,kp,nama_kp,'
			. 'concat_ws("<br>",alamat1,alamat2,poskod,bandar,negeri) as alamat' . "\r";
			//. 'tel,fax,responden,email,nota';
		$this->medanData = 'newss,nama,fe,respon R,nama_kp,kp,msic2008,fe,batchProses,terima,hantar,' . "\r"
		   . 'format(gaji,0) gaji,format(staf,0) staf,format(hasil,0) hasil,nota';
		$this->jadualKawal = array('sse15_kawal');
		$this->jadualTahunan = array('sse15_kawal');
		$this->pengguna = Sesi::get('namaPegawai');
		$this->level = Sesi::get('levelPegawai');
    }
    
    public function index($respon = 'semua',$item = 30, $ms = 1, $fe = null) 
    {
        /*
		 * $jenisRespon = semua/selesai/janji/belum/tegar
 		 * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $fe = null // set $fe = pegawai kerja luar tiada
         */
		# set $jenisRespon
		switch ($respon) 
		{
			case "semua" 	: $kesRespon = 'kesSemua'; $break;
			case "selesai" 	: $kesRespon = 'kesSelesai'; $break;
			case "janji" 	: $kesRespon = 'kesJanji'; $break;
			case "belum" 	: $kesRespon = 'kesBelum'; $break;
			case "tegar" 	: $kesRespon = 'kesTegar'; $break;
			default 		: $kesRespon = 'paparSemua';
		}
        # setkan pembolehubah untuk $this->tanya
            $medan = $this->medanRangka;
			//$medan = $this->medanData;

        # mula papar semua dalam $myTable
        foreach ($this->jadualKawal as $key => $myTable)
        {# mula ulang table
			# setkan $medan = ($myTable=='') ? $medanRangka : $medanData;
            # dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($myTable, $medan, $fe);
            # tentukan bilangan mukasurat & bilangan jumlah rekod
			// echo '$bilSemua:'.$bilSemua.', $item:'.$item.', $ms:'.$ms.'<br>';
            $jum = pencamSqlLimit($bilSemua, $item, $ms);
            $this->papar->bilSemua[$myTable] = $bilSemua;
            # sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
				$kesRespon($myTable, $medan, $fe, $jum);
            # halaman
            $this->papar->halaman[$myTable] = halaman($jum);
        }# tamat ulang table
        
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';
		
        # Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'semuajadual';
        # pergi papar kandungan
        $this->papar->baca('kawalan/index', 1);
		
    }

    public function utama($item = 30, $ms = 1, $utama = null, $respon = null, $fe = null) 
    {           
        # Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'utama';

        # pergi papar kandungan
        $this->papar->baca('kawalan/index', 0);
    }
// cetak kes sendiri ikut alamat
    public function alamat($item = 30, $ms = 1, $cariBatch = null, $cariEntah = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $cariBatch = null // set $cariBatch = tiada | atau untuk pegawai kerja luar
         */
		$bilSemua = null; 
		# cari $cariBatch wujud tak
		if (!isset($cariBatch) || empty($cariBatch) ):
			$paparError = 'Tiada batch<br>';
		else:
			if((!isset($cariEntah) || empty($cariEntah) ))
				$paparError = '-';
			else
				$paparError = $cariEntah;
		endif;
		# setkan jadual yang sama untuk sql di bawah ini
		$myTable = 'sse15_kawal';
        # setkan pembolehubah untuk $this->tanya sql1
			$paparTable1 = '1_belum_mko';
            $jadualMedan1 = '/*1:belum_mko*/newss,concat_ws("",nama,operator) as nama,' 
				. 'kp,msic2008 m6,nama_kp,'
				. 'concat_ws(" ",alamat1,alamat2,poskod,bandar) as alamat_penuh,respon,' 
				. 'nota' . ((!isset($cariBatch)) ? ',fe fe' : '') . "\r";
			$cari1[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch,'akhir'=>'');
			$groupBy1 = null; $orderBy1 = 'respon DESC,kp,newss';//'dp_baru, jalan, no';
			#sql1
				$this->papar->cariApa[$paparTable1] = $this->tanya->
					cariIkutSql($myTable, $jadualMedan1, $cari1, $item = 500, $ms = 1, $groupBy1, $orderBy1);					
		# setkan pembolehubah untuk $this->tanya sql2
			$paparTable2 = (!isset($cariBatch)) ? '2_fe' : '2_' .$cariBatch;
			$jadualMedan2 = '/*2:FE*/fe, count(*)as jum';
			$groupBy2 = $orderBy2 = 'fe';
			#sql2
				$this->papar->cariApa[$paparTable2] = $this->tanya->
					cariIkutSql($myTable, $jadualMedan2, null, $item = 300, $ms = 1, $groupBy2, $orderBy2);		
		# setkan pembolehubah untuk $this->tanya sql3
			$paparTable3 = '3_daerah';
			$jadualMedan3 = '/*3:daerah*/bandar, count(*)as jum';
			$cari3[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			$groupBy3 = $orderBy3 = 'bandar';
			#sql3
				$this->papar->cariApa[$paparTable3] = $this->tanya->
					cariIkutSql($myTable, $jadualMedan3, $cari3, $item = 300, $ms = 1, $groupBy3, $orderBy3);
		# setkan pembolehubah untuk $this->tanya sql4
			$paparTable4 = '4_kes_negatif';
			$jadualMedan4 = '/*4:kes_negatif*/newss,ssm,lower(concat_ws("<br>",nama,operator)) as nama,'
				. 'respon R,kp,msic2008 m6,concat_ws(" ",notel,responden,nota) catatan'				
				. '';
			$cari4[] = array('fix'=>'xin','atau'=>'WHERE','medan'=>'respon','apa'=>"('A1','B1','B2','B3','B4','B5','B6','B7')");
			//$cari4[] = array('fix'=>'in','atau'=>'WHERE','medan'=>'respon','apa'=>"('A4')");
			$cari4[] = array('fix'=>'like','atau'=>'AND','medan'=>'fe','apa'=>$cariBatch);
			$groupBy4 = null; $orderBy4 = 'respon,nota,nama';
			#sql4
				$this->papar->cariApa[$paparTable4] = $this->tanya->
					cariIkutSql($myTable, $jadualMedan4, $cari4, $item = 300, $ms = 1, $groupBy4, $orderBy4);
		# setkan pembolehubah untuk $this->tanya sql5
			$paparTable5 = '5_kes_janji';
			$jadualMedan5 = '/*5:kes_janji*/newss,ssm,concat_ws("<br>",nama,operator) as nama,'
				. 'msic2008 m6,kp,nama_kp,respon,nota,nota_prosesan nota2,fe';
			$cari5[] = array('fix'=>'in','atau'=>'WHERE','medan'=>'respon','apa'=>"('B1','B2','B3','B4','B5','B6','B7')");
			$cari5[] = array('fix'=>'like','atau'=>'AND','medan'=>'fe','apa'=>$cariBatch);
			$groupBy5 = null; $orderBy5 = 'nota';
			#sql5
				$this->papar->cariApa[$paparTable5] = $this->tanya->
					cariIkutSql($myTable, $jadualMedan5, $cari5, $item = 300, $ms = 1, $groupBy5, $orderBy5);
		# setkan pembolehubah untuk $this->tanya sql6
			$paparTable6 = '6_kes_B6';
			$jadualMedan6 = '/*6:kes_B6*/newss,lower(concat_ws("<br>",nama,operator)) as nama,'
				. 'concat_ws(" ",alamat1,alamat2,poskod,bandar) as alamat,'
				. 'msic2008 m6,kp,nama_kp brg,respon r,'
				. ' concat_ws("|",' . "\r"
				. ' 	concat("hasil=",format(hasil,0)),' . "\r"
				. ' 	concat("belanja=",format(belanja,0)),' . "\r"
				. ' 	concat("gaji=",format(gaji,0)),' . "\r"
				. ' 	concat("aset=",format(aset,0)),' . "\r"
				. ' 	concat("staf=",format(staf,0)),' . "\r"
				. ' 	concat("stok akhir=",format(stok,0))' . "\r"
				. ' ) as data5P,nota,fe'; //,lawat,terima';
			$cari6[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'respon','apa'=>'B6');
			$cari6[] = array('fix'=>'like','atau'=>'AND','medan'=>'fe','apa'=>$cariBatch);
			$groupBy6 = null; $orderBy6 = 'kp,nama';
			#sql6
				$this->papar->cariApa[$paparTable6] = $this->tanya->
					cariIkutSql($myTable, $jadualMedan6, $cari6, $item = 300, $ms = 1, $groupBy6, $orderBy6);
		# setkan pembolehubah untuk $this->tanya sql7
			$paparTable7 = '7_kes_A1';
			$jadualMedan7 = '/*7:kes_A1*/msic2008 m6,kp,nama_kp,newss,concat_ws("<br>",nama,operator) as nama,'
				. 'concat_ws(" ",alamat1,alamat2,poskod,bandar) as alamat,'
				. ' concat_ws("|",' . "\r"
				. ' 	concat("hasil=",format(hasil,0)),' . "\r"
				. ' 	concat("belanja=",format(belanja,0)),' . "\r"
				. ' 	concat("gaji=",format(gaji,0)),' . "\r"
				. ' 	concat("aset=",format(aset,0)),' . "\r"
				. ' 	concat("staf=",format(staf,0)),' . "\r"
				. ' 	concat("stok akhir=",format(stok,0))' . "\r"
				. ') as data2014,'
				. 'respon,nota,fe';//,dsk d, mko m,hantar';
			$cari7[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'respon','apa'=>'A1');
			$cari7[] = array('fix'=>'like','atau'=>'AND','medan'=>'fe','apa'=>$cariBatch);
			$groupBy7 = null; $orderBy7 = 'msic2008 ASC, nama';
			#sql7
				$this->papar->cariApa[$paparTable7] = $this->tanya->
					cariIkutSql($myTable, $jadualMedan7, $cari7, $item = 300, $ms = 1, $groupBy7, $orderBy7);

		# semak pembolehubah $this->papar->cariApa
		//echo '<pre>$this->papar->cariApa:', print_r($this->papar->cariApa, 1) . '</pre><br>';
    
        # Set pemboleubah utama
		//$this->papar->cariApa[] = array(0=>array('data'=>'kosong'));
		$this->papar->error = '| Nota:' . $paparError; //echo ' Error : ' . $paparError . '<br>';
		$this->papar->cariID = $cariEntah;
        $this->papar->carian = 'alamat';
        $this->papar->_cariBatch = $cariBatch;
		
        # pergi papar kandungan
        $this->papar->baca('kawalan/alamat', 0);
    }

// tukar banyak kes sendiri ikut alamat
    public function ubah($item = 30, $ms = 1, $cariBatch = null, $cariSemua = null, $khas = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $cariBatch = null // set $cariBatch = tiada | atau untuk pegawai kerja luar
         */
        # setkan pembolehubah untuk $this->tanya sql1
			$khas = 'LORONG';
			$myTable = 'sse15_kawal';
            $medan1 = 'newss,concat_ws("<br>",nama,operator,alamat1,alamat2,poskod,dp_baru,negeri,bandar) as alamat_penuh,' 
			//. 'msic2008,kp,nama_kp,daerah,dp_baru,' /*bandar,*/ 
			. 'no,batu,jalan,tmn_kg' 
			. "\r";
			$kumpul = array('kumpul'=>'', 'susun'=>'dp_baru,tmn_kg,jalan');
			$cari[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch,'akhir'=>'');
			$cari[] = array('fix'=>'%like%','atau'=>'AND','medan'=>'dp_baru','apa'=>$cariSemua,'akhir'=>'');
			//$cari[] = array('fix'=>'%like%','atau'=>'AND','medan'=>'NO','apa'=>$khas,'akhir'=>'');
			//$cari[] = array('fix'=>'like','atau'=>'AND','medan'=>'batu','apa'=>null,'akhir'=>'');
			//$cari[] = array('fix'=>'x%like%','atau'=>'AND','medan'=>'alamat1','apa'=>$cariSemua,'akhir'=>'');
			//$cari[] = array('fix'=>'x%like%','atau'=>'OR','medan'=>'alamat2','apa'=>$cariSemua,'akhir'=>')');
			//$cari[] = array('fix'=>'xkhas3','atau'=>'AND','medan'=>'bandar','apa'=>'dp_baru','akhir'=>'');
			//$cari[] = array('fix'=>'khas','atau'=>'AND','medan'=>'daerah','apa'=>'dp_baru','akhir'=>'');
		# $sql 1
            # dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($myTable, $medan1, $cari);
            # tentukan bilangan mukasurat & bilangan jumlah rekod
            $jum = pencamSqlLimit($bilSemua, $item, $ms);
			$susun[] = array_merge($jum, $kumpul );
            # sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
				cariAlamat($myTable, $medan1, $cari, $susun);        
		# setkan pembolehubah untuk $this->tanya sql2
			$paparTable = $cariBatch;
			$jadual = $this->jadualKawal[0];
			$jadualMedan2 = '`dp_baru`, count(*)as jum';
			$kumpul2 = array('kumpul'=>'dp_baru', 'susun'=>'dp_baru');
			$cari2[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
			//$cari2[] = array('fix'=>'like','atau'=>'AND','medan'=>'dp_baru','apa'=>$daerah);
			//$cari2[] = array('fix'=>'khas','atau'=>'AND','medan'=>'daerah','apa'=>'dp_baru');
        # mula cari jadual khas
			# khas utk laporan sahaja
            $jum2 = pencamSqlLimit($bilSemua, $item = 500, $ms);
			$susun2[] = array_merge($jum, $kumpul2 );
            # sql guna limit
            $this->papar->cariApa[$paparTable] = $this->tanya->
				cariAlamat($jadual, $jadualMedan2, $cari2, $susun2);
		# setkan pembolehubah untuk $this->tanya sql3	
			$paparTable = 'hasil';
			$jadual = $this->jadualKawal[0];
			$jadualMedan3 = 'newss,concat_ws("|",nama,operator) as nama,'
			. 'no NOM,batu BT,jalan JLN ,tmn_kg TMN,' 
			. 'concat_ws(" ",alamat1,alamat2,poskod,dp_baru,negeri) as poskod' 
			. "\r";
			$kumpul3 = array('kumpul'=>null, 'susun'=>'dp_baru,jalan ASC,no ASC');
			$cari3[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch,'akhir'=>'');
			$cari3[] = array('fix'=>'%like%','atau'=>'AND','medan'=>'dp_baru','apa'=>$cariSemua,'akhir'=>'');
			//$cari3[] = array('fix'=>'xnull','atau'=>'AND','medan'=>'batu','apa'=>'-','akhir'=>'');
        # mula cari jadual khas
			# khas utk laporan sahaja
            $jum3 = pencamSqlLimit($bilSemua, $item = 500, $ms);
			$susun3[] = array_merge($jum3, $kumpul3 );
            # sql guna limit
            $this->papar->cariApa[$paparTable] = $this->tanya->
				cariAlamat($jadual, $jadualMedan3, $cari3, $susun3);
		//*/
        # semak pembolehubah $this->papar->cariApa
		//echo '<pre>$this->papar->cariApa:', print_r($this->papar->cariApa, 1) . '</pre><br>';
        
        # Set pemboleubah utama
		//$this->papar->cariApa[] = array(0=>array('data'=>'kosong'));
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'alamat';
        $this->papar->_cariBatch = $cariBatch;
        $this->papar->_cariSemua = $cariSemua;
        # pergi papar kandungan
        $this->papar->baca('kawalan/alamat', 0);
    }
	
    public function ubahSimpan()
    {
        $posmen = array();
        $medanID = 'newss';
		$medanUbah = array('no','batu','jalan','tmn_kg','newss');
		$myTable = 'sse15_kawal';
        foreach ($_POST as $namaMedan => $value)
        {
            if ( in_array($namaMedan,$medanUbah) )
            {
                foreach ($value as $kekunci => $papar)
				{
					$posmen[$kekunci][$myTable][$medanID] = $kekunci;
					$posmen[$kekunci][$myTable][$namaMedan] = huruf('BESAR', bersih($papar) );
				}
            }	
        }
        # semak data 
		//echo '<pre>$_POST='; print_r($_POST) . '</pre>';
        //echo '<pre>$posmen='; print_r($posmen) . '</pre>';

        # mula ulang $posmen
        foreach ($posmen as $cariID => $poskad)
		{
			foreach ($poskad as $jadual => $data)
			{
				$this->tanya->ubahSimpan($data, $jadual, $medanID);
			}
        }

        # pergi papar kandungan
		//alamat($item = 30, $ms = 1, $cariBatch = null, $cariSemua = null, $kawasan = null) 
		$cariBatch = $_POST['fe'];
		$cariSemua = $_POST['cariSemua'];
		//echo 'location: ' . URL . "paparan/alamat/10/1/$cariBatch/$cariSemua";
        header('location: ' . URL . "paparan/ubah/10/1/$cariBatch/$cariSemua");
 //*/      
    }
	
    public function semak($item = 30, $ms = 1, $respon, $kp, $nama_kp) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
			WHERE `respon` = 'A1' AND kp = '327' AND nama_kp = 'cdt 2' AND fe not in ()
         */
        // setkan pembolehubah untuk $this->tanya
            $medan = 'newss,ssm,concat_ws("<br>",nama,operator) as nama,nota,fe,msic2008,kp,nama_kp,'
				   . 'concat_ws(" ",alamat1,alamat2,poskod,bandar,negeri) as alamat' . "\r";
			$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'respon','apa'=>$respon);
			$carian[] = array('fix'=>'x=','atau'=>'AND','medan'=>'kp','apa'=>$kp);
			$carian[] = array('fix'=>'%like%','atau'=>'AND','medan'=>'nama_kp','apa'=>$nama_kp);
			$carian[] = array('fix'=>'xin','atau'=>'AND','medan'=>'fe','apa'=>"('amin007','mdt-amin007')");

		# mula papar semua dalam $myTable
        foreach ($this->jadualKawal as $key => $myTable)
        {# mula ulang table
			# setkan $medan = ($myTable=='') ? $medanRangka : $medanData;
            # dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($myTable, $medan, $carian);
            # tentukan bilangan mukasurat & bilangan jumlah rekod
			 //echo "\$bilSemua:$bilSemua, \$item:$item, \$ms:$ms<br>';
            $jum = pencamSqlLimit($bilSemua, $item, $ms, ' nota,nama ASC');
            $this->papar->bilSemua[$myTable] = $bilSemua;
            # sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
				cariAlamat($myTable, $medan, $carian, $jum);
			# halaman
            $this->papar->halaman[$myTable] = halaman($jum);
        }# tamat ulang table
        
        # semak pembolehubah $this->papar->cariApa
		//echo '<pre>$this->papar->cariApa:', print_r($this->papar->cariApa, 1) . '</pre><br>';
        
        # Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'alamat';
        # pergi papar kandungan
        $this->papar->baca('kawalan/index', 0);
    }

}