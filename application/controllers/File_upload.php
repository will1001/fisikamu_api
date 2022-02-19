<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class File_upload extends RestController {

    function __construct()
    {
        // Construct the parent class
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header('Content-Type: application/json; charset=utf-8');
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent::__construct();
         $this->load->database();
         $this->load->helper(array('form', 'url'));
    }

    public function index_post()
    {
        $audio = $this->post('audio');
        $name = $this->post('name');
        $name_before = $this->post('name_before');
        $file = $_FILES['file'];
        // $this->response(file_exists(FCPATH . '/uploads/'.$name_before),200);
        
        if(!empty($_FILES['file'])){
            if(file_exists(FCPATH . 'uploads/'.$name_before)){
                unlink(APPPATH . '../uploads/'.$name_before);
            }
       
                
        $this->load->library('upload');
        $config['upload_path'] = './uploads/';
        // $config['allowed_types'] = 'gif|jpg|png|PNG|pcm|mp3|aac|mp4|mkv|avi';
        $config['allowed_types'] = '*';
        $config['max_size']	= 1000000;
        $config['max_width']  = '4096';
        $config['max_height']  = '4096';
        $config['file_name'] = $name;
       
        $this->upload->initialize($config);
     
        
            if ( ! $this->upload->do_upload("file"))
            {
                $error = array('error' => $this->upload->display_errors());
                
                $this->response($error,200);
                // $this->load->view('upload_form', $error);
            }
            else
            {
                // $this->upload->initialize($config);
                $data = array('upload_data' => $this->upload->data());
                

                // $this->load->view('upload_success', $data);
                $this->response($data,200);
            }
        }
    }

    public function index_put()
    {
        $nameimg=explode(",",$this->post('nameimg'));
        $id=$this->post('id');
        $img_name_file_length = count($nameimg);
    //    unlink(APPPATH . '../upload/'.$data_file_sebelumnya->row()->nama_file.'.pdf');
        
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('File_upload');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id_soal = $this->get( 'id_soal' );
        $nama_file = $this->get( 'nama_file' );
        
        $jsonData = $this->db->get('File_upload')->result();
        if ( $id_soal === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData && $id_mapel == null )
            {
                // Set the response and exit
                $this->response( $jsonData, 200 );
            }
            else {
                $this->db->select("*");
                $this->db->from("File_upload");
                $this->db->where('id_soal', $id_soal);
                $this->db->where('nama_dile', $id_soal);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("File_upload");
                $this->db->where('id_soal', $id_soal);
                // $this->db->where('nama_file', $nama_file);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}