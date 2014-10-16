<?php

class Note extends CI_Model {

	public function get_all_notes()
	{
		$query = "SELECT id, description FROM posts ORDER BY created_at ASC";
		return $this->db->query($query)->result_array();
	}

	public function add_note($note)
	{
		$query = "INSERT INTO posts (description, created_at, updated_at)
					VALUES (?, NOW(), NOW())";
		$value = array($note['description']);
		$this->db->query($query, $value);
		// Return the ID of the newly created note when adding new entry
		return $this->db->insert_id(); // We are returning the id of entry
	}

	public function update_note($id, $description)
	{
		$query = "UPDATE posts SET description = '{$description}' WHERE id = {$id}";
		$this->db->query($query);
		// Return the ID of the newly created note when adding new entry
		return $this->db->insert_id(); // We are returning the id of entry
	}

	public function delete_note($note_id)
	{
		$query = "DELETE FROM posts WHERE id=?";
		$value = array($note_id);
		return $this->db->query($query, $value);
	}


}