<?php 
//print_r($this->url);
//print_r($this->bilSemua); 
//print_r($this->halaman); 
//print_r($this->cariApa); 
//print_r($this->carian); 
#
//print_r($this->error); 
//print_r($this->cariBatch); 
//print_r($this->cariID); 
//print_r($this->carian); 


if ($this->carian=='[id:0]')
{
	echo 'data kosong<br>';
}
else
{ // $this->carian=='newss' - mula
	$carian = (!isset($this->cariID)) ? null : $this->cariID;
	$cariBatch = (!isset($this->cariBatch)) ? null : $this->cariBatch;
	$mencari = URL . 'batch/ubahBatchProses/' . $cariBatch;
	$cetakF10 = URL . 'laporan/cetakf10/' . $cariBatch . '/1000';
	$cetakA1 = URL . 'laporan/cetakA1/' . $cariBatch . '/1000';
?>
<h3><a target="_blank" href="<?=$cetakF10?>"> Cetak F10</a>|
<a target="_blank" href="<?=$cetakF10?>">Cetak A1</a></h3>
<h1>Ubah BatchProsesan : <?=$cariBatch?><br>
<small>Nota: <?=$this->error?></small></h1>
<div align="center"><form method="GET" action="<?=$mencari?>" class="form-inline" autocomplete="off">
<div class="form-group"><div class="input-group">
	<input type="text" name="cari" class="form-control" autofocus
	id="inputString" onkeyup="lookup(this.value);" onblur="fill();">
	<span class="input-group-addon">
	<input type="submit" value="Kemaskini">
	</span>
</div></div>
<div class="suggestionsBox" id="suggestions" style="display: none; " >
	<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
</div>
</form></div><br>

<div class="tabbable tabs-top">
	<ul class="nav nav-tabs putih">
<?php 
foreach ($this->cariApa as $jadual => $baris)
{
	if ( count($baris)==0 )
		echo '';
	else
	{	//$mula = ($jadual=='rangka') ? ' class="active"' : '';
	?>
	<li><a href="#<?php echo $jadual ?>" data-toggle="tab">
		<span class="badge badge-success"><?php echo $jadual ?></span>
		<span class="badge"><?php echo count($baris) ?></span>
		</a></li>
<?php
	}
}
?>	</ul>
<div class="tab-content">
<?php 
foreach ($this->cariApa as $myTable => $row)
{
	if ( count($row)==0 )
		echo '';
	else
	{
		$mula2 = ($jadual=='rangka13') ? ' active' : '';
	?>
	<div class="tab-pane<?php echo $mula2?>" id="<?php echo $myTable ?>">
	<?php //echo $this->halaman[$myTable] ?>
<!-- Jadual <?php echo $myTable ?> ########################################### -->	
	<table border="1" class="excel" id="example">
	<?php
	// mula bina jadual
	$printed_headers = false; 
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{	//print the headers once: 	
		if ( !$printed_headers ) 
		{
			?><thead><tr><th><?php echo $myTable ?></th><?php
			foreach ( array_keys($row[$kira]) as $tajuk ) 
			{	// anda mempunyai kunci integer serta kunci rentetan
				// kerana cara PHP mengendalikan tatasusunan.

				if ($tajuk=='newss')  
				{	?><th>Tindakan</th><th><?php echo $tajuk ?></th><?php }
				else
				{	?><th><?php echo $tajuk ?></th><?php }
			}
			?></tr></thead>
	<?php
			$printed_headers = true; 
		} 
	#-----------------------------------------------------------------		 
		//print the data row 
		?><tbody><tr><td><?php echo $kira+1 ?></td><?php
		foreach ( $row[$kira] as $key=>$data ) 
		{	
			paparURL($key, $data);
		} 

		?></tr></tbody>
	<?php
	}
	#-----------------------------------------------------------------
	?>
	</table>
<!-- Jadual <?php echo $myTable ?> ########################################### -->		
	</div>
<?php
	} // if ( count($row)==0 )
}
?>	
</div><!-- class="tab-content" -->
</div><!-- /tabbable -->
<?php } // $this->carian=='newss'' - tamat ?><?php 

function paparURL($key, $data)
{
	if ($key=='newss')
	{
		$id = $data; 
		$k1 = URL . "kawalan/ubah/$id";
		$cb = URL . "batch/buangBatchJohor/$cariBatch/$id";

		?><td><?php
		?><a target="_blank" href="<?php echo $k1 ?>" class="btn btn-primary btn-mini">Ubah</a><?php
		/*?><a href="<?php echo $cb ?>" class="btn btn-danger btn-mini">Kosong</a><?php*/
		?></td><td><?php echo $data ?></td><?php
	}
	elseif ($key=='hantar_prosesan')
	{
		$k1 = URL . "batch/proses/$data";
		$k2 = URL . "laporan/cetakNonA1/$data/1000";
		$k3 = URL . "laporan/cetakA1/$data/1000";
		if ($data == null):
			?><td>&nbsp;</td><?php
		else:?><td><?php
			?><a href="<?php echo $k1 ?>" class="btn btn-primary btn-mini"><?php echo $data ?></a><?php
			?><a target="_blank" href="<?php echo $k2 ?>" class="btn btn-danger btn-mini">Batch Non A1</a><?php
			?><a target="_blank" href="<?php echo $k3 ?>" class="btn btn-success btn-mini">Batch A1</a><?php
			?></td><?php
		endif;
	}
	elseif ($key=='terimaProsesan')
	{
		$k1 = URL . "batch/terima/$data";
		$k2 = URL . "laporan/cetakTerimaProses/$data";
		if ($data == null):
			?><td>&nbsp;</td><?php
		else:?><td><?php
			?><a href="<?php echo $k1 ?>" class="btn btn-primary btn-mini"><?php echo $data ?></a><?php
			?><a target="_blank" href="<?php echo $k2 ?>" class="btn btn-danger btn-mini">cetak</a><?php
			?></td><?php
		endif;
	}
	else
	{
		?><td><?php echo $data ?></td><?php
	}	
	
}
?>