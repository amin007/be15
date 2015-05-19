<?php

class Mobile extends Kawal 
{

	function __construct() 
	{
		parent::__construct();
        //Kebenaran::kawalMasuk();		
	}
	
	function index() 
	{
		// pergi papar kandungan
		$this->papar->baca('ruangtamu/mobile');
	}
		
}