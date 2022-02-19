<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Jawaban_forum extends RestController {

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
            'id_forum' => $this->post('id_forum'),
            'id_user' => $this->post('id_user'),
            'jawaban' => $this->post('jawaban'),
            'gbr' => $this->post('gbr'),
            'gbr_text' => $this->post('gbr_text'),
            'create_at' => date("Y-m-d H:i:s")
        );

        $insert = $this->db->insert('jawaban_forum', $data);
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
            'id_forum' => $this->put('id_forum'),
            'id_user' => $this->put('id_user'),
            'jawaban' => $this->put('jawaban'),
            'gbr' => $this->put('gbr'),
            'gbr_text' => $this->put('gbr_text'),
            'update_at' => date("Y-m-d H:i:s")
        );
        $this->db->where('id', $id);
        $update = $this->db->update('jawaban_forum', $data);
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
        $delete = $this->db->delete('jawaban_forum');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $number = $this->get( 'number' );
        $jml_jwb = $this->get( 'jml_jwb' );
        
        
        $jsonData = $this->db->get('jawaban_forum')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData)
            {
                // Set the response and exit
                $this->response( $jsonData, 200 );
            }
            else {
                $this->db->select("*");
                $this->db->from("jawaban_forum");
                $this->db->where('id_forum', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
            if($jml_jwb !== null){
                 $this->db->select("*");
                $this->db->from("jawaban_forum");
                $this->db->join('users_details', 'users_details.id_user = jawaban_forum.id_user','left');
                $this->db->join('users', 'users.id = jawaban_forum.id_user','left');
                $this->db->where('id_forum', $id);
                $jsonData = $this->db->get()->num_rows();
                $this->response( $jsonData, 200 );
            }else{
                $this->db->select("*");
                $this->db->from("jawaban_forum")->limit(5,$number);
                $this->db->join('users_details', 'users_details.id_user = jawaban_forum.id_user','left');
                $this->db->join('users', 'users.id = jawaban_forum.id_user','left');
                $this->db->where('id_forum', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
                
        }
    }
}