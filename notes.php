<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Note');
		//load the model one time for this controller
	}

	public function index()
	{
		$view_data['notes'] = $this->Note->get_all_notes();
		$this->load->view('notes_view');
	}
}

//end of main controller