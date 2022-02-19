<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Users_details extends RestController {

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
        
        // $this->response("halu", 200);
        // $idUsers = $this->db->get('users')->order_by('id', 'DESC');
        $idUsers = $this->post('id_user');
        // $idUsers = $this->get( 'id_soal' );;
            // $this->db->select("*");
            // $this->db->from("users")->limit(10,1);
            // // $this->db->from("users");
            // $this->db->order_by('id', 'DESC');
            // // $this->db->join('kab_kota', 'kab_kota.id = data.id_kab_kota','left');
            // // $this->db->join('sumber_data', 'sumber_data.id = data.id_sumber_data','left');
            // // $this->db->where('id_kategori', $id_kategori);
            // // $this->db->where('YEAR(`tahun`)', $tahun);
            // $jsonData = $this->db->get()->result();
            // $idUSers = $jsonData[0]->id;
        
        // $insert_id = $this->db->insert_id();
        // $this->response($idUsers, 200);
        date_default_timezone_set('Hongkong');
        $data = array(
                    'id_user' => $this->post('id_user'),
                    'harga' => $this->post('harga'),
                    'rating' => $this->post('rating'),
                    'status_online' => $this->post('status_online'),
                    'photo' => $this->post('photo'),
                    'pendidikan' => $this->post('pendidikan'),
                    'alamat' => $this->post('alamat'),
                    'koordinat_alamat' => $this->post('koordinat_alamat'),
                    'created_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('users_details', $data);
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
        // $this->response($id, 200);
        $data = array(
                    'harga' => $this->put('harga'),
                    'rating' => $this->put('rating'),
                    'status_online' => $this->put('status_online'),
                    'photo' => $this->put('photo'),
                    'pendidikan' => $this->put('pendidikan'),
                    'alamat' => $this->put('alamat'),
                    'no_hp' => $this->put('no_hp'),
                    'koordinat_alamat' => $this->put('koordinat_alamat'),
                    'membership' => $this->put('membership'),
                    // 'update_at' => date("Y-m-d H:i:s")
                    'update_at' => $this->put('update_at')
        );
        $this->db->where('id_user', $id);
        $update = $this->db->update('users_details', $data);
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
        $delete = $this->db->delete('users_details');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
        
        $id = $this->get( 'id_user' );
        $id_mapel = $this->get( 'id_mapel' );
        $email = $this->get( 'email' );
        
        $jsonData = $this->db->get('users_details')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData && $id_mapel == null && $email == null)
            {
                // Set the response and exit
                $this->db->select("*");
                $this->db->from("users_details");
                $this->db->join('users', 'users_details.id_user = users.id','left');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            if ( $jsonData && $email != null && $id_mapel == null )
            {
                $this->db->select("*");
                $this->db->from("users_details");
                $this->db->join('users', 'users_details.id_user = users.id','left');
                $this->db->where('email', $email);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else {
                $this->db->select("*");
                $this->db->from("users_details");
                $this->db->where('id_mapel', $id_mapel);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
               $this->db->select("*");
                $this->db->from("users_details");
                $this->db->join('users', 'users_details.id_user = users.id','left');
                $this->db->where('id_user', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}