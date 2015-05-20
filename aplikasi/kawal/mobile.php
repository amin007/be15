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
// function yang bukan dicapai secara terus dari URL	
	function carian() 
	{
		$cariNama = $this->semakData(bersih($_POST['cariNama']));
		$cariNama = $this->semakData(bersih($_POST['cariNama']));
		
		$carian = (is_numeric($cariNama)) ?
			"newss:{$cariNama}"	: "nama:{$cariNama}";
		//*/
		echo $carian;
	}

	function semakData($cariNama) 
	{	
		if (is_numeric($cariNama)):
			$carian = str_pad($cariNama, 12, "0", STR_PAD_LEFT);
		else:
			$carian = $cariNama;
		endif;
	
		return $carian;
		
	}
	
	function paparData($cariNama)
	{


	}
}