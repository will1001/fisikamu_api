<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Video_materi extends RestController {

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
            'nomor' => $this->post('nomor'),
            'judul' => $this->post('judul'),
            'tutor' => $this->post('tutor'),
            'Deskripsi' => $this->post('deskripsi'),
            'poin' => $this->post('poin'),
            'thumbnail' => $this->post('thumbnail'),
            'icon' => $this->post('icon'),
            'link_video' => $this->post('link_video'),
            'id_sub_bab' => $this->post('id_sub_bab'),
            'create_at' => date("Y-m-d H:i:s")
        );

        $insert = $this->db->insert('video_materi', $data);
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
        $data_nomor = $this->put('data_nomor');
        $data;
        $update;
        if($data_nomor !== null){
            $data = $data_nomor;
            $update =  $this->db->update_batch('video_materi', $data, 'id');}
            else{
                $data = array(
                    'nomor' => $this->put('nomor'),
                    'judul' => $this->put('judul'),
                    'tutor' => $this->put('tutor'),
                    'Deskripsi' => $this->put('deskripsi'),
                    'poin' => $this->put('poin'),
                    'thumbnail' => $this->put('thumbnail'),
                    'icon' => $this->put('icon'),
                    'link_video' => $this->put('link_video'),
                    'status' => $this->put('status'),
                    'id_sub_bab' => $this->put('id_sub_bab'),
                    'update_at' => date("Y-m-d H:i:s")
                );
                $this->db->where('id', $id);
                $update = $this->db->update('video_materi', $data);
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
        $delete = $this->db->delete('video_materi');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $id_sub_bab = $this->get( 'id_sub_bab' );
        
        $jsonData = $this->db->get('video_materi')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
             if ( count($jsonData) == 0 )
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No datas were found'
                ], 404 );
            }
            else
            {
               if($id_sub_bab !== null){
                   $this->db->select("*");
                $this->db->from("video_materi");
                $this->db->where('id_sub_bab', $id_sub_bab);
                $this->db->order_by('nomor', 'ASC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
               }else{
                $this->db->select("*,video_materi.id as id,sub_bab_soal.deskripsi as sub_bab,video_materi.nomor as nomor,video_materi.deskripsi as deskripsi");
                $this->db->from("video_materi");
                $this->db->join('sub_bab_soal','sub_bab_soal.id = video_materi.id_sub_bab');
                $this->db->order_by('video_materi.nomor', 'ASC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
               }
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("video_materi");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}