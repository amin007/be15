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

	function carian() 
	{
		//$cariNama = $this->semakData(bersih($_POST['cariNama']));
		$cariNama = $_POST['cariNama'];
		
		echo (is_numeric($cariNama)) ?
			"{$cariNama} adalah newss"
			: "{$cariNama} adalah nama";
		// pergi papar kandungan
		//$this->papar->baca('mobile/cari');
	}
// function yang bukan dicapai secara terus dari URL	
	function semakData($cariNama) 
	{	
		if (is_numeric($cariNama)):
			$carian = $cariNama;
		else:
			$carian = $cariNama;
		endif;
	
		return $carian;
		
	}
	
	function cariDB($cariNama)
	{


	}
}