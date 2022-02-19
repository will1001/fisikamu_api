<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Notification extends RestController {

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
                    'id_users' => $this->post('id_users'),
                    'title' => $this->post('title'),
                    'description' => $this->post('description'),
                    'created_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('notification', $data);
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
                    'id_users' => $this->put('id_users'),
                    'title' => $this->put('title'),
                    'description' => $this->put('description'),
                    'status' => $this->put('status'),
                    'send_status' => $this->put('send_status'),
                    'tipe' => $this->put('tipe'),
                    'updated_at' => date("Y-m-d H:i:s")
                );
        $this->db->where('id', $id);
        $update = $this->db->update('notification', $data);
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
        $delete = $this->db->delete('notification');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id_users = $this->get( 'id_users' );
        $status = $this->get( 'status' );
        
        $jsonData = $this->db->get('notification')->result();
        if ( $id_users === null )
        {
            // Check if the datas data store contains datas
             if ( $status != null)
            {
              $this->db->select("*");
                $this->db->from("notification");
                $this->db->where('status', $status);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else
            {
                // Set the response and exit
                $this->db->select("*");
                $this->db->from("notification");
                $this->db->join('users', 'users.id = notification.id_users','left');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
            if ( $status != null)
            {
              $this->db->select("*");
                $this->db->from("notification");
                $this->db->where('id_users',$id_users);
                $this->db->where('status', $status);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }else{
                $this->db->select("*");
                $this->db->from("notification");
                $this->db->where('id_users', $id_users);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
    }
}