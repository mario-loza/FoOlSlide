<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Irc extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();

		// preferences are settable only by admins!
		$this->tank_auth->is_admin() or redirect('admin');

		// title on top
		$this->viewdata['controller_title'] = '<a href="' . site_url("admin/irc/general") . '">' . _('IRC bot "Curves"') . '</a>';
	}

	function general()
	{
		$data = array();
		$this->viewdata['function_title'] = _('General');
		$this->viewdata["main_content_view"] = $this->load->view("admin/irc/general.php", $data, TRUE);
		$this->load->view("admin/default.php", $this->viewdata);
	}
	
	function start()
	{
		$exec = "";
		$exec .= get_setting('fs_serv_java_path') . ' -classpath ' . FCPATH . 'assets/curves/Curves';
	}
	
	function stop()
	{
		
	}
}