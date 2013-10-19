<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * 
 * @package  CMS
 * @author Danny Nunez <dnunez@300Development.com>
 * @copyright (c) 2013, 300 Development
 * @since 0.1
 * 
 */
class categories extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('articles/category_model', 'articles/article_model'));
        $this->load->helper(array('date', 'articles/category', 'form'));
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    /**
     *
     * Index
     * List out the categories.
     *
     */
    public function index($post = null, $status = null, $error = null) {
        $categories = $this->category_model->get_all();
        $data = array(
            'error' => $error,
            'post' => $post,
            'status' => $status,
            'content' => 'categories',
            'categories' => $categories
        );
        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    /**
     * Create new category. Takes the post values and add new record to categories table. If no
     *  post value is recived it loads the add page. It will redirect to the index page of the
     * article dashboard if successfull. If not succesfull it will redirect to the add page. 
     */
    public function add() {
        
        $category_helper = new category_helper;
        
        $data = array(
            'path' => 'categories/insert',
            'content' => 'category_form',
            'method' => 'create',
            'category' => $category_helper->defaultSettings()
        );

        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    public function insert() {
        $category_helper = new category_helper;
        $category_info = $this->input->post(NULL, TRUE);
        if (!$this->category_model->is_unique(null, 'name', $category_info['name']) OR !$this->category_model->is_unique(null, 'url', $category_info['url'])) {
            $category = new stdClass();
            $category->name = $category_info['name'];
            $category->url = $category_info['url'];
            $data = array(
                'error' => "Either the value you entered for the name or the url already exits. Please try again.",
                'path' => 'categories/insert',
                'content' => 'category_form',
                'method' => 'create',
                'category' => $category
            );
            $this->load->view($this->config->item('admin_theme_path'), $data);
        } else {

            $category = $this->category_model->insert($category_helper->filter($category_info));
            if ($category) {
                $this->index($category_info);
            } else {
                $data = array(
                    'error' => "Sorry, there was an error with adding the new category. Please try again.",
                    'path' => 'categories/insert',
                    'content' => 'form',
                    'method' => 'create',
                    'category' => $category_info
                );
                $this->load->view($this->config->item('admin_theme_path'), $data);
            }
        }
    }

    /**
     * Edit category
     * @param int $id The ID of the category to edit
     */
    public function edit($id = null, $status = null) {
        $category_id = $id == null ? $this->uri->segment(4) : $id;
        if ($category_id == null AND $info = null) {
            $this->index();
        } elseif (!is_numeric($category_id)) {
            $this->index();
        } else {
            if ($status == null) {
                $categories = $this->category_model->get_by('id', $category_id);
                if (!$categories == false) {
                    $data = array(
                        'path' => 'articles/admin_categories/update',
                        'content' => 'category_form',
                        'method' => 'edit',
                        'category' => $categories
                    );
                    $this->load->view($this->config->item('admin_theme_path'), $data);
                } else {
                    $this->index(null, null, 1);
                }
            } else {
                $categories = $this->category_model->get_by('id', $category_id);
                $data = array(
                    'error' => $status,
                    'path' => 'articles/admin_categories/update',
                    'content' => 'category_form',
                    'method' => 'edit',
                    'category' => $categories
                );
                $this->load->view($this->config->item('admin_theme_path'), $data);
            }
        }
    }

    /**
     * delete category
     * @param int $id The ID of the category to delete
     */
    public function delete() {
        $category_id = $this->security->xss_clean($this->uri->segment(4));
        if ($category_id == null) {
            $this->index();
        } elseif (!is_numeric($category_id)) {
            $this->index();
        } else {
            $results = $this->category_model->delete($category_id);
            if ($results == true) {
                $this->index('Success!', 'deleted');
            } else {
                /**
                 * @todo Add error logic
                 */
                $this->index();
            }
        }
    }

    /**
     * takes the post array and validated info. Once it passes validation it will update record.
     * @param array() 
     */
    public function update() {
        $filtered = new category_helper;
        $category_info = $this->input->post(NULL, true);
        if ($this->category_model->is_unique($category_info['id'], 'name', $category_info['name']) AND $this->category_model->is_unique($category_info['id'], 'url', $category_info['url'])) {
            $query = $this->category_model->update($category_info['id'], $filtered->filter($category_info));
            if ($query) {
                $this->index($category_info, 'updated');
            } else {
                $this->edit($category_info);
            }
        } else {
            $categories = $this->category_model->get_by('id', $category_info['id']);
            $data = array(
                'error' => 'Either the value you entered for the name or the url already exits. Please try again.',
                'path' => 'articles/admin_categories/update',
                'content' => 'category_form',
                'method' => 'edit',
                'category' => $categories
            );
            $this->load->view($this->config->item('admin_theme_path'), $data);
        }
    }

}
