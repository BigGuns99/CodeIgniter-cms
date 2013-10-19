<?php

/**
 * @package		
 * @author		Danny Nunez
 * @copyright   (c) 2013, 300 Development
 * @since		Version 1.0
 * @filesource
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/* All admin controllers must extend the Admin_Controller.  */

class sitemap extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        /* Verify the user was actually logged in */

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $this->load->model(array('articles/article_model'));
        $this->load->helper(array('sitemap/sitemap'));

    }

    public function index()
    {

        $filtered = new sitemap_helper();
        $articles = $this->article_model->get_all();
        $sitemap = $filtered->filtered($articles);
        redirect('/dashboard');

    }

}