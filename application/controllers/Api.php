<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
         $this->load->database();
    }

    public function users_post()
    {
        $deskripsi = $this->post('post');

        // $id_sumber_data = $this->input->post('id_sumber_data');
        // print_r{"lll"};
        $this->response("post", 200 );
        
    }
    public function users_put()
    {
        $deskripsi = $this->post('put');

        // $id_sumber_data = $this->input->post('id_sumber_data');
        // print_r{"lll"};
        $this->response("put", 200 );
        
    }

    public function users_delete()
    {
        $deskripsi = $this->post('delete');

        // $id_sumber_data = $this->input->post('id_sumber_data');
        // print_r{"lll"};
        $this->response("delete", 200 );
        
    }

    public function users_get()
    {
       
        $id = $this->get( 'id' );
        
        $jsonData = $this->db->get('mapel')->result();
        if ( $id === null )
        {
            // Check if the users data store contains users
            if ( $jsonData )
            {
                // Set the response and exit
                $this->response( $jsonData, 200 );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No users were found'
                ], 404 );
            }
        }
        else
        {
            
            if ( array_key_exists( $id, $jsonData ) )
            {
                $this->db->select("*");
                $this->db->from("mapel");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else
            {
                $this->response( [
                    'status' => false,
                    'message' => 'No such user found'
                ], 404 );
            }
        }
    }
}