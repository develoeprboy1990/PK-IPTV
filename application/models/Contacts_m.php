<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_m extends MY_Model {
	protected $_table_name = 'contacts';
	public $rules = array(
		'qrcode' => array(
			'field' => 'qrcode',
			'label' => 'QR Code',
			'rules' => 'required|trim'
		),
		'text' => array(
			'field' => 'text',
			'label' => 'Text',
			'rules' => ''
		),
		'selection_color' => array(
			'field' => 'selection_color',
			'label' => 'Selection Color',
			'rules' => ''
		),
		'gui_text' => array(
			'field' => 'gui_text',
			'label' => 'GUI Text',
			'rules' => ''
		)
	);

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

}

/* End of file Contacts_m.php */
/* Location: ./application/models/Contacts_m.php */