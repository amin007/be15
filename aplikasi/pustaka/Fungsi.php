<?php

function dpt_url()
{
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    return $url;
}

function dpt_url_xfilter()
{
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    //$url = rtrim($url, '/');
    //$url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    return $url;
}

function dpt_ip()
{
    $IP = array('192.168.1.', '10.69.112.', 
        '127.0.0.1', '10.72.112.',
        '60.48.66.1','175.140.12',
        '175.141.21');

    return $IP;
}

function pecah_post()
{
    $papar['pilih'] = isset($_POST['pilih']) ? $_POST['pilih'] : null;
    $papar['cari'] = isset($_POST['cari']) ? $_POST['cari'] : null;
    $papar['fix'] = isset($_POST['fix']) ? $_POST['fix'] : null;
    $papar['atau'] = isset($_POST['atau']) ? $_POST['atau'] : null;
    
    $kira['pilih'] = count($papar['pilih']);
    $kira['cari'] = count($papar['cari']);
    $kira['fix'] = count($papar['fix']);
    $kira['atau'] = count($papar['atau']);
    
    return $kira;
    //echo '<pre>'; print_r($kira) . '</pre>';
}

function dpt_senarai($namajadual)
{
    $e = 'pom_dataekonomi.';
    $l = 'pom_lokaliti.';
    $mm = 'pom_datamm.';
	if ($namajadual=='msiclama')
		$jadual = array($e.'msic08',$e.'msic2008',
		$e.'msic_v1',$e.'msic_bandingan',
		$e.'msic',$e.'msic_nota_kaki');
	elseif ($namajadual=='msicbaru')
		$jadual = array($e.'msic2008',//$e.'msic2008_asas',
		$e.'msic_v1',$e.'msic_bandingan',
		$e.'msic2000',$e.'msic2000_notakaki');
	elseif ($namajadual=='produk')
		$jadual = array($e.'kodproduk_aup',
		$e.'kodproduk_mei2011',
		$e.'kod2010_input',
		$e.'kod2010_output',
		$e.'mcpa2008_tr2010',
		$e.'mcpa2009_tr2013',
		$e.'mcpa2009_tr2014',
		$e.'mcpa2009_input',
		/*'kodproduk_unitkuantiti'*/);
	elseif ($namajadual=='syarikat')
	{
		$t = 12;
		$jadual = array('kawal_icdt'.$t,
		'5p_icdt'.$t,'rangka_icdt'.$t,
		'alamat_icdt'.$t);
	}
	elseif ($namajadual=='kawalan_tahunan')
	{
		$jadual = array('kawal_ppmas09',
			'kawal_rpe09',
			'kawal_tani09',
			'sse08_rangka',
			'sse09_buat',
			'sse09_ppt',
			'sse10_kawal',
			'alamat_newss_2013');
	}
	elseif ($namajadual=='prosesan')
	{
        $jadual = array($e.'tblprofpert',
        $e.'tblprofpert_2009',
        $e.'tblprofpert_2010');
	}
	elseif ($namajadual=='data_prosesan')
        $jadual = array($e.'tblemp',
		$e.'tblframe',
		$e.'tblmisc',
		$e.'tblorder',
		$e.'tblprodsale',
		$e.'tblprofpert',
		$e.'tblstock');
	elseif ($namajadual=='johor')
		$jadual = array('pom_lokaliti.johor',
		'pom_lokaliti.lk_johor');
	
	return $jadual;
}

function bulanan($jenis, $t)
{    
    if ($jenis=='kawalan') // $t = '12' , tahun
        $bulan = array('rangka'.$t,
        'jan'.$t, 'feb'.$t, 'mac'.$t, 'apr'.$t, 
        'mei'.$t, 'jun'.$t, 'jul'.$t, 'ogo'.$t, 
        'sep'.$t, 'okt'.$t, 'nov'.$t, 'dis'.$t);
    elseif ($jenis=='tambahkes')
    {
        //$t='13'; // tahun rujukan
        $sv='mdt_'; // jenis penyiasatan
        $bulan = array($sv.'rangka'.$t,
        $sv.'jan'.$t, $sv.'feb'.$t, $sv.'mac'.$t, $sv.'apr'.$t, 
        $sv.'mei'.$t, $sv.'jun'.$t, $sv.'jul'.$t, $sv.'ogo'.$t, 
        $sv.'sep'.$t, $sv.'okt'.$t, $sv.'nov'.$t, $sv.'dis'.$t);
    }
    elseif ($jenis=='data_bulanan') 
        $bulan = array(
        'jan'.$t, 'feb'.$t, 'mac'.$t, 'apr'.$t, 
        'mei'.$t, 'jun'.$t, 'jul'.$t, 'ogo'.$t, 
        'sep'.$t, 'okt'.$t, 'nov'.$t, 'dis'.$t);
    elseif ($jenis=='nama_bulan') 
        $bulan = array(
        'jan', 'feb', 'mac', 'apr', 
        'mei', 'jun', 'jul', 'ogo', 
        'sep', 'okt', 'nov', 'dis');
    elseif ($jenis=='key_nama_bulan') 
        $bulan = array(
        'jan' => 0, 'feb' => 1, 'mac' => 2, 'apr' => 3, 
        'mei' => 4, 'jun' => 5, 'jul' => 6, 'ogo' => 7, 
        'sep' => 8, 'okt' => 9, 'nov' =>10, 'dis' =>11);
    elseif ($jenis=='bulan_penuh')
        $bulan = array('Januari', 'Februari', 'Mac', 'April', 
        'Mei', 'Jun', 'Julai', 'Ogos', 
        'September', 'Oktober', 'November', 'Disember');
   elseif ($jenis=='key_bulan_penuh')
        $bulan = array('Januari' => 0, 'Februari' => 1, 'Mac' => 2, 'April' => 3, 
        'Mei' => 4, 'Jun' => 5, 'Julai' => 6, 'Ogos' => 7, 
        'September' => 8, 'Oktober' => 9, 'November' => 10, 'Disember' => 11);
	elseif ($jenis=='nama_harian')
		$bulan = array('Ahad','Isnin','Selasa','Rabu',
		'Khamis','Jumaat','Sabtu');
	elseif ($jenis=='key_nama_harian')
		$bulan = array('Ahad' => 0,'Isnin' => 1,'Selasa' => 2,'Rabu' => 3,
		'Khamis' => 4,'Jumaat' => 5,'Sabtu' => 6);
	elseif ($jenis=='lewat')
		$bulan = array(null,'LEWAT DENGAN TANDA TANGAN','LEWAT TANPA TANDA TANGAN');
	elseif ($jenis=='ctr')
		$bulan = array(null,'CUTI GANTIAN','CUTI LATIHAN PASUKAN SUKARELA',
		'CUTI MENGAMBIL BAHAGIAN DALAM SUKAN',
		'CUTI MENGHADIRI LATIHAN',
		'CUTI MENGHADIRI LATIHAN SYARIKAT KERJASAMA',
		'CUTI MENGHADIRI MESYUARAT PERSATUAN IKHTISAS',
		'CUTI TUGAS KHAS PERUBATAN',
		'CUTI UNTUK MASUK PEPERIKSAAN');
	elseif ($jenis=='cb')
		$bulan = array(null,'CUTI ISTERI BERSALIN','CUTI BERSALIN 30 HARI','CUTI BERSALIN 90 HARI');
    //elseif ($jenis=='') $bulan = array();
	# pulangkan nilai $bulan
	return $bulan;
}

function dptNamaHari($tarikh)
{
	$hb = date('w', strtotime($tarikh)); // w = cari key dalam tarikh
	$namaHari = array_search($hb,bulanan('key_nama_harian', null)); // papar nama hari
	return $namaHari;
}

function senarai_kakitangan()
{
    $pegawai[]='adam';
    $pegawai[]='amin';
    $pegawai[]='ariff';
    $pegawai[]='azim';
    $pegawai[]='fendi';
    $pegawai[]='irwan';
    $pegawai[]='khairi';
    $pegawai[]='mazlan';
    $pegawai[]='murad';
    $pegawai[]='musa';
    $pegawai[]='mustaffa';
    $pegawai[]='norita';
    $pegawai[]='razak';
    $pegawai[]='shukor';
    $pegawai[]='suhaida';
    $pegawai[]='sujana';
    
    return $pegawai;
}

function lihat($tab,$kini,$papar,$pegawai) 
{    
    $selit = null;
    $p = dpt_url(); // sepatutnya kawalan/semua/30/2/amin/
    $item = ( !isset($p[2]) ) ? '20/' : $p[2] . '/'; //'30'; 
    $ms = ( !isset($p[3]) ) ? '1/' : $p[3] . '/'; // '2';
    $url = URL . $papar . $item . $ms;
    $i = 1;
    
    foreach ($pegawai as $fe) 
    {
        $selit .= $tab . '<li><a href="' . $url . $fe . '">' . 
        $i++ . ' ' . $fe . '</a></li>' . "\r";
    }
    echo "\r" . $selit . $tab;
}

function pencamSqlLimit($bilSemua, $item, $ms)
{
    // Tentukan bilangan jumlah dalam DB:
    $jum['bil_semua'] = $bilSemua;
    // ambil halaman semasa, jika tiada, cipta satu! 
    $jum['page'] = ( !isset($ms) ) ? 1 : $ms; // mukasurat
    // berapa item dalam satu halaman
    $jum['max'] = ( !isset($item) ) ? 30 : $item; // item
    // Tentukan had query berasaskan nombor halaman semasa.
    $dari = (($jum['page'] * $jum['max']) - $jum['max']); 
    $jum['dari'] = ( !isset($dari) ) ? 0 : $dari; // dari
    // Tentukan bilangan halaman. 
    $jum['muka_surat'] = ceil($jum['bil_semua'] / $jum['max']);
    // nak tentukan berapa bil jumlah dlm satu muka surat
    $jum['bil'] = $jum['dari']+1; 
    
    return $jum;
}

function halaman($jum)
{// function halaman() - mula
    $mula = '<div style="background-color: #fffaf0; color:black;text-align:center">';
    $tamat = '</div>';
    $page = $jum['page'];
    // Tentukan had query berasaskan nombor halaman semasa.
    //$jum['dari'] = (($jum['page'] * $jum['max']) - $jum['max']); 
    // Tentukan bilangan halaman. $jum['muka_surat'] 
	$muka_surat = ceil($jum['bil_semua'] / $jum['max']);
    $bil_semua = $jum['bil_semua'];
    $baris_max = $jum['max'];
            
    $url = dpt_url();  // sepatutnya kawalan/semua/30/1/amin/
    $class = ( !isset($url[0]) ) ? null : $url[0]; //'kawalan'; 
    $fungsi = ( !isset($url[1]) ) ? null : $url[1]; //'semua'; 
    $batch = ( !isset($url[2]) ) ? null : $url[2]; //'batch'; 
    $item = ( !isset($url[3]) ) ? null : $url[3]; //'30'; 
    $ms = ( !isset($url[4]) ) ? null : $url[4]; //'ms'; 
    //$fe = ( !isset($url[4]) ) ? null : $url[4]; //'fe'; 
    
    $senarai = URL . "$class/$fungsi/$baris_max/";
    $halaman = "\n$mula\r" 
		. '<ul class="pagination pagination-sm">' 
		. "\r<li><a>Bil:($bil_semua)($muka_surat)- Papar halaman</a></li>";
        
    if($page > 1) // Bina halaman sebelum
        $halaman .= "\r<li><a href='$senarai" . ($page-1) . "'>&laquo;</a></li>";
    for($i = 1; $i <= $muka_surat; $i++) // Bina halaman terkini
        {$halaman .= ($page==$i)? "\r<li><a>($i)</a></li>" : 
		"\r<li><a href='$senarai$i'>$i</a></li>";}
    if($page < $muka_surat) // Bina halaman akhir
        $halaman .= "\r<li><a href='$senarai" . ($page+1) . "'>&raquo;</a></li>";
        
    $halaman .= "\n</ul>\n$tamat";

    return $halaman;
}// function halaman() - tamat

// cetakF3
function paparJadualF3_TajukBesar($allRows,$rows,$fields,$kodsv,$namaOrg,$item,$ms)
{
	#pecah pembolehubah $nama orang
	$nama_penyelia = $namaOrg['penyelia'];
	$nama_pegawai = $namaOrg['pegawai'];
	## tajuk besar
	switch ($kodsv):
		case 'MDT': $SV='PENYIASATAN PERDAGANGAN EDARAN BULANAN'; break;
		case 'CDT': $SV='BANCI PERDAGANGAN EDARAN'; break;
		case 'MM':  $SV='PENYIASATAN PEMBUATAN BULANAN'; break;
		case 'QSS': $SV='PENYIASATAN PERKHIDMATAN SUKU TAHUNAN'; break;
		case 'SSE':  $SV='PENYIASATAN TAHUNAN'; break;
		case 'MFG':  $SV='PENYIASATAN PEMBUATAN TAHUNAN'; break;
		case 'SERVIS':  $SV='PENYIASATAN PERKHDIMATAN TAHUNAN'; break;
		case 'PPPMAS':  $SV='PENYIASATAN PERBELANJAAN UNTUK PELINDUNGAN ALAM SEKITAR'; break;
		default: $SV=null;
	endswitch;

	echo '<td colspan=' . ($fields+1) . '><font size=2>' .
		//'<div align="right">Lampiran 3<br>F 3 </div>' .
		'<div align="right">Lampiran A : F3 </div>' .
		//'</td><td>' .
		'<div align="center">' .
		'JABATAN PERANGKAAN MALAYSIA NEGERI JOHOR' .
		'<br>SENARAI INDUK AGIHAN KES ANGGOTA ' .
		'<br>' . $SV . ' ' . date('Y') .
		'</div><br>' .
		//'</td><td>' .
		'<div align="left">' .
		"Nama Penyelia : $nama_penyelia" .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		"Nama FE : $nama_pegawai ($allRows kes)" .
		"(muka " . ($ms) . " dari ".($item).")" .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .	
		//'</td><td>' .
		'Tarikh : <u>' . (date('d')) .
		(date('/m/Y')) . '</u> ' .
		'</div>' .
		'</td>' . "\r";

}

function paparJadualF3_TajukMedan($sv,$namaOrg,$allRows,$rows,$fields,$hasil,$item,$ms)
{
	## tajuk besar
	echo '<tr style="page-break-before:always">';
	paparJadualF3_TajukBesar($allRows,$rows,$fields,$sv,$namaOrg,$item,$ms);
	echo '</tr>';
	
	## tajuk medan - keputusan 
	echo '<tr>';
	echo "\n<th rowspan=\"2\">Bil</th>\n";
	echo '<th rowspan="2">Nama Syarikat (KES ' . $namaOrg['pegawai'] . ')</th>' . "\n";
	echo '<th rowspan="2">Kod Peny.</th>' . "\n";
	echo '<th rowspan="1">BBU</th>' . "\n";
	echo '<th rowspan="2">NO SIRI NEWSS</th>' . "\n";
	echo '<th rowspan="2">NOTA/CATATAN'
		. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
		. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
		. '</th>' . "\n";
	echo '<th colspan="22">Diisi oleh Anggota Kerja Luar sahaja</th>' . "\n";
	echo '</tr>';
	
	// bawah 	
	echo '<tr>';
/*	echo '<th>&nbsp;</th>' . "\n";
	echo '<th>&nbsp;</th>' . "\n";
	echo '<th>&nbsp;</th>' . "\n";*/
	echo '<th>SBU</th>' . "\n";
	foreach ($hasil[0] as $kunci => $dataan)
	{
		echo (in_array($kunci,array('nama','sv','utama','newss','nota')))?  
		'':'<th>'.$kunci.'</th>' . "\n";	
	}
	echo '</tr>';

}

function paparJadualF3_TajukMedan1($nama_pegawai=null)
{
	## tajuk medan - keputusan 
	echo "<tr>\n<th rowspan=2>Bil</th>\n";
	echo '<th rowspan=2>Nama Syarikat</th>' . "\n";
	echo '<th rowspan=2>Kod Peny.</th>' . "\n";
	echo '<th rowspan=1>BBU</th>' . "\n";
	echo '<th rowspan=2>NO SIRI NEWSS</th>' . "\n";
	echo '<th colspan=22>Diisi oleh Anggota Kerja Luar sahaja</th>' . "\n";
	echo "</tr>\n";
	
}

function paparJadualF3_TajukBawah($rows,$fields)
{
	## pecah muka surat
	//$cetak=($bil==$rows)?'style="page-break-after:always">':'>';
	$cetak='style="page-break-after:always">';
	echo '<tr style="page-break-after:always"><td colspan=' . ($fields+1) . '>' .
		'<p align=left><font size=2>' .
		'A) Laporan kawalan harian ini merujuk kepada arahan Pengarah pada mesyuarat Pemantauan' .
		'<br>B) Sila kemaskini laporan ini setiap hari dan failkan mengikut turutan tarikh oleh FE' .
		'<br>C) Tarikh laporan ini bersamaan tarikh kerja luar pada F2 syarikat yang disenaraikan' .
		'<br>D) Laporan ini tidak perlu diisi oleh FE jika tiada kerja luar / telefon dsb' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'</font></p></td></tr>' . "\r";
}

function paparJadualF3_Data($sv,$namaOrg,$allRows,
	$rows,$fields,$hasil,$item,$ms,$baris=30)
{	
	// nak cari $rows
	if ($rows=='0'): echo "\n";
	else: // mula kalau jumpa
		# PEMBOLEH UBAH
		$highlight=" onmouseover=\"this.className='tikusatas';\" onmouseout=\"this.className='tikuslepas1';\"";
		$highlight2=" onmouseover=\"this.className='tikusatas';\" onmouseout=\"this.className='tikuslepas2';\"";
	
		//echo "<tbody>\n"; # mula tbody
		foreach ($hasil as $kira => $nilai)
		{	//$mula = ($ms==1) ? $ms : ($ms*$item)-$ms;
			$h = ($kira%'2'=='0') ? $highlight : $highlight2;
			echo "<tr$h>";
			if ($kira%$baris=='0')
			{			
				$ms = ($kira/$baris)+1;
				$item = ceil($allRows/$baris);
				paparJadualF3_TajukMedan($sv,$namaOrg,$allRows,$rows,$fields,$hasil,$item,$ms);
				echo "<td><a target='_blank' href='" . URL . 'kawalan/ubah/'
					. $nilai['newss']."'>".($kira+1)."</a></td>\n";
			}
			else
			{
				echo "<td><a target='_blank' href='" . URL . 'kawalan/ubah/'
				. $nilai['newss']."'>".($kira+1)."</a></td>\n";		
			}
			foreach ($nilai as $key => $data)
			{
				echo '<td>' . $data . '</td>';
			}echo "</tr>\n";
		}
		## cukupkan 30 rows
			$mula = $allRows+1;
			//$bilAwal = ($item-1)*30;  # dpt bil muka surat akhir
			//$bilAkhir = $rows - $bilAwal; # $rows tolak bil tadi
			//$terakhir = 30 - $bilAkhir; # 30 tolak beza tadi
			$akhir = $rows + ( $baris - ($rows - (($item-1)*$baris) ) );
			//$mula = $rows+1;
			for($i = $mula; $i <= ($akhir); $i++)
			{
				echo '<tr><td>' . $i . '</td>';
				echo '<td>&nbsp;</td>';
				//echo "<td><font color=\"yellow\">"
				//	. $rows . '-' .(($item-1)*30)." = ".(30 - ($rows - (($item-1)*30) )).", "
				//	. " nombor terakhir > $rows + ".(30 - ($rows - (($item-1)*30) ))." => $akhir</td>";
					for($j = 1; $j <= (24); $j++)
					echo '<td>&nbsp;</td>';
				echo '<tr>';
			}
		
		## tajuk bawah - bil, jumlah besar, utama, newss, A1-B7
			echo "<tr>\n";// dptkan nama medan
			echo '<th>&nbsp;</th>' . "\n";
			echo '<th colspan=2>Jumlah Besar</th>' . "\n";
			echo '<th>&nbsp;</th>' . "\n";
			echo '<th>&nbsp;</th>' . "\n";
			echo '<th>&nbsp;</th>' . "\n";
			foreach ($hasil[0] as $key => $kunci)
			{
				//echo '<th>&nbsp;</th>' . "\n";	
				echo (in_array($key,array('nama','sv','utama','newss','nota')))?  
				'':'<th>' . $kunci . '</th>' . "\n";	
			}
			echo "</tr>\n";
		## tamat tbody
		//echo "</tbody>\n";
	endif;
}
// papar data biasa
function paparJadual_Data($allRows,$rows,$fields,$item,$ms,$hasil)
{	
	// nak cari $rows
	if ($rows=='0'): echo "\n";
	else: // mula kalau jumpa
		## tajuk atas
			echo "<tr>\n";// dptkan nama medan
			echo '<th colspan=5>RANGKA</th>' . "\n";
			echo '<th colspan=3>KOD 11</th>' . "\n";
			echo '<th colspan=6>PENERIMAAN BORANG</th>' . "\n";
			echo '<th colspan=6>BAKI BORANG</th>' . "\n";
			echo "</tr>\n";
		## tajuk medan
			echo "<tr>\n";// dptkan nama medan
			$senaraiMedan = array('KES','KP','PJB','POK','POM','PJB','POK','POM',
				'PJB','%PJB','POK','%POK','POM','%POM',
				'PJB','%PJB','POK','%POK','POM','%POM'
			);
			foreach ($senaraiMedan as $key)
			{
				echo '<th align="center">' . $key . '</th>';
			}echo "</tr>\n";
		# PEMBOLEH UBAH
		$highlight=" onmouseover=\"this.className='tikusatas';\" onmouseout=\"this.className='tikuslepas1';\"";
		$highlight2=" onmouseover=\"this.className='tikusatas';\" onmouseout=\"this.className='tikuslepas2';\"";
	
		//echo "<tbody>\n"; # mula tbody
		foreach ($hasil as $kira => $nilai)
		{	//$mula = ($ms==1) ? $ms : ($ms*$item)-$ms;
			$h = ($kira%'2'=='0') ? $highlight : $highlight2;
			echo "<tr$h>";
			foreach ($nilai as $key => $data)
			{
				echo ($data == null) ? '<td align="center">JUM</td>'
				:'<td align="center">' . $data . '</td>';
			}echo "</tr>\n";
		}
		
		//echo "</tbody>\n";
	endif;
}


// pautan dalam list data
function pautanID($url, $medan)
{
	$id = !isset($medan['no_kp']) ? null : $medan['no_kp'];
	$tarikh = !isset($medan['tarikh']) ? null : $medan['tarikh'];
	$bulanan = bulanan('nama_bulan', null);
	$p = array(
		'ubah' => array(
			'nama' => 'Ubah',
			'url' => $url . 'biodata/ubah/' . $id,
			'class' => 'btn btn-info btn-mini',
			'icon' => 'glyphicon glyphicon-pencil' ),
		'cetak' => array(
			'nama' => 'Cetak',
			'url' => $url . 'biodata/cetak/' . $id,
			'class' => 'btn btn-warning btn-mini',
			'icon' => 'glyphicon glyphicon-print' ),
		);
		
		?><td><!-- Split button -->
<!--
		<div class="btn-group">
			<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-book"></span>Hadir</button>
			<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu" role="menu"><?php
				echo "\n\t";
				foreach ($bulanan as $key => $bln):?>
				<li><a target="_blank" href="<?php echo $url ?>biodata/hadirbulan/<?php 
				echo ($key+1) . '/' . $id ?>">Bulan <?php echo ($key+1) . '-' 
				. (huruf('Besar_Depan',$bln)) ?></a></li><?php
				echo "\n\t";
				endforeach;?>	
			</ul>
		</div><div class="btn-group">
			<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-book"></span>Semak</button>
			<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<?php
	if (!empty($tarikh)) 
	{
		?><li><a target="_blank" href="<?=$url?>biodata/ubah_catatan/merah/<?php
		echo $tarikh . '/' .$id	?>">Merah <?=$tarikh?></a></li>
		<li><a target="_blank" href="<?=$url?>biodata/ubah_catatan/cuti/<?php
		echo $tarikh . '/' .$id	?>">Cuti <?=$tarikh?></a></li><?php echo "\n\t";
	}
	foreach ($bulanan as $key => $bln):?>
				<li><a target="_blank" href="<?=$url?>biodata/semakbulan/<?php 
		echo ($key+1) . '/' . $id ?>">Bulan <?php echo ($key+1) . '-' 
		. (huruf('Besar_Depan',$bln)) ?></a></li><?php
		echo "\n\t";
	endforeach;?>	
			</ul>
		</div>
-->
		<?php foreach ( $p AS $papar2=>$data2 ) :
		echo "\n";
		?><a target="_blank" href="<?php echo $data2['url'] 
		?>" class="<?php echo $data2['class'] 
		?>"><span class="<?php echo $data2['icon']
		?>"></span><?php echo $data2['nama'] ?></a><?php
		endforeach; ?>

		</td><?php
}

function cariMedanInput($ubah,$f,$row,$nama) 
{/* mula -
    $ubah = nama jadual
    $f = nombor medan
    $row = data medan
    $nama = nama medan
    
    senarai nama medan
    0-nota,1-respon,2-fe,3-tel,4-fax,        
    5-responden,6-email,7-msic,8-msic08,
    9-`id U M`,10-nama,11-sidap,12-status 
 */// papar medan yang terlibat
 
    $cariMedan = array(0,1,2,3,4,5,6,8);
    $cariText = array(0); // papar jika nota ada
    $cariMsic = array(8); // papar input text msic sahaja 
    $namaM = $ubah .'[' . $nama . ']';
        
    // tentukan medan yang ada input
    $input=in_array($f,$cariMedan)? 
    (@in_array($f,$cariMsic)? // tentukan medan yang ada msic
        '<input type="text" name="' . $namaM . '" value="' . $row[$f] . '" size=6>'
        :(@in_array($f,$cariText)? // tentukan medan yang ada input textarea
            '<textarea name="' . $namaM . '" rows=2 cols=23>' . $row[$f] . '</textarea>'
            : // tentukan medan yang bukan input textarea
            '<input type="text" name="' . $namaM . '" value="' . $row[$f] . '" size=30>'
        )
    ):'<label class="papan">' . $row[$f] . '</label>';
    
    return $input;

}

function kira($kiraan)
{
    // pecahan kepada ratus
    return number_format($kiraan,0,'.',',');
} 

function kira2($dulu,$kini)
{
    // buat bandingan dan pecahan kepada ratus
    return @number_format((($kini-$dulu)/$dulu)*100,0,'.',',');
    //@$kiraan=(($kini-$dulu)/$dulu)*100;
}

function huruf($jenis, $papar)
{
    /*
		huruf('BESAR', )
		huruf('kecil', )
		huruf('Depan', )
		huruf('Besar_Depan', )
    */
    
    switch ($jenis) 
    {// mula - pilih $jenis
    case 'BESAR':
        $papar = strtoupper($papar);
        break;
    case 'kecil':
        $papar = strtolower($papar);
        break;
    case 'Depan':
        $papar = ucfrist($papar);
        break;
    case 'Besar_Depan':
        $papar = mb_convert_case($papar, MB_CASE_TITLE);
        break;
    }// tamat - pilih $jenis
    
    return $papar;
}

function bersih($papar) 
{
    # buang ruang kosong (atau aksara lain) dari mula & akhir 
    $papar = trim($papar);
    $papar = str_replace("\t",'| ',$papar);;
    $papar = str_replace("  | ",' | ',$papar);;
    
    return $papar;
}

function bersihGET($papar) 
{
	# bersih untuk $_GET sahaja
	$paparHTML = filter_input(INPUT_GET, $papar, FILTER_SANITIZE_SPECIAL_CHARS);
	$paparURL = filter_input(INPUT_GET, $papar, FILTER_SANITIZE_ENCODED);
	//$papar = filter_var($_GET[$papar], FILTER_SANITIZE_URL);
	
	//echo "You have searched for $paparHTML.\n";
	//echo "<a href='?search=$paparURL'>Search again.</a>";
    
    //return $papar;
    return $paparHTML;
}

function semakDataPOST($semua)
{
			foreach ($_POST as $myTable => $value)
			{	
				if ( in_array($myTable,$semua) ):
					//echo "myTable : $myTable <br>";
					foreach ($value as $kekunci => $papar):
						$ubahMedan = $_POST[$myTable][$kekunci];
						if ($kekunci != $ubahMedan)
						{	/*echo "$myTable - $kekunci = $ubahMedan | berubah :"
							. '$posmen['.$myTable.']['.$ubahMedan.'] '
							. '<= $posmen['.$myTable.']['.$kekunci.']='
							. bersih($papar) . '<br>';*/
							
							$posmen[$myTable][$ubahMedan] = bersih($papar);
							unset($posmen[$myTable][$kekunci]);
						}
						elseif ($papar == null || $papar == '0')
							unset($posmen[$myTable][$kekunci]);
						else 
							$posmen[$myTable][$kekunci] = bersih($papar);
						
					endforeach;
				endif;
			}
	
	return $posmen;
}

function bersihPostUbahKehadiran()
{
	$posmen = array();
	//$posmen[$kira][$kekunci] = bersih($papar);
	$kira = 0;
	$namaBulan = bulanan('nama_bulan', null);
	foreach ($_POST as $key => $value)
	{
		if ( in_array($key,$namaBulan) ):
			foreach ($value as $key => $value2):
				foreach ($value2 as $kekunci => $papar):
					//echo "$kekunci2 : $data , <br>";
					$posmen[$kira][$kekunci] = bersih($papar);
				endforeach;
				$kira++; // ulang sebanyak 364
			endforeach;
 		endif;
	}       
    
	return $posmen;
}

function bersihPostUbah($senarai) 
{
	$posmen = array();
        foreach ($_POST as $key => $value)
        {
            if ( in_array($key,$senarai) )
            {
                $myTable = $key;
                foreach ($value as $kekunci => $papar)
                {
                    if ( in_array($kekunci,array('tarikhx')) )
						$posmen[$myTable]['tarikh'] = null;
					//elseif ( in_array($kekunci,array('email')) )
					//	$posmen[$myTable][$kekunci]=strtolower(bersih($papar)); // huruf kecil
					elseif ( in_array($kekunci,array('nama','gred','seksyen')) )
						$posmen[$myTable][$kekunci]=strtoupper(bersih($papar)); // HURUF BESAR
					//elseif ( in_array($kekunci,array('responden')) )
					//	$posmen[$myTable][$kekunci] = // Huruf Besar Pada Depan Sahaja
					//		mb_convert_case(bersih($papar), MB_CASE_TITLE); 
					else
						$posmen[$myTable][$kekunci] = bersih($papar);
                }
            }
        }       
    
		// set data cuti
		$jenisCuti = array('cuti rehat','cuti umum','cuti sakit (kerajaan)','cuti sakit swasta',
		//'ctr-catatan','cb-catatan',
		'cuti tanpa gaji','cuti haji','pergi taklimat','pergi kursus','pergi mesyuarat');
		foreach ($jenisCuti as $jenis => $cuti):
			if ( !isset($_POST[$myTable][$cuti]) 
				&& $myTable == 'rekod_cuti'):
				$posmen[$myTable][$cuti] = 0;
			endif;
		endforeach;

	return $posmen;
}

function gambar_latarbelakang($lokasi)
{
    $tmpt = //$lokasi . 'bg/bg/';
        //$_SERVER['SERVER_NAME'] . '/private_html/bg/bg/';
        '../../bg/bg/' ;
        
    foreach(scandir($tmpt) as $gambar) 
    {
        if (substr($gambar,-3) == 'jpg') 
            $papar[]=$gambar;
    }

    $bg['papar'] = print_r($papar, 1);
    //$bg['papar'] = '<br>count($papar)='.count($papar);
    $bg['count_tolak_1'] = (count($papar)-1);
    $bg['today'] = rand(0, count($papar)-1);
    $bg['gambar'] = $papar[$bg['today']];
    
    return $bg;
}

function cari_imej($ssm,$strDir)
{
    //require_once ('public/skrip/listfiles2/dir_functions.php');

    if ( isset($ssm) && empty($ssm) )
    {
        $cariImej = null;
    }
    else
    {
        // You can modify this in case you need a different extension
        $strExt = "tif";

        // This is the full match pattern based upon your selections above
        $pattern = "*" . $ssm . "*." . $strExt;
        $cariImej = GetMatchingFiles(GetContents($strDir),$pattern);
    }
    
    //print_r($cariImej);
    return $cariImej;
}
// lisfile2 - mula
function GetMatchingFiles($files, $search) 
{
    // Split to name and filetype
    if(strpos($search,".")) 
    {
        $baseexp=substr($search,0,strpos($search,"."));
        $typeexp=substr($search,strpos($search,".")+1,strlen($search));
    } 
    else 
    { 
        $baseexp=$search;
        $typeexp="";
    } 
        
    // Escape all regexp Characters 
    $baseexp=preg_quote($baseexp); 
    $typeexp=preg_quote($typeexp); 
        
    // Allow ? and *
    $baseexp=str_replace(array("\*","\?"), array(".*","."), $baseexp);
    $typeexp=str_replace(array("\*","\?"), array(".*","."), $typeexp);
           
    // Search for Matches
    $i=0;
    $matches=null; // $matches adalah array()
    foreach($files as $file) 
    {
        $filename=basename($file);
              
        if(strpos($filename,".")) 
        {
            $base=substr($filename,0,strpos($filename,"."));
            $type=substr($filename,strpos($filename,".")+1,strlen($filename));
        } 
        else 
        { 
            $base=$filename;
            $type="";
        }

        if(preg_match("/^".$baseexp."$/i",$base) && preg_match("/^".$typeexp."$/i",$type))  
        {
            $matches[$i]=$file;
            $i++;
        }
    }
    
    return $matches;
    //return $matches;
}

// Returns all Files contained in given dir, including subdirs
function GetContents($dir,$files=array()) 
{
    if(!($res=opendir($dir))) exit("$dir doesn't exist!");
        while(($file=readdir($res))==TRUE) 
        if($file!="." && $file!="..")
            if(is_dir("$dir/$file")) $files=GetContents("$dir/$file",$files);
                else array_push($files,"$dir/$file");
         
    closedir($res);
    return $files;
}
// listfile2 - tamat