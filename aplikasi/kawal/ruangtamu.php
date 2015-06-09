<?php

class Ruangtamu extends Kawal 
{

	function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalKeluar();

		$this->papar->js = array(
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
			'bootstrap-datepicker.ms.js');
		$this->papar->css = array(
			'bootstrap-datepicker.css');

		$this->papar->menuatas = 'ya';
	}
	
	function index() 
	{	
		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->tajuk = 'Ruangtamu';
		// pergi papar kandungan
		$this->papar->baca('ruangtamu/index');
		//$this->papar->baca('mobile/mobile');
	}
	
	function menu() 
	{	
		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->tajuk = 'Menu';
		// pergi papar kandungan
		$this->papar->baca('mobile/mobile');
	}

	function logout()
	{
		//echo '<pre>sebelum:'; print_r($_SESSION) . '</pre>';
		Sesi::destroy();
		//echo '<pre>selepas:'; print_r($_SESSION) . '</pre>';
		//echo 'URL=' . URL;
		//header('location: ' . URL);
		//exit;
	}
	
	function xhrInsert()
	{
		$this->tanya->xhrInsert();
	}
	
	function xhrGetListings()
	{
		$this->tanya->xhrGetListings();
	}
	
	function xhrDeleteListing()
	{
		$this->tanya->xhrDeleteListing();
	}

}