<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Users_api extends RestController {

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
                    'id' => $this->post('id'),
                    'username' => $this->post('username'),
                    'email' => $this->post('email'),
                    'password' => $this->post('password'),
                    'role' => $this->post('role'),
                    'token_chat' => $this->post('token_chat'),
                );

        $insert = $this->db->insert('users', $data);
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
                    'username' => $this->put('username'),
                    'email' => $this->put('email'),
                    'password' => $this->put('password'),
                    'token_chat' => $this->put('token_chat'),
                );
        $this->db->where('id', $id);
        $update = $this->db->update('users', $data);
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
        $delete = $this->db->delete('users');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $email = $this->get( 'email' );
        $newestid = $this->get( 'newestid' );
        $role = $this->get( 'role' );
        $min = $this->get( 'min' );
        $max = $this->get( 'max' );
        $member_count = $this->get( 'member_count' );
        
        $jsonData = $this->db->get('users')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData && $email != null)
            {
                 $this->db->select("*");
                $this->db->from("users");
                $this->db->where('email', $email);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $newestid != null){
                $this->db->select("id");
                $this->db->from("users")->limit(1,1);
                $this->db->order_by('id', 'ASC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $role!=null){
                $this->db->select("*");
                $this->db->from("users")->limit(10,1);
                $this->db->where('role', $role);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $min != null){
               $this->db->select("*");
                $this->db->from("users")->limit(10,0);
                $this->db->join('users_details', 'users_details.id_user = users.id','left');
                $this->db->where('role', "Mentor");
                $this->db->order_by($min, 'ASC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $max != null){
               $this->db->select("*");
                $this->db->from("users")->limit(10,0);
                $this->db->join('users_details', 'users_details.id_user = users.id','left');
                $this->db->where('role', "Mentor");
                $this->db->order_by($max, 'DESC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }if($jsonData && $member_count == "total"){
                $this->db->select("COUNT(role) as total");
                $this->db->from("users");
                 $this->db->join('users_details', 'users_details.id_user = users.id','left');
                 $this->db->where('role', "Member");
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
                $this->db->from("users");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}