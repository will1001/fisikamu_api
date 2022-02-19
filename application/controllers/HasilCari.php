<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class HasilCari extends RestController {

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
                    'id' => $this->post('id'),
                    'judul' => $this->post('judul'),
                    'tag' => $this->post('tag'),
                    'gbr' => $this->post('gbr'),
                    'gbr_text' => $this->post('gbr_text'),
                    'pertanyaan' => $this->post('pertanyaan'),
                    'id_user' => $this->post('id_user'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('HasilCari', $data);
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
                    'judul' => $this->put('judul'),
                    'tag' => $this->put('tag'),
                    'gbr' => $this->put('gbr'),
                    'gbr_text' => $this->put('gbr_text'),
                    'pertanyaan' => $this->put('pertanyaan'),
                    'id_user' => $this->put('id_user'),
                    'update_at' => date("Y-m-d H:i:s")
                );
        $this->db->where('id', $id);
        $update = $this->db->update('HasilCari', $data);
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
        $delete = $this->db->delete('HasilCari');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $keyword = $this->get( 'keyword' );
        
        
        $jsonData = $this->db->get('forum')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData)
            {
                // Set the response and exit
                $this->db->select("*");
                $this->db->from("forum");
                $this->db->like('judul', $keyword);
                $this->db->or_like('pertanyaan', $keyword);
                $this->db->or_like('gbr_text', $keyword);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else {
                $this->db->select("*");
                $this->db->from("forum");
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("forum");
                $this->db->like('judul', $keyword);
                $this->db->or_like('pertanyaan', $keyword);
                $this->db->or_like('gbr_text', $keyword);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}