<?php

class Articles extends Frontend_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('articles/article_model', 'articles/category_model'));
        $this->load->helper(array('date', 'articles/article', 'form'));
    }

    /**
     * Index
     * List out the latest articles.
     */
    
    public function index()
    {
        
        $articles = $this->article_model->get_latest();
        $article_list = $this->article_model->nav_listFront();
        $archives = $this->article_model->archive();
        $helper = new article_helper;
        $data = array(
            'content' => 'article_list',
            'articles' => $articles['articles'],
            'block_title' => $articles['block_title'],
            'helper' => $helper,
            'article_list' => $article_list['articles'],
            'block_title' => $article_list['block_title'],
            'page_type' => 'home_page',
            'archives' => $archives
        );
        
        $this->load->view($this->config->item('theme_path'), $data);

    }

    /**
     * Lists the posts in a specific category.
     *
     * @param string $slug The slug of the category.
     */
    
    public function category($slug = '')
    {
        
    }

    /**
     * Lists the posts in a specific year/month.
     *
     * @param null|string $year  The year to show the posts for.
     * @param string      $month The month to show the posts for.
     */
    public function archive()
    {
        $month = $this->uri->segment(2);
        $year = $this->uri->segment(3);
        $time = strtotime("$year-$month");
        $start = date('Y-m-01', $time);
        $end = date('Y-m-t', $time);
        $articles = $this->article_model->articles_archive($start, $end);
        $archives = $this->article_model->archive();
        $helper = new article_helper;
        $data = array(
            'content' => 'article_list',
            'articles' => $articles,
            'block_title' => $month . ' ' . $year,
            'helper' => $helper,
            'article_list' => $articles,
            'page_type' => 'archive',
            'archives' => $archives
                
        );
        $this->load->view($this->config->item('theme_path'), $data);
    }

    /**
     * View an article
     * @param string $slug The slug of the article.
     */
    public function view()
    {
        $article_name = $this->uri->segment(3);
        $articles = $this->article_model->get_by('url', $article_name);
        $article_list = $this->article_model->nav_list($articles);
        $archives = $this->article_model->archive();
        $date = getdate(strtotime($articles->created));
        $data = array(
            'content' => 'single_article',
            'article' => $articles,
            'helper' => new article_helper,
            'article_list' => $article_list['articles'],
            'block_title' => $article_list['block_title'],
            'published' => $date['mon'] . '/' . $date['mday'] . '/' . $date['year'],
            'page_type' => 'single_page',
            'archives' => $archives
        );
        $this->load->view($this->config->item('theme_path'), $data);
    }

}