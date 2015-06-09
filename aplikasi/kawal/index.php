<?php

class Index extends Kawal 
{

	function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalMasuk();

        $this->papar->js = array(
            //'bootstrap.js',
            'bootstrap-transition.js',
            'bootstrap-alert.js',
            'bootstrap-modal.js',
            'bootstrap-dropdown.js',
            'bootstrap-scrollspy.js',
            'bootstrap-tab.js',
            'bootstrap-tooltip.js',
            'bootstrap-popover.js',
            'bootstrap-button.js',
            'bootstrap-collapse.js',
            'bootstrap-carousel.js',
            'bootstrap-typeahead.js',
            'bootstrap-affix.js',
            'bootstrap-datepicker.js',
            'bootstrap-datepicker.ms.js',
            'bootstrap-editable.min.js',
			'bootstrap-lightbox.js');
        $this->papar->css = array(
            'bootstrap-datepicker.css',
            'bootstrap-editable.css');
		
	}
	
	function index() 
	{
		// set latarbelakang
		$this->papar->gambar=gambar_latarbelakang('../../');
		$this->papar->isi='';
		$this->papar->senaraiIP = dpt_ip(); # dapatkan senarai IP yang dibenarkan
		$this->papar->ip = $ip = $_SERVER['REMOTE_ADDR'];
		$this->papar->ip2 = substr($ip,0,10);
		$this->papar->hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$this->papar->server = $_SERVER['SERVER_NAME'];

		// pergi papar kandungan
		//$this->papar->baca('index/index');
		$this->papar->baca('index/index_mobile');
	}
	
	function login($user) 
	{
		$this->papar->nama=$user; # dapatkan nama pengguna
		$this->papar->IP=dpt_ip(); # dapatkan senarai IP yang dibenarkan
		// pergi papar kandungan
		$this->papar->baca('index/login');
	}

	function login_automatik($user) 
	{
		$this->papar->nama=$user; # dapatkan nama pengguna
		$this->papar->IP=dpt_ip(); # dapatkan senarai IP yang dibenarkan
		// pergi papar kandungan
		$this->papar->baca('index/login_automatik');
	}
	
}