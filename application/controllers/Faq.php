<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Faq extends RestController {

    function __construct()
    {
        // Construct the parent class
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent::__construct();
         $this->load->database();
    }

    public function index_post()
    {
        date_default_timezone_set('Hongkong');
        $data = array(
                    'id_user' => $this->post('id_user'),
                    'pertanyaan' => $this->post('pertanyaan'),
                    'jawaban' => $this->post('jawaban'),
                    'created_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('faq', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }
    public function index_put()
    {
        // date_default_timezone_set('Hongkong');
        $id = $this->put('id');
        $data_nomor = $this->put('data_nomor');
        $data;
        $update;
        if($data_nomor !== null){
            $data = $data_nomor;
            $update =  $this->db->update_batch('faq', $data, 'id');}
        else{
                $data = array(
                    'id_user' => $this->put('id_user'),
                    'pertanyaan' => $this->put('pertanyaan'),
                    'jawaban' => $this->put('jawaban'),
                    // 'update_at' => date("Y-m-d H:i:s")
                );
                $this->db->where('id', $id);
                $update = $this->db->update('faq', $data);
            }
        
        
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('faq');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        
        $jsonData = $this->db->get('faq')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData)
            {
                // Set the response and exit
                $this->db->select("*");
                $this->db->from("faq");
                // $this->db->join('users','users.id = faq.id_user');
                // $this->db->join('users_details','users_details.id_user = faq.id_user');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
          
        }
        else
        {
                $this->db->select("*");
                $this->db->from("faq");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}