<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The controller that handles CRUD for files. 
 * @package         
 * @author          Danny Nunez <dnunez@300Development.com>
 * @copyright       (c) 2013, 300 Development
 * @since           0.1
 */
class uploader extends Admin_Controller
{


     // directory for all user uploaded files
    public $imageRootPath = 'assets/files//';
    // url for all user uploaded files
    public $imageUrlPath = 'assets/files/';

    public function __construct()
    {
        
        parent::__construct();

        $this->load->model(array('file_manager/file_model', 'users/ion_auth_model', 'file_manager/directory_model'));
        $this->load->library(array('form_validation'));
        $this->load->helper(array('date', 'file_manager/filemanager', 'form'));
        
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        
    }

    public function index()
    {
        $data = array(
            'content' => 'form',
        );
        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    public function add()
    {
        $directory = $this->directory_model->get($_POST['dir_id']);
        $uploadPath = $directory->server_path; 
        $upload_data = $this->do_upload($uploadPath);
        $filtered = new filemanager_helper;       
        $results = $this->file_model->insert($filtered->filter(array_merge($_POST, $upload_data['upload_data'])));
        redirect('files');
    }

    public function add_ck($funcNum = null)
    {
        $directory = $this->directory_model->get($_POST['dir_id']);
        $uploadPath = $directory->server_path;
        $upload_data = $this->do_upload($uploadPath);
        $filtered = new filemanager_helper;
        $results = $this->file_model->insert($filtered->filter(array_merge($_POST, $upload_data['upload_data'])));
        if ($results) {
            
            $files = $this->file_model->get_all();
            $data = array(
                'funcNum' => $_POST['funcNum'],
                'content' => 'files_ck',
                'files' => $files
            );
            $this->load->view($this->config->item('admin_theme_path'), $data);
        } else {
            return false;
        }
    }

    function do_upload($uploadPath)
    {
        //$config['upload_path'] = trim($uploadPath, '\\'); This is for IIS only
        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'gif|jpg|png|mpga|mp4|mp3|wav|bmp|gif|jpeg|jpg|jpe|png|tiff|tif|zip|pdf';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_filename'] = 255;
        $config['remove_spaces'] = true;
        $config['xss_clean'] = true;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $data = array('error' => $this->upload->display_errors());
            return $data;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data;
        }
    }

}