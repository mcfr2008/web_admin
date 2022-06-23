<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	function get_os() 
	{ 
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$os_platform =   "Bilinmeyen İşletim Sistemi";
		$os_array =   array(
			'/windows nt 10/i'      =>  'Windows 10',
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile'
		);
		foreach ( $os_array as $regex => $value ) { 
			if ( preg_match($regex, $user_agent ) ) {
				$os_platform = $value;
			}
		} 

		return $os_platform;
	}
	
	function get_browser($user_agent)
	{
		if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
		elseif (strpos($user_agent, 'Edge')) return 'Edge';
		elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
		elseif (strpos($user_agent, 'Safari')) return 'Safari';
		elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
		elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';

		return 'Other';
	}

	public function add_activity_log_1_model($data)
	{

		$this->db = $this->load->database('default', TRUE);

		$fld_ip = $_SERVER['REMOTE_ADDR'];
		$fld_comname = gethostbyaddr($_SERVER['REMOTE_ADDR']); 
		$fld_os = $this->get_os();
		$fld_browser = $this->get_browser($_SERVER['HTTP_USER_AGENT']);

		if(isset($data)){

			$this->db->set('fld_activity',$data['fld_activity']);
			$this->db->set('fld_table_name',$data['fld_table_name']);
			$this->db->set('fld_table_id',$data['fld_table_id']);
			$this->db->set('fld_creator_id',$data['fld_creator_id']);
			$this->db->set('fld_creator_date',$data['fld_creator_date']);
			$this->db->set('fld_ip',$fld_ip);
			$this->db->set('fld_comname',$fld_comname);
			$this->db->set('fld_os',$fld_os);
			$this->db->set('fld_browser',$fld_browser);
			$this->db->set('fld_trash',1);
			$this->db->insert('activity_log');
	
			return 'success';

		}else{

			return 'error';
		
		}

	}

}
