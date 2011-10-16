<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * READER CONTROLLER
 * 
 * This file allows you to override the standard FoOlSlide controller to make
 * your own URLs for your theme, and to make sure your theme keeps working
 * even if the FoOlSlide default theme gets modified.
 * 
 * For more information, refer to the support sites linked in your admin panel.
 */
class Reader_Controller
{
	function __construct()
	{
		$this->CI = & get_instance();
	}


	/**
	 * 
	 * Example function that overrides the index page
	 * 
	 */
	public function index($page = 1)
	{
		$this->CI->template->build('latest');
	}


	public function team($stub = NULL)
	{
		$this->CI->template->build('latest');
	}


	public function lista($page = 1)
	{
		$this->CI->template->build('latest');
	}


	public function latest($page = 1)
	{
		$this->CI->template->build('latest');
	}


	public function read($comic, $language = 'en', $volume = 0, $chapter = "", $subchapter = 0, $team = 0, $joint = 0, $pagetext = 'page', $page = 1)
	{
		$this->CI->template->build('latest');
	}


	public function series($stub = NULL)
	{
		$this->CI->template->build('latest');
	}


	public function search()
	{
		$this->CI->template->build('latest');
	}


}