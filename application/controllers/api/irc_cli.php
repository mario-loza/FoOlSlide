<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Irc_cli extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		if(!$this->input->is_cli_request())
		{
			show_404();
		}
	}
	
	function config_get()
	{
		
		$result = array();
		$result["config"] = array(
			"runtime" => array(
				"home" => FCPATH.'assets/curves',
				"main" => 'curves.main.Main',
				"javahome" => get_setting('fs_serv_java_path')
			),
			"bot" => array(
				"server" => get_setting('fs_curves_config_bot_server'),
				"port"=> get_setting('fs_curves_config_bot_port'),
				"nickname" => get_setting('fs_curves_config_bot_nickname'),
				"hostname" => get_setting('fs_curves_config_bot_hostname'),
				"servername" => get_setting('fs_curves_config_bot_servername'),
				"realname" => get_setting('fs_curves_config_bot_realname'),
				"nickserv" => get_setting('fs_curves_config_bot_nickserv'),
				"period" => 5000,
				"database" => array(
					"url" => 'jdbc:mysql://' . $this->db->hostname . ':3306/'. $this->db->database .'?useUnicode=true&amp;characterEncoding=UTF8',
					"username" =>$this->db->username,
					"password" => $this->db->password,
					"prefix" => $this->db->dbprefix
				),
				"channels" => unserialize(get_setting('fs_curves_config_bot_channels')),
				"listeners" => array(
					array(
						"classpath" => '',
						"classname" => 'curves.trigger.system.Index',
						"properties" => 'system.xml',
						"critical" => "true"
					),
					array(
						"classpath" => '',
						"classname" => 'curves.trigger.record.Index',
						"critical" => "true"
					),
					array(
						"classpath" => '',
						"classname" => 'curves.trigger.console.Index',
						"critical" => "true"
					),
					array(
						"classpath" => '',
						"classname" => 'curves.trigger.fileserver.Index',
						"properties" => 'fileserver.xml',
						"critical" => "true"
					),
					array(
						"classpath" => '',
						"classname" => 'curves.trigger.query.Index',
						"properties" => 'query.xml',
					),
					array(
						"classpath" => '',
						"classname" => 'curves.trigger.foolrulez.Index',
						"properties" => 'foolrulez.xml',
					),
				),
				"admins" => array(
					//unserialize(get_setting('fs_curves_config_bot_admins'))
				)
			),
		);
		
		$this->response($result, 200); // 200 being the HTTP response code
	}


}