<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The controller that handles CRUD for upload directories. 
 * @package         
 * @author          Danny Nunez <dnunez@300Development.com>
 * @copyright       (c) 2013, 300 Development
 * @since           0.1
 * 
 */

class directory_manager extends Admin_Controller
{


    // directory for all user uploaded files
    public $imageRootPath = 'assets\files\\';
    // url for all user uploaded files
    public $imageUrlPath = 'assets/files/';


    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('file_manager/file_model', 'file_manager/directory_model', 'users/ion_auth_model'));
        $this->load->helper(array('date', 'file_manager/filemanager', 'form', 'file_manager/dir'));
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    /**
     * List all directories. 
     * @param INT $post
     * @param type $status
     * @param type $error
     * 
     */

    public function index($post = null, $status = null, $error = null)
    {
        $directories = $this->directory_model->get_all();
        $data = array(
            'error' => $error,
            'post' => $post,
            'status' => $status,
            'content' => 'directories',
            'directories' => $directories
        );
        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    /**
     * @todo Create error logic to redirect user if error when trying to update, edit, insert or delete records. 
     * @Description: Add new directory is the directory does not already exist. 
     */

    public function add()
    {

            $settings = new dir_helper;
            $directories = $this->directory_model->get_all();
            $data = array(
                'path' => 'directories/insert',
                'content' => 'dir_form',
                'directories' => $directories,
                'directory' => $settings->defaultSettings(),
            );

        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    public function insert()
    {
        $dir_info = $this->input->post(NULL, true);
        if($dir_info == null){
            redirect('directories/add');
        } else {
            $results = $this->addDirectory($dir_info);
            if (!$results) {
                $this->index();
            }
            $filtered = new dir_helper;
            $directory = $this->directory_model->insert($filtered->filter($results));
            if ($directory) {
                $this->index($dir_info, 'added');
            } else {
                $this->index();
            }
        }
    }


    /**
     * Edit Directory details
     * @todo Create error logic to redirect user if error when trying to update, edit, insert or delete records. 
     * @param int $id The ID of the article to edit
     */
    
    public function edit($id = null, $status = null)
    {
        $dir_id = $id == null ? $this->uri->segment(4) : $id;
        if ($dir_id == null) {
            $this->index();
        } elseif (!is_numeric($dir_id)) {
            $this->index();
        } else {
            $query = $this->directory_model->get_by('id', $dir_id);
            $directories = $this->directory_model->get_all();
            $data = array(
                'path' => 'directories/update',
                'content' => 'dir_form',
                'directories' => $directories,
                'method' => 'edit',
                'directory' => $query
            );
            $this->load->view($this->config->item('admin_theme_path'), $data);
        }
    }


    /**
     * Edit directory details
     * @param int $id The ID of the article to edit
     * @todo Add in error control logic 
     * @todo Create error logic to redirect user if error when trying to update, edit, insert or delete records. 
     */
    

    public function update($id = null, $status = null)
    {
        $dir_info = $this->input->post(NULL, true);
        $filtered = new dir_helper;
        $directory = $this->directory_model->update($dir_info['id'], $filtered->update($dir_info));
        if ($directory) {
            $this->index();
        } else {
            $this->edit($dir_info['id']);
        }
    }


    /**
     * Include the parent direcotry and new directory name. The method will check to see if the directory already exists in the parent directory. If it does than it will return false. If the directory does not exist it will create the directory and return true. 
     * @param Array $dir_info
     * @example array('PATH TO PARENT DIRECTORY','NEW DIRECTORY NAME');
     * @return boolean
     * @todo Create error logic to redirect user if error when trying to update, edit, insert or delete records. 
     */


    public function addDirectory($dir_info = null)
    {
        
        $helper = new dir_helper;

        if($dir_info['parent_dir'] != 0){
            $query = $this->directory_model->get_by('id', $dir_info['parent_dir']);
            $dir_info['server_path'] = $query->server_path . $helper->clean_url($dir_info['dir_name']) . '\\';
            $dir_info['url_path'] = $query->url_path . $helper->clean_url($dir_info['dir_name']) . '/';
             $map = directory_map($this->config->item('root_path') . $query->server_path, 1);
        }else{
            // Store the server path from the assests folder foward. You will need to use $this->config->item('root_path') to build the rest of the path in any views. 
            $dir_info['server_path'] = $this->imageRootPath . $helper->clean_url($dir_info['dir_name']);
            // Store the url path from the assests folder foward. You will need to use base_url() to build the rest of the path in any views. 
            $dir_info['url_path'] = $this->imageUrlPath . $helper->clean_url($dir_info['dir_name']);
             $map = directory_map($this->config->item('root_path') . '\\' . $this->imageRootPath , 1);
        }
        if (!in_array($helper->clean_url($dir_info['dir_name']), $map)) {
            if (mkdir($this->config->item('root_path') . '\\' . $dir_info['server_path'])) {
                return $dir_info;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /** Delete directory 
     * @param Array $dir_info
     * @example array('PATH TO PARENT DIRECTORY','NEW DIRECTORY NAME');
     * @return boolean
     * @todo Create error logic to redirect user if error when trying to update, edit, insert or delete records. 
     */

    
    public function delete($dir_info = null)
    {
        $dir_info = $this->input->post(NULL, true);
        $query = $this->directory_model->get_by('id', $dir_info['id']);
        $this->directory_model->delete($dir_info['id']);
        //rmdir($this->config->item('root_path') . $query->server_path);
        return $this->index();     
    }
}