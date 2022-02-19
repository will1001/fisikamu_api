<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Chatroom extends RestController {

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
        
        $data = array(
                    // 'id_chatroom' => $this->post('id_chatroom'),
                    'id' => $this->post('id'),
                    'name' => $this->post('name'),
                    'created_at' => $this->post('created_at'),
                );

        $insert = $this->db->insert('chatroom', $data);
        if ($insert) {
            $this->response($insert, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }
    public function index_put()
    {
        $id = $this->put('id');
        $data = array(
                    'id' => $this->put('id'),
                    'name' => $this->put('name'),
                    'updated_at' => $this->put('created_at'),
                );
        $this->db->where('id', $id);
        $update = $this->db->update('chatroom', $data);
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
        $delete = $this->db->delete('chatroom');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $id_user = $this->get( 'id_user' );
        $id_chatroom = $this->get( 'id_chatroom' );
        $created_at = $this->get( 'created_at' );
        $min = $this->get( 'min' );
        $max = $this->get( 'max' );
        
        $jsonData = $this->db->get('chatroom')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData && $id_user != null)
            {
                 $this->db->select("*");
                $this->db->from("chatroom");
                $this->db->where('id_user', $id_user);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $id_chatroom != null){
               $this->db->select("*");
                $this->db->from("chatroom");
                $this->db->where('id_chatroom', $id_chatroom);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $created_at!=null){
                $this->db->select("*");
                $this->db->from("chatroom");
                $this->db->where('created_at', $created_at);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $min != null){
               $this->db->select("*");
                $this->db->from("chatroom");
                // $this->db->from("chatroom")->limit(10,0);
                // $this->db->join('users_details', 'users_details.id_user = users.id','left');
                // $this->db->where('role', "Member");
                $this->db->order_by($min, 'ASC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $max != null){
               $this->db->select("*");
                $this->db->from("chatroom");
                // $this->db->from("chatroom")->limit(10,0);
                // $this->db->join('users_details', 'users_details.id_user = users.id','left');
                // $this->db->where('role', "Member");
                $this->db->order_by($max, 'DESC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else {
               $this->response( $jsonData, 200 );
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("chatroom");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}