<?php

class Mobile extends Kawal 
{

	function __construct() 
	{
		parent::__construct();
        //Kebenaran::kawalMasuk();		
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

}