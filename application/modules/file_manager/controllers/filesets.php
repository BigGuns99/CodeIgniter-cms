<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The controller that handles CRUD for filesets. 
 * @package          CMS
 * @author          Danny Nunez <dnunez@300Development.com>
 * @copyright       (c) 2013, 300 Development
 * @since           0.1
 * 
 */

class filesets extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('file_manager/file_model', 'file_manager/directory_model', 'users/ion_auth_model', 'file_manager/fileset_model'));
        $this->load->helper(array('date', 'file_manager/fileset', 'file_manager/filemanager', 'form', 'file_manager/dir'));
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index()
    {
        $filesets = $this->fileset_model->get_all();
        $data = array(
            'content' => 'filesets',
            'filesets' => $filesets
        );
        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    public function add($error = null, $filesetInfo = null)
    {

        $settings = new fileset_helper;
        $data = array(
            'path' => 'filesets/insert',
            'content' => 'fileset_form',
            'fileset' => $settings->defaultSettings()
        );

        $this->load->view($this->config->item('admin_theme_path'), $data);

    }

    public function insert($error = null, $filesetInfo = null)
    {
        $filesetInfo = $this->input->post(NULL, true);
            $settings = new fileset_helper;
            $fileset = $this->fileset_model->insert($settings->filter($filesetInfo));
            if ($fileset) {
                $this->index();
            } else {
                $this->add('The fileset already exists, please try again.', $filesetInfo);
            }
    }

    public function edit($id = null, $status = null)
    {
        $fileset_id = $id == null ? $this->uri->segment(4) : $id;
        if ($fileset_id == null) {
            $this->index();
        } elseif (!is_numeric($fileset_id)) {
            $this->index();
        } else {
            $query = $this->fileset_model->get_by('id', $fileset_id);
            $data = array(
                'path' => 'file_manager/filesets/update',
                'content' => 'fileset_form',
                'method' => 'edit',
                'fileset' => $query
            );
            $this->load->view($this->config->item('admin_theme_path'), $data);
        }
    }

    /**
     * @param post array
     */
    
    public function update()
    {
        $fileset = $this->input->post(NULL, true);
        $settings = new fileset_helper;
        $results = $this->fileset_model->update($fileset['id'], $settings->filter($fileset));
        if ($results) {
            $this->index();
        } else {
            $this->edit($fileset);
        }
    }

    public function delete()
    {
        $fileset = $this->input->post(NULL, true);
        if ($fileset == null) {
            $this->index();
        } else {
            $results = $this->fileset_model->delete($fileset['id']);
            if ($results) {
                $this->index();
            } else {
                $this->edit($fileset_id);
            }
        }
    }

}