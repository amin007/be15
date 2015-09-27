<?php 
//$nav = 'data-toggle="dropdown" class="dropdown-toggle active"';
$nav = 'class="dropdown-toggle" data-toggle="dropdown"';
$url = URL;
$kini = ( !isset($this->kini) ) ? null : $this->kini;
//<ul class="nav navbar-nav navbar-right">
$classUL = 'nav navbar-nav navbar-right';
$icon['User'] = '<span class="glyphicon glyphicon-user"></span>';
$icon['Barcode'] = '<span class="glyphicon glyphicon-barcode"></span>';
$icon['Filter'] = '<span class="glyphicon glyphicon-filter"></span>';
$icon['Stats'] = '<span class="glyphicon glyphicon-stats"></span>';
?>
<ul class="<?php echo $classUL ?>">
<li class="dropdown">
	<a <?php echo $nav ?> href="#"><?=$icon['User']?>Staf
	<b class="caret"></b></a>
	<ul class="dropdown-menu">
	<li><a href="<?php echo $url ?>biodata/ubah">
		<?=$icon['User']?>Biodata <?=$pengguna?>
	</a></li>
	<li><a href="<?php echo $url ?>batch/proses/"><?=$icon['Barcode']?>Batch Prosesan</a></li>
	<li><a href="<?php echo $url ?>batch/awal/"><?=$icon['Barcode']?>Semak Barcode</a></li>
	<li class="divider"></li>
	<li><a href="<?php echo $url ?>catatan/barcode"><?=$icon['Barcode']?>Barcode</a></li>
	<li><a href="<?php echo $url ?>paparan/alamat/500/1"><?=$icon['Barcode']?>Semak Alamat</a></li>
	<li><a href="<?php echo $url ?>ruangtamu/logout">
		<span class="glyphicon glyphicon-off"></span>Keluar
	</a></li>
	</ul>
</li>
<li class="dropdown">
	<a <?php echo $nav ?> href="#">
		<?=$icon['Filter']?>Cari
	<b class="caret"></b></a>
	<ul class="dropdown-menu">
	<!--<li><a href="<?php echo $url ?>cari/syarikat/1"><?=$icon['Filter']?>Carian</a></li>-->
	<li><a href="<?php echo $url ?>cari/tentang/msic/1"><?=$icon['Filter']?>MSIC</a></li>
	<li><a href="<?php echo $url ?>cari/tentang/produk/1"><?=$icon['Filter']?>PRODUK</a></li>
	<li><a href="<?php echo $url ?>cari/tentang/johor/2"><?=$icon['Filter']?>LOKALITI JOHOR</a></li>
	<li><a href="<?php echo $url ?>cari/tentang/malaysia/2"><?=$icon['Filter']?>LOKALITI MALAYSIA</a></li>
	<li><a href="<?php echo $url ?>cari/tentang/prosesan/1"><?=$icon['Filter']?>Prosesan</a></li>
	</ul>
</li>
<li class="dropdown">
	<a <?php echo $nav ?> href="#">
		<?=$icon['Stats']?>Laporan
	<b class="caret"></b></a>
	<ul class="dropdown-menu">
	<li><a href="<?php echo $url ?>laporan/bulanan">Laporan Bulanan</a></li>
	<li class="divider"></li><?php
/*	
	echo "\n\t";
	$bulanan = bulanan('nama_bulan', null);
	foreach ($bulanan as $key => $bln):?>
	<li><a target="_blank" href="<?php echo $url ?>laporan/bulan/<?php echo $bln 
	?>">Bulan <?php echo ($key+1) . ' - ' . (huruf('Besar_Depan',$bln)) ?></a></li><?php
	echo "\n\t";
	endforeach;
//*/?>	
	</ul>
</li>
<li class="dropdown">
	<a <?php echo $nav ?> href="#">
		<span class="glyphicon glyphicon-question-sign"></span>Bantuan
	<b class="caret"></b></a>
	<ul class="dropdown-menu">
	<li><a href="#">Sistem</a></li>
	<li><a href="<?php echo $url ?>forum/perdana">Forum</a></li>
	<li><a href="<?php echo $url ?>mesej/utama">Email</a></li>
	</ul>
</li>
</ul>