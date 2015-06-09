<?php 
Sesi::init(); // mulakan sesi
//echo '<pre>$_SESSION:', print_r($_SESSION, 1) . '</pre><br>';
/*
$_SESSION:Array
(
    [namaPegawai] => musa
    [levelPegawai] => fe
    [loggedIn] => 1
)
*/
// set pembolehubah
$pengguna = Sesi::get('namaPegawai');
$level = Sesi::get('levelPegawai');
$pegawai = null; //$this->pegawai;

$senaraiPengguna = array('fe','pegawai');
$senaraiPentadbir = array('kawal','admin');
if (in_array(Sesi::get('levelPegawai'), $senaraiPentadbir)) 
	$paras = '' . Sesi::get('levelPegawai');
elseif (in_array($level, $senaraiPengguna)) 
	$paras = '' . Sesi::get('levelPegawai');
else
	$paras = null;
$url = './';
?>
<div class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
		<!-- menu kiri mula -->
		<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<?php for ($iconbar=1; $iconbar < 3; $iconbar++):
		?><span class="icon-bar"></span><?php endfor; ?>
		</button>
		<a class="navbar-brand" href="<?php echo URL ?>"><?php echo Tajuk_Muka_Surat . ':' . $paras ?></a>
		<a class="navbar-brand" href="<?php echo URL ?>ruangtamu/logout">
			<span class="glyphicon glyphicon-off"></span>Keluar</a>
		<a class="navbar-brand" href="<?php echo 'http://' . $_SERVER['SERVER_NAME'] ?>/private_html">
			<span class="glyphicon glyphicon-stats"></span>E-Survey POM</a>	
		</div>
		<!-- menu kiri tamat -->
		<!-- menu kanan mula -->
		<div class="navbar-collapse collapse">
<?php require 'menubar_atas.php'; ?>
			<!-- borang cari kp-->
			<form class="navbar-form navbar-right" action="<?php echo URL ?>cari/idnama" method="POST">
				<div class="input-group">
					<div class="input-group-btn">
						<a class="btn btn-info"><span class="glyphicon glyphicon-search"></span></a>
					</div>
					<input type="text" name="cari" placeholder="Cari Newss / Nama" class="form-control" />
				</div>
			</form>
		</div>
		<!-- menu kanan tamat -->
	</div>
</div>
<!-- letak banner 
<div align="center">
<img src="<?php echo URL ?>../gambar2/banner.png" alt="banner">
</div>-->