<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Messages_chat extends RestController {

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
                    // 'id_messages' => $this->post('id_messages'),
                    'id_chatroom' => $this->post('id_chatroom'),
                    'id_user' => $this->post('id_user'),
                    'message' => $this->post('message'),
                    'message_type' => $this->post('message_type'),
                    'created_at' => $this->post('created_at'),
                );

        $insert = $this->db->insert('messages', $data);
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
                    // 'id_messages' => $this->put('id_messages'),
                    'id_chatroom' => $this->put('id_chatroom'),
                    'id_user' => $this->put('id_user'),
                    'message' => $this->put('message'),
                    'message_type' => $this->put('message_type'),
                    'updated_at' => $this->put('updated_at'),
                );
        $this->db->where('id', $id);
        $update = $this->db->update('messages', $data);
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
        $delete = $this->db->delete('messages');
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
        
        $jsonData = $this->db->get('messages')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData && $id_user != null)
            {
                 $this->db->select("*");
                $this->db->from("messages");
                $this->db->where('id_user', $id_user);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $id_chatroom != null){
               $this->db->select("*");
                $this->db->from("messages");
                $this->db->where('id_chatroom', $id_chatroom);
                $this->db->order_by("created_at", 'DESC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $created_at!=null){
                $this->db->select("*");
                $this->db->from("messages");
                $this->db->where('created_at', $created_at);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $min != null){
               $this->db->select("*");
                $this->db->from("messages");
                // $this->db->from("messages")->limit(10,0);
                // $this->db->join('users_details', 'users_details.id_user = users.id','left');
                // $this->db->where('role', "Member");
                $this->db->order_by($min, 'ASC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $max != null){
               $this->db->select("*");
                $this->db->from("messages");
                // $this->db->from("messages")->limit(10,0);
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
                $this->db->from("messages");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}