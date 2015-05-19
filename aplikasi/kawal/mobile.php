<?php

class Mobile extends Kawal 
{

	function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalMasuk();		
	}
	
	function index() 
	{
		// set latarbelakang
		$this->papar->senaraiIP = dpt_ip(); # dapatkan senarai IP yang dibenarkan
		$this->papar->ip = $ip = $_SERVER['REMOTE_ADDR'];
		$this->papar->ip2 = substr($ip,0,10);
		$this->papar->hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$this->papar->server = $_SERVER['SERVER_NAME'];

		// pergi papar kandungan
		$this->papar->baca('index/');
	}
		
}