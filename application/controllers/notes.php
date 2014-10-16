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
		$this->load->view('notes_view', $view_data);
		// we are passing all notes to the view so we put $view_data above
		// to have each note show, we add foreach on notes_view
	}

	public function add_note()
	{
		$post['status'] = FALSE; // allows us to check if add_note is success or fail
		$data = $this->input->post();
		if ($data) // making sure there is post data
		{
			$note_id = $this->Note->add_note($data);
			if ($note_id)
			{
				$post['status'] = TRUE; 
				$post['id'] = $note_id;
				$post['description'] = $data['description']; 
			} 
		}
		echo json_encode($post);
	}

	public function edit_note()
	{
		$id = $this->input->post('id');
		$description = $this->input->post('description');
		$note_id = $this->Note->update_note($id, $description);
	}

	public function delete_note($note_id) // using the id of note we grabbed
	{
		$post['status'] = FALSE; // if delete_note failed then set to false
		// this avoids deleting note from screen if db delete failed
		if($this->Note->delete_note($note_id))
		{
			$post['status'] = TRUE;
		}
		echo json_encode($post); //echos true if successful or false if failed
	}
}

//end of main controller