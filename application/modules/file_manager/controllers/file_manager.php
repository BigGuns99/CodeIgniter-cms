<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * The controller that handles CRUD for files. 
 * @package         
 * @author          Danny Nunez <dnunez@300Development.com>
 * @copyright       (c) 2013, 300 Development
 * @since           0.1
 * 
 * 
 */

class file_manager extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('file_manager/file_model', 'users/ion_auth_model', 'file_manager/directory_model', 'file_manager/fileset_model'));
        $this->load->helper(array('date', 'file_manager/filemanager', 'form'));
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index($post = null, $status = null, $error = null)
    {
        $files = $this->file_model->latest();
        $data = array(
            'directories' => $this->directory_model->get_all(),
            'error' => $error,
            'post' => $post,
            'status' => $status,
            'content' => 'files',
            'files' => $files,
        );
        $this->load->view($this->config->item('admin_theme_path'), $data);
    }


    /**
     * @param Array $dir_info
     * @return redirect to index method - passed message to be displayed on index page. 
     * @todo Create error logic to redirect user if error when trying to update, edit, insert or delete records. 
     */
    public function delete()
    {
        $file = $this->input->post(NULL, true);
        $query = $this->file_model->get_by('id', $file['id']);
        $this->file_model->delete($file['id']);
        unlink($this->data['root_path'] . $query->full_path);
        return $this->index();
    }

    public function add()
    {
        $settings = new filemanager_helper;
        $data = array(
            'path' => 'uploader/add',
            'content' => 'form',
            'mode' => 'add',
            'directories' => $this->directory_model->get_all(),
            'filesets' => $this->fileset_model->get_all(),
            'file' => $settings->defaultSettings()
        );
        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    /**
     * Edit image
     * @param int $id The ID of the image to edit
     */
    
    public function edit($id = null, $status = null)
    {
        $image_id = $id == null ? $this->uri->segment(4) : $id;
        if ($image_id == null) {
            $this->index();
        } elseif (!is_numeric($image_id)) {
            $this->index();
        } else {
            if ($status == null) {
                $images = $this->file_model->get_by('id', $image_id);
                if (!$images == false) {
                    $data = array(
                        'filesets' => $this->fileset_model->get_all(),
                        'content' => 'form',
                        'method' => 'edit',
                        'file' => $images,
                    );
                    $this->load->view($this->config->item('admin_theme_path'), $data);
                } else {
                    $this->index(null, null, 1);
                }
            } else {
                $this->index();
            }
        }
    }

    /**
     * takes the post array and validated info. Once it passes validation it will update record.
     * @param array() 
     */
    public function update()
    {
        $filtered = new filemanager_helper;
        $image_info = $this->input->post(NULL, true);
        $query = $this->file_model->update($image_info['id'], $filtered->filter($image_info));
        if ($query) {
            $this->index();
        } else {
            $this->index();
        }
    }

    /**
     * used for the ckeditor
     */
    public function ckeditor()
    {
        $files = $this->file_model->latest();
        $data = array(
            'directories' => $this->directory_model->get_all(),
            'content' => 'files_ck',
            'files' => $files
        );
        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    public function create_ck($funcNum = null)
    {
        $funcNum = $funcNum == null ? $this->uri->segment(4) : $funcNum;
        $settings = new filemanager_helper;
        $data = array(
            'funcNum' => $funcNum,
            'content' => 'form_ck',
            'directories' => $this->directory_model->get_all(),
            'filesets' => $this->fileset_model->get_all(),
            'file' => $settings->defaultSettings()
        );
        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    public function filesAjax()
    {

        $get = $this->input->get(NULL, TRUE);

        $files = $this->file_model->ajax($get);

        if (isset($get['fileType'])) {
                $view = 'files_ckajax';
        } else {
            $view = 'files_ajax';
        }

        if (isset($get['funcNum'])) {
            $data = array(
                'directories' => $this->directory_model->get_all(),
                'files' => $files,
                'funcNum' => $get['funcNum']
            );
        } else {
            $data = array(
                'directories' => $this->directory_model->get_all(),
                'files' => $files
            );
        }

        $this->load->view($view, $data);
    }
    

}