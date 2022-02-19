<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class gambar_soal extends RestController {

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
       // Folder Path For Ubuntu
    // $folderPath = "/var/www/upload-react/";
    // Folder Path For Window
    // $folderPath = "/";
//    $upload_dir = 'D:\xampp\htdocs\app_bimbel_api/uploads/';
//     // $file = $_FILES['soal'];
//     $avatar_name = $_FILES["soal"]["name"];
//     $avatar_tmp_name = $_FILES["soal"]["tmp_name"];
//     $error = $_FILES["soal"]["error"];
//     $upload_name = $upload_dir.strtolower($avatar_name);
//     $upload_dir = preg_replace('/\s+/', '-', $upload_name);
//     move_uploaded_file($avatar_tmp_name , $upload_name)
    $nameimg=explode(",",$this->post('nameimg'));
    $id=$this->post('id');
    $img_name_file_length = count($nameimg);
            // $this->response($nameimg,200);
    // for ($i=0; $i < $img_name_file_length ; $i++) { 
    //     # code...
    // }

            // $this->response($img_name_file,200);

    // $img_name = $_FILES['file']['name'];
    // $img_link = '/uploads/'.$_FILES['file']['name'];
    // $data = array(
    //                 'nama_file' => $img_name,
    //                 'deskripsi' => $img_link,
    //                 'id_soal' => 1,
    //             );
                
    //             $insert = $this->db->insert('gambar_soal', $data);
        

    // $file_ext = strtolower(end(explode('.',$_FILES['file']['name'])));
    // $file = $folderPath . uniqid() . '.'.$file_ext;
    // move_uploaded_file($file, $folderPath);
   
        // $this->response($upload_dir,200);
//    return json_encode(['status'=>'mantap']);

// $data = array('upload_data' => $this->upload->data());
$dataImg = [];
 for ($i=0; $i < $img_name_file_length ; $i++) {
    //  $a = 'ini = '.(!empty($_FILES['file0'])).(!empty($_FILES['file2'])).(!empty($_FILES['file2'])).(!empty($_FILES['file3'])).(!empty($_FILES['file4']));
    //  $b = 'a';
    //  $this->response($a,200);
     if(!empty($_FILES['file'.$i])){
        $img_name = $nameimg[$i];
        $path = $_FILES['file'.$i]['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $img_link = '/uploads/'.$img_name."_".$id.".".$ext;
        $data = array(
                    'nama_file' => $img_name,
                    'deskripsi' =>  str_replace(' ', '_', $img_link),
                    'id_soal' => $id,
                );
                
                $insert = $this->db->insert('gambar_soal', $data);
                
        $this->load->library('upload');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|PNG';
        $config['max_size']	= 20000;
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['file_name'] = $img_name."_".$id;
        // $config['file_name'] = time().$_FILES['file'.$i]['name'];
        // $config['encrypt_name'] = TRUE;
        // $this->upload->initialize($config);

        // $this->load->library('upload', $config);
        // $this->load->library('upload', $config);/
        $this->upload->initialize($config);
        // $error = array('error' => $this->upload->display_errors());
        //         $this->response($error,200);
        // sdadada
        
            if ( ! $this->upload->do_upload("file".$i))
            {
                $error = array('error' => $this->upload->display_errors());
                
                // $this->response($error,200);
                // $this->load->view('upload_form', $error);
            }
            else
            {
                // $this->upload->initialize($config);
                $data = array('upload_data' => $this->upload->data());
                

                // $this->load->view('upload_success', $data);
                // $this->response(empty($_FILES['file1']),200);
            }
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
        $delete = $this->db->delete('gambar_soal');
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
        
        $jsonData = $this->db->get('gambar_soal')->result();
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
                $this->db->from("gambar_soal");
                $this->db->where('id_soal', $id_soal);
                $this->db->where('nama_dile', $id_soal);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("gambar_soal");
                $this->db->where('id_soal', $id_soal);
                // $this->db->where('nama_file', $nama_file);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}