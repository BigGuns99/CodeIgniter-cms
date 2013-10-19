<?php

/**
 * @package	Sitemap Module
 * @author	Danny Nunez
 * @copyright (c) 2013, 300 Development
 * @since		Version 0.1
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/* All admin controllers must extend the Admin_Controller.  */

class redirect extends Admin_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model(array('articles/article_model', 'articles/category_model', 'sitemap/sitemap_model', 'redirects/redirect_model'));

        $this->load->helper(array('date', 'articles/article', 'form', 'sitemap/sitemap', 'redirects/redirect', 'redirects/webconfig'));

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index($info = null, $message = null)
    {
        $data = array(
            'info' => $info,
            'message' => $message,
            'authors' => $this->article_model->get_authors(),
            'redirects' => $this->redirect_model->get_records(),
            'content' => 'redirects/redirects',
        );
        $this->load->view($this->data['theme_path'], $data);
    }

    public function add()
    {
        $this->output->enable_profiler(TRUE);
        $settings = new redirect_helper();
        $data = array(
            'redirects' => $settings->defaultSettings(),
            'articles' => $this->redirect_model->get_articles(),
            'path' => 'redirects/insert',
            'content' => 'redirects/form',
        );
        $this->load->view($this->data['theme_path'], $data);
    }


   /** 
     *
     * @param Array - the post array from the form submission
     * @return Redirects to $this->index() and provides a messgae. 
     * @todo fix the redirect on error is duplicate redirect to provide a message. Use uri string and route
     * 
     */ 

    public function insert()
    {
        $info = $this->input->post(NULL, TRUE);
        $filtered = new redirect_helper();
        if($this->redirect_model->is_unique($info)){
            $redirect = $this->redirect_model->insert($filtered->filter($info));
        }else{
            redirect('redirects');
        }
        if ($redirect) {
            $this->index($info, 'added');
        } else {
            $authors = $this->article_model->get_authors();
            $data = array(
                'error' => "Sorry, there was an error with adding your redirect. Please try again.",
                'redirects' => $filtered->defaultSettings(),
                'articles' => $this->redirect_model->get_articles(),
                'path' => 'redirects/insert',
                'content' => 'redirects/form',
            );
            $this->load->view($this->data['theme_path'], $data);
        }
    }

     /** 
     *
     * @param string -  grabs the uri string 
     * @return Redirects to $this->index() and provides a messgae. 
     * @todo fix the redirect on error if duplicate to provide a message. 
     * Use uri string and route. Also provide a success message. 
     * 
     */

    public function edit($id = null)
    {
        $redirect_id = $id == null ? $this->security->xss_clean($this->uri->segment(3)) : $id;
        if ($redirect_id == null) {
            $this->index();
        } elseif (!is_numeric($redirect_id)) {
            $this->index();
        } else {
            $redirect = $this->redirect_model->get_by('id', $redirect_id);
            if (!$redirect == false) {
                $data = array(
                    'edit' => true,
                    'redirects' => $redirect,
                    'articles' => $this->redirect_model->get_articles(),
                    'path' => 'redirects/update',
                    'content' => 'redirects/form',
                );
            }
            $this->load->view($this->data['theme_path'], $data);
        }
    }

    public function update()
    {
        $info = $this->input->post(NULL, TRUE);
        $filtered = new redirect_helper();
        $query = $this->redirect_model->update($info['id'], $filtered->filter($info));
        if ($query) {
            $this->index($info, 'updated');
        } else {
            $redirect = $this->redirect_model->get_by('id', $info['id']);
            if (!$redirect == false) {
                $data = array(
                    'edit' => true,
                    'redirects' => $redirect,
                    'articles' => $this->redirect_model->get_articles(),
                    'path' => 'redirects/update',
                    'content' => 'redirects/form',
                );
            }
            $this->load->view($this->data['theme_path'], $data);
        }
    }

    /** 
     *
     * @param string -  grabs the uri string 
     * @return redirect 
     * @todo fix - make this work
     * 
     */

    public function delete()
    {

        /* All methods must pass the page_type and content variables. The pagetype variable will load the desired page type view. The content varable will be the view from the current module to load.
         */

        $this->redirect_model->delete('ID OF RECORD');

        $data = array(
            'content' => 'redirects/redirects',
        );

        $this->load->view($this->data['theme_base'], $data);
    }

    /** 
     * 
     * @description - Gets all records in the redirects table and creates a web.config file. 
     * @param none
     * @return redirects to the $this->index();
     * 
     */

    public function createWebconfig()
    {
        $webConf = new webconfig_helper();
        $paths = $this->redirect_model->get_records();
        $webConf->create($paths);
        redirect('redirects');
    }

}