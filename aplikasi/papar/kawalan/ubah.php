<?php 
function cariInput($cariMSIC,$bulan,$kira,$key,$data)
{	# istihar pembolehubah 
	$name = 'name="' . $bulan . '[' . $key . ']"';
	$inputText = $name . ' value="' . $data . '"';
	$tabline = "\n\t\t\t\t\t";
	$tabline2 = "\n\t\t\t\t";
	//if ( in_array($key,array(...)) )
	if(in_array($key,array('nota','nota_prosesan')))
	{#kod utk textarea
		//$data2 = (empty($data) && $key == 'nota') ? "SSM | $data" : $data;
	    $input = '<textarea ' . $name . ' rows="1" cols="20"' . $tabline2 
			   . ' class="form-control">' . $data . '</textarea>'
			   . $tabline2 . '<pre>' . $data . '</pre>'
			   . '';
	}
	elseif(in_array($key,array('respon','respon2','msic08','batchAwal','batchProses','dsk','mko',
		'no','batu','jalan','tmn_kg','dp_baru','ngdbbp_baru')))
	{
	    $input = '<div class="input-group input-group-sm">' . $tabline
			   . '<span class="input-group-addon">' . $data . '</span>' . $tabline
			   . '<input type="text" ' . $inputText 
			   . ' class="form-control input-sm">'
			   . $tabline2 . '</div>'
			   . '';
	}
	elseif(in_array($key,array('fe','tel','fax','responden','email')))
	{
	    $input = '<div class="input-group input-group-sm">' . $tabline
			   . '<span class="input-group-addon">' . $data . '</span>' . $tabline
			   . '<input type="text" ' . $inputText 
			   . ' class="form-control">'
			   . $tabline2 . '</div>'
			   . '';
	}
	elseif(in_array($key,array('hasil','belanja','staf','gaji','aset','stok')))
	{
	    $input = '<div class="input-group input-group-sm">' . $tabline
			   . '<span class="input-group-addon">Nilai MKO</span>'		
			   . '<input type="text" ' . $inputText 
			   . ' class="form-control">' . $tabline
			   . '<span class="input-group-addon">' . kira($data) . '</span>'
			   . $tabline2 . '</div>'
			   . '';
	}
	elseif(in_array($key,array('hasil2','belanja2','staf2','gaji2','aset2','stok2')))
	{
	    $input = '<div class="input-group input-group-sm">' . $tabline
			   . '<span class="input-group-addon">Nilai Muktamad</span>'
			   . '<input type="text" ' . $inputText 
			   . ' class="form-control">' . $tabline
			   . '<span class="input-group-addon">' . kira($data) . '</span>'
			   . $tabline2 . '</div>'
			   . '';
	}
	elseif ( in_array($key,array('lawat','terima','hantar','hantar_prosesan')) )
	{//terima - style="font-family:sans-serif;font-size:10px;"
		$tandaX = 'name="' . $bulan . '[' . $key . 'X]"';
		$dataX = ($key=='hantar_prosesan') ?
			'<input type="checkbox" ' . $tandaX . ' value="x">Utk Prosesan : ' . $data
			: '<input type="checkbox" ' . $tandaX . ' value="x">' . $data;
	    $input = '<div class="input-group input-group-sm">' . $tabline
			   . '<span class="input-group-addon">' . $dataX . '</span>' . $tabline
			   . '<input type="date" ' . $inputText //. 'class="input-date tarikh" readonly>'
			   . $tabline . ' class="form-control date-picker"'
			   . $tabline . ' placeholder="Cth: 2014-05-01"'
			   . $tabline . ' id="date' . $key . '" data-date-format="yyyy/mm/dd"/>'
			   . $tabline2 . '</div>'
			   . '';			   
	}	
	// bukan untuk input type
	elseif ( in_array($key,array('keterangan')) )
	{
		foreach ($cariMSIC as $myTable => $bilang)
		{// mula ulang $bilang
			papar_jadual($bilang, $myTable, $pilih=2);
		}// tamat ulang $bilang
		
		$input = null;
	}
	elseif ( in_array($key,array('alamat_baru')) )
	{
	    $input = '<blockquote>'
		       . '<p class="form-control-static text-info">' . $data . '</p>'
			   //. '<small>Alamat <cite title="Source Title">baru</cite></small>'
			   . '</blockquote>';
	}
	else
	{
	    $input = '<p class="form-control-static text-info">' . $data . '</p>';
	}
	
	// medan yang tak perlu dipaparkan
	$lepas = array('ssm','utama');
	echo (in_array($key,$lepas)) ? '' : "\t$input";
}
/*
echo '<pre>';
echo '$this->kawalan:<br>'; print_r($this->kawalan); 
echo '$this->cariIndustri:<br>'; print_r($this->cariIndustri); 
echo '$this->cari:<br>'; print_r($this->cari); 
echo '</pre>';
//*/

if(isset($this->kawalan['kes'][0]['newss'])):
	// set pembolehubah
	$mencari = URL . 'kawalan/ubahCari/';
	$carian = $this->cari;
	$mesej = '';//$carian .' ada dalam ' . $this->_jadual;
else:	// set pembolehubah
	$mencari = URL . 'kawalan/ubahCari/';
	$carian = null;
	$mesej = '::' . $this->cari .' tiada dalam ' . $this->_jadual;
endif;	
?>
<h1>Ubah Kawalan<?=$mesej?></h1>
<div align="center"><form method="GET" action="<?=$mencari;?>" class="form-inline" autocomplete="off">
<div class="form-group"><div class="input-group">
	<input type="text" name="cari" class="form-control" value="<?=$carian;?>" 
	id="inputString" onkeyup="lookup(this.value);" onblur="fill();">
	<span class="input-group-addon">
	<input type="submit" value="mencari">
	</span>
</div></div>
<div class="suggestionsBox" id="suggestions" style="display: none;">
	<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
</div>
</form></div><br>
<?php 
if ($this->carian=='[tiada id diisi]')
{
    echo 'data kosong<br>';
}
else
{ // $this->carian=='sidap' - mula
    $cari = $this->carian;
    $s1 = '<span class="label">';
    $s2 = '</span>';
    
    // isytihar pembolehubah untuk sistem sms
	if(isset($this->kawalan['kes'][0]['newss'])):
		$newss = $this->kawalan['kes'][0]['newss'];
		$sykt  = urlencode($this->kawalan['kes'][0]['nama']);
		$kawan = urlencode($this->kawalan['kes'][0]['fe']);
		$hantar_sms = URL . 'pengguna/smskes/' . $kawan . '/' . $sykt;
	endif;
?>
	<form method="POST" action="<?php echo URL ?>kawalan/ubahSimpan/<?php echo $this->cari; ?>"
	class="form-horizontal">
	<!-- jadual rangka ########################################### --><?php
	foreach ($this->kawalan as $myTable => $row)
	{// mula ulang $row
		for ($kira=0; $kira < count($row); $kira++)
		{//print the data row // <button type="button" class="btn btn-info">Info</button>
		#----------------------------------------------------------------------------
		foreach ($row[$kira] as $key=>$data): echo "\n\t\t";
			if (in_array($key,array('no','batu','jalan','tmn_kg','dp_baru','respon2')) 
				&& Sesi::get('namaPegawai')!='amin007'):
				echo '';
			else:
		?><div class="form-group">
			<label for="input<?php echo $key 
			?>" class="col-sm-2 control-label"><?php echo $key ?></label>
			<div class="col-sm-6">
			<?php cariInput($this->_cariIndustri,$this->_jadual,$kira, $key, $data);
			echo "\n\t\t\t"; ?></div>
		</div><?php 
			endif;
		endforeach;
		}// final print the data row
		#----------------------------------------------------------------------------
	}// tamat ulang $row
	echo "\n\t\t";
	/*
	echo '<div class="form-group">
			<label for="inputSubmit" class="col-sm-3 control-label">Cth</label>
			<div class="col-sm-6">
				<input type="hidden" name="jadual" value="<?=$this->_jadual?>">
				
			</div>
		</div>';
	echo "\n\t\t";*/
	if(isset($this->kawalan['kes'][0]['newss'])):
	?><div class="form-group">
			<label for="inputSubmit" class="col-sm-3 control-label"><?=$this->_jadual?></label>
			<div class="col-sm-6">
				<input type="hidden" name="jadual" value="<?=$this->_jadual?>">
				<input type="submit" name="Simpan" value="Simpan" class="btn btn-primary btn-large">
			</div>
		</div>	
	</form>
	<hr>

<?php 
endif;
} // $this->carian=='sidap' - tamat ?><?php
// mula untuk kod php+html
function papar_jadual($row, $myTable, $pilih)
{
	if ($pilih == 2 && count($row) != 0)
    {	?><!-- Jadual <?php echo $myTable ?> ########################################### -->
		<span class="label label-success">Jadual <?php echo $myTable ?></span>
        <table class="table table-striped">
        <?php
        $printed_headers = false; ## mula bina jadual
        #-----------------------------------------------------------------
        for ($kira=0; $kira < count($row); $kira++)
        {##print the headers once:  
            if ( !$printed_headers )
            {	?><thead><tr>
        <th>#</th>
        <?php   foreach ( array_keys($row[$kira]) AS $tajuk ):
			?><th><?php echo $tajuk ?></th>
        <?php	endforeach; ?></tr></thead><?php
                $printed_headers = true;
            }#-----------------------------------------------------------------      
            ## print the data row ?>
            <tbody><tr>
            <td><?php echo $kira+1 ?></td>
            <?php foreach ( $row[$kira] as $key=>$data ) : ?>
            <td><?php echo $data ?></td><?php endforeach; ?>
        </tr></tbody>
		<?php
        }#-----------------------------------------------------------------
        ?></table><?php
    } 
}
// tamat untuk kod php+html 
