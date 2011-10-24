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


	function configuration()
	{
		$this->viewdata['function_title'] = _('Configuration');
		$form = array();
		$form[] = array(
			_('Server'),
			array(
				'type' => 'input',
				'name' => 'fs_curves_config_bot_server',
				'preferences' => 'fs_serv',
				'help' => _('The server to connect to, like irc.irchighway.net.')
			)
		);

		$form[] = array(
			_('Port'),
			array(
				'type' => 'input',
				'name' => 'fs_curves_config_bot_port',
				'preferences' => 'fs_serv',
				'help' => _('The port to use to connect. Usually 6667.')
			)
		);

		$channels = @unserialize(get_setting('fs_curves_config_bot_channels'));
		$form[] = array(
			_('Channels'),
			array(
				'type' => 'input',
				'name' => 'fs_curves_config_bot_channels',
				'value' => ($channels) ? $channels : array(),
				'help' => _('The channels your bot will connect to.')
			)
		);

		$form[] = array(
			_('Nickname'),
			array(
				'type' => 'input',
				'name' => 'fs_curves_config_bot_nickname',
				'preferences' => 'fs_serv',
				'help' => _('Your bot\'s nickname.')
			)
		);

		$form[] = array(
			_('Nickserv password'),
			array(
				'type' => 'password',
				'name' => 'fs_curves_config_bot_nickserv',
				'preferences' => 'fs_serv',
				'help' => _('The password to authenticate your nickname.')
			)
		);

		$form[] = array(
			_('Hostname'),
			array(
				'type' => 'input',
				'name' => 'fs_curves_config_bot_hostname',
				'preferences' => 'fs_serv',
				'help' => _('Enter whatever you want.')
			)
		);

		$form[] = array(
			_('Server name'),
			array(
				'type' => 'input',
				'name' => 'fs_curves_config_bot_servername',
				'preferences' => 'fs_serv',
				'help' => _('Enter whatever you want.')
			)
		);

		$form[] = array(
			_('Real name'),
			array(
				'type' => 'input',
				'name' => 'fs_curves_config_bot_realname',
				'preferences' => 'fs_serv',
				'help' => _('Enter whatever you want.')
			)
		);



		if ($post = $this->input->post())
		{
			$this->_submit($post, $form);
			redirect('admin/irc/configuration');
		}

		// create a form
		$table = tabler($form, FALSE, TRUE);
		$data['form_title'] = _('Curves configuration');
		$data['table'] = $table;

		$this->viewdata["main_content_view"] = $this->load->view("admin/irc/configuration.php", $data, TRUE);
		$this->load->view("admin/default.php", $this->viewdata);
	}


	/*
	 * _submit is a private function that submits to the "preferences" table.
	 * entries that don't exist are created. the preferences table could get very large
	 * but it's not really an issue as long as the variables are kept all different.
	 * 
	 * @author Woxxy
	 */
	function _submit($post, $form)
	{
		foreach ($form as $key => $item)
		{

			if (isset($post[$item[1]['name']]))
				$value = $post[$item[1]['name']];
			else
				$value = "";

			$this->db->from('preferences');
			$this->db->where(array('name' => $item[1]['name']));
			if (is_array($value))
			{
				foreach ($value as $key => $val)
				{
					if ($value[$key] == "")
						unset($value[$key]);
				}
				$value = serialize($value);
			}
			if ($this->db->count_all_results() == 1)
			{
				$this->db->update('preferences', array('value' => $value), array('name' => $item[1]['name']));
			}
			else
			{
				$this->db->insert('preferences', array('name' => $item[1]['name'], 'value' => $value));
			}
		}


		load_settings();

		set_notice('notice', _('Updated settings.'));
	}


	function start()
	{
		$exec = '';
		$home = FCPATH . 'assets/curves/Curves';
		$main = 'curves.main.Main';

		$libs = glob($home . '/lib/*.jar');
		foreach ($libs as $key => $lib)
		{
			$libs[$key] = $home . '/lib/' . $lib;
		}

		$classpath = $home . ':' . $home . '/bin:' . implode(':', $libs);

		echo $exec .= get_setting('fs_serv_java_path') . 
				'java -classpath ' . $classpath .
				' ' . $main . ' ' .
				FCPATH. 'index.php ' .
				$home.'/log4j.xml '.
				'& echo $$ > ' . $home.'/curves.pid &';
		
		passthru($exec);
	}


	function stop()
	{
		
	}


}