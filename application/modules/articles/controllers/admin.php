<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 *  
 * @package         
 * @author          Danny Nunez <dnunez@300Development.com>
 * @copyright       (c) 2013, 300 Development
 * @since           0.1
 * 
 */

class admin extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('articles/article_model', 'articles/category_model'));
        $this->load->helper(array('date', 'articles/article', 'form'));
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    /**
     * Index
     * List out the latest articles.
     */
    
    public function index($post = null, $status = null, $error = null)
    {
        $articles = $this->article_model->articles();
        $categories = $this->category_model->get_all();
        $authors = $this->article_model->get_authors();
        $data = array(
        'error' => $error,
        'post' => $post,
        'status' => $status,
        'content' => 'articles',
        'articles' => $articles,
        'categories' => $categories,
        'authors' => $authors
        );
        $this->load->view($this->config->item('admin_theme_path'), $data);
    }

    /**
     * Create new article. Takes the post values and add new record to articles table. If no
     *  post value is recived it loads the add page. It will redirect to the index page of the article dashboard
     * if successfull. If not succesfull it will redirect to the add page. 
     */
    
    public function add()
    {
        $article_info = $this->input->post(NULL, FALSE);
        if ($article_info == null) {
            $settings = new article_helper;
            $categories = $this->category_model->get_all();
            $authors = $this->article_model->get_authors();
            $data = array(
                'path' => 'articles/add',
                'content' => 'form',
                'method' => 'create',
                'article' => $settings->defaultSettings(),
                'categories' => $categories,
                'authors' => $authors
            );
            $this->load->view($this->config->item('admin_theme_path'), $data);
        } else {
            $filtered = new article_helper;
            $articles = $this->article_model->insert($filtered->filter($article_info));
            if ($articles) {
                $this->index($article_info, 'added');
            } else {
                $categories = $this->category_model->get_all();
                $authors = $this->article_model->get_authors();
                $data = array(
                    'error' => "Sorry, there was an error with adding your article. Please try again.",
                    'path' => 'articles/add',
                    'content' => 'form',
                    'method' => 'create',
                    'article' => $article_info,
                    'categories' => $categories,
                    'authors' => $authors
                );
                $this->load->view($this->config->item('admin_theme_path'), $data);
            }
        }
    }

    /**
     * Edit article
     * @param int $id The ID of the article to edit
     */
    
    public function edit($id = null, $status = null)
    {
        $article_id = $id == null ? $this->uri->segment(4) : $id;
        if ($article_id == null) {
            $this->index();
        } elseif (!is_numeric($article_id)) {
            $this->index();
        } else {
            if ($status == null) {
                $articles = $this->article_model->get_by('id', $article_id);
                if (!$articles == false) {
                    $categories = $this->category_model->get_all();
                    $authors = $this->article_model->get_authors();
                    $data = array(
                        'path' => 'articles/admin/update',
                        'content' => 'form',
                        'method' => 'edit',
                        'article' => $articles,
                        'categories' => $categories,
                        'authors' => $authors
                    );
                    $this->load->view($this->config->item('admin_theme_path'), $data);
                } else {
                    $this->index(null, null, 1);
                }
            } else {
                $articles = $this->article_model->get_by('id', $article_id);
                $authors = $this->article_model->get_authors();
                $data = array(
                    'error' => $status,
                    'path' => 'articles/admin/update',
                    'content' => 'form',
                    'method' => 'edit',
                    'article' => $articles,
                    'authors' => $authors
                );
                $this->load->view($this->config->item('admin_theme_path'), $data);
            }
        }
    }

    /**
     * takes the post array and validated info. Once it passes validation it will update record.
     * @param array() 
     */
    
    public function update()
    {
        $filtered = new article_helper;
        $article_info = $this->input->post(NULL,FALSE);
        if ($this->article_model->is_unique($article_info['id'], 'title', $article_info['title']) AND $this->article_model->is_unique($article_info['id'], 'url', $article_info['url'])) {
            $query = $this->article_model->update($article_info['id'], $filtered->filter($article_info));
            if ($query) {
                $this->index($article_info, 'updated');
            } else {
                $this->edit($article_info);
            }
        } else {
            $this->edit($article_info, 'error');
        }
    }

    /**
     * Delete article
     * @param int $id The ID of the article to delete
     */
    public function delete()
    {
        $article_id = $this->uri->segment(4);
        if ($article_id == null) {
            $this->index();
        } elseif (!is_numeric($article_id)) {
            $this->index();
        } else {
            $articles = $this->article_model->delete($article_id);
            if ($articles) {
                $this->index();
            } else {
                $this->index();
            }
        }
    }
    
    public function articlesAjax(){
        $get = $this->input->get(NULL, TRUE);
        $articles = $this->article_model->ajax($get);
        $categories = $this->category_model->get_all();
        $authors = $this->article_model->get_authors();
        $data = array(
            'articles' => $articles,
            'categories' => $categories,
            'authors' => $authors
        );
        $this->load->view('ajax', $data);
    }
    

}