<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {

	public function index()
	{
		$this->session->sess_destroy();
		$this->load->view('signin');
	}

	public function auth(){

		$this->form_validation->set_rules('user', 'Username', 'trim|required|min_length[3]|max_length[15]|alpha_numeric');
		$this->form_validation->set_rules('pass', 'Password', 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
        {
            $this->index();	
        }
        else
        {
    		$user = $this->input->post('user', TRUE);
			$pass = $this->input->post('pass', TRUE);

			$this->load->model('auth');
			$response = $this->auth->signin($user, $pass);

			if( $response['status'] )
			{
				$this->session->set_userdata($response["additional"]);
				redirect('admin');
			}
			else
			{
				$this->index();
			}   
        }
	}
}