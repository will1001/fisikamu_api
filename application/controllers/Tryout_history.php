<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Tryout_history extends RestController {

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
                    'id_tryout' => $this->post('id_tryout'),
                    'jawaban' => $this->post('jawaban'),
                    'sisa_waktu' => $this->post('sisa_waktu'),
                    'status' => $this->post('status'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('tryout_history', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }
    public function index_put()
    {
        date_default_timezone_set('Hongkong');
        $id = $this->put('id');
        $data = array(
                    'id_user' => $this->put('id_user'),
                    'id_tryout' => $this->put('id_tryout'),
                    'jawaban' => $this->put('jawaban'),
                    'sisa_waktu' => $this->put('sisa_waktu'),
                    'status' => $this->put('status'),
                    'update_at' => date("Y-m-d H:i:s")
                );
        $this->db->where('id', $id);
        $update = $this->db->update('tryout_history', $data);
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
        $delete = $this->db->delete('tryout_history');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $id_mapel = $this->get( 'id_mapel' );
        
        $jsonData = $this->db->get('tryout_history')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData && $id_mapel == null )
            {
                // Set the response and exit
                $this->response( $jsonData, 200 );
            }
            else {
                $this->db->select("*");
                $this->db->from("tryout_history");
                $this->db->where('id_mapel', $id_mapel);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("tryout_history");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}