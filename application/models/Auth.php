<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Model {

	public function signin($username, $password)
        {
            $response = array( 'status' => FALSE, 'message' => 'nothing has been processed' );

            try {
                $this->db->where('user', $username);
                $this->db->where('password', md5($password));

                $result_set = $this->db->get('admin_app');
                $row        = $result_set->row_array();

                if( isset($row) )
                {
                    $response['status']     = TRUE;
                    $response['message']    = "Signin";
                    $response['additional'] = array(
                            'username'		=> $row['user'],
                            'logged_in'     => TRUE
                        );  
                }

                else
                {
                    $response['status']     = FALSE;
                    $response['message']    = "Invalid credentials";  
                }

                return $response; 
            } 
            catch (Exception $e) {

                log_message('error', "[signin][general_error]: " . $e);

                $response['status']     = FALSE;
                $response['message']    = "An error occurred while we try to signin into your account.";  

                return $response;                        
            } 
        	
        }
}