<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * The controller that handles CRUD for ads.
 * @package     
 * @author      Danny Nunez <dnunez@300Development.com>
 * @copyright   (c) 2013, 300 Development
 * @since       0.1
 * 
 */
class ads extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('ads/ad_model', 'articles/category_model', 'articles/article_model'));
        $this->load->helper(array('date', 'form', 'ads/ad'));
        //verify the user is logged in
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    /**
     * @Description - Displays the 25 latest articles. 
     * @param String $status - Used for when updating or creating an ad. 
     * @param String $title - Used for when updating or creating an ad. 
     * @ToDo Add a method to get the years based on published dates of adds. Add method in model and add the code to the view. Pass value to the view. 
     */
    public function index($status = null, $title = null)
    {
        if (!$status == null) {
            $data = array(
                'ads' => $this->ad_model->get_list(),
                'status' => $status,
                'title' => $title,
                'authors' => $this->article_model->get_authors(),
                'content' => 'current_ads'
            );
            $this->load->view($this->data['theme_path'], $data);
        } else {
            $data = array(
                'content' => 'current_ads',
                'authors' => $this->article_model->get_authors(),
                'ads' => $this->ad_model->get_list()
            );
            $this->load->view($this->data['theme_path'], $data);
        }
    }

    /**
     * 
     * @param type $error
     * @param type $info
     */
    public function add($error = null, $info = null)
    {
        $settings = new ad_helper;
        $data = array(
            'user' => new Ion_auth,
            'content' => 'form',
            'categories' => $this->category_model->get_all(),
            'ad' => $settings->defaultSettings(),
            'path' => 'ads/ads/insert'
        );
        $this->load->view($this->data['theme_path'], $data);
    }

    /**
     * @param Interger $id - The id of the ad you want to edit. 
     */
    public function edit($id = null)
    {
        $ad_id = $id == null ? $this->uri->segment(4) : $id;
        if ($ad_id == null) {
            $this->index();
        } elseif (!is_numeric($ad_id)) {
            $this->index();
        } else {
            $ad = $this->ad_model->get_by('id', $ad_id);
            if (!$ad == false) {
                $data = array(
                    'user' => new Ion_auth,
                    'path' => 'ads/ads/update',
                    'ad' => $ad,
                    'content' => 'form',
                    'categories' => $this->category_model->get_all(),
                    'method' => 'edit'
                );
                $this->load->view($this->data['theme_path'], $data);
            } else {
                $this->index(null, null, 1);
            }
        }
    }

    /**
     * @Description - Accepts the post values and sanitizes them with codeigniters built 
     * in security filtering. More information can be found at
     *  http://ellislab.com/codeigniter/user-guide/libraries/input.html 
     */
    public function delete()
    {
        $info = $this->input->post('id', true);
        if ($info == null) {
            $this->index();
        } elseif (!is_numeric($info)) {
            $this->index();
        } else {
            $ad = $this->ad_model->delete($info);
            if ($info) {
                $this->index();
            } else {
                $this->edit($info);
            }
        }
    }

    /**
     * @Description - Accepts the post values and sanitizes them with codeigniters built 
     * in security filtering. More information can be found at
     * http://ellislab.com/codeigniter/user-guide/libraries/input.html . The data is than passed to the 
     * ad_helper for futher processing, prior to updating the record. 
     */
    public function update()
    {
        $settings = new ad_helper;
        $info = $this->input->post(NULL, true);
        if ($info == null) {
            $this->index();
        } else {
            $query = $this->ad_model->update($info['id'], $settings->filter($info));
            if ($query) {
                $this->index('updated', $info['title']);
            } else {
                $this->edit('error', $info);
            }
        }
    }

    /**
     * @Description - Accepts the post values and sanitizes them with codeigniters built 
     * in security filtering. More information can be found at
     * http://ellislab.com/codeigniter/user-guide/libraries/input.html . The data is than passed to the 
     * ad_helper for futher processing, prior to inserting the new record. 
     */
    public function insert()
    {
        $info = $this->input->post(NULL, true);
        if ($info == null) {
            $this->index();
        } else {
            $settings = new ad_helper;
            $results = $this->ad_model->insert($settings->filter($info));
            if ($results) {
                $this->index('added', $info['title']);
            } else {
                $this->edit('add', $info);
            }
        }
    }

    
    
    public function adsAjax()
    {
        $get = $this->input->get(NULL, TRUE);      
        $data = array(
            'ads' => $this->ad_model->adsAjax($get), 
            'authors' => $this->article_model->get_authors()
        );
        $this->load->view('ajax', $data);
    }

}