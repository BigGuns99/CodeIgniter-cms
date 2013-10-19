<?php

/**
 * Article Helper
 * @package	 CMS
 * @subpackage	Article/helpers
 * @category	Helpers
 * @author	Danny Nunez
 */
class article_helper extends Admin_Controller
{

    public $title = '';
    public $url = '';
    public $status = 'DRAFT';
    public $summary = '';
    public $body = '';
    public $keywords = null;
    public $category_id = 0;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('article_model'));
    }

    public function defaultSettings()
    {
        $article = new stdClass();
        $article->title = $this->title;
        $article->subheading = '';
        $article->url = $this->url;
        $article->status = $this->status;
        $article->summary = $this->summary;
        $article->body = $this->body;
        $article->keywords = $this->keywords;
        $article->created = date('Y-m-d H:i:s');
        $article->category_id = $this->category_id;
        $article->author_id = 0;
        $article->weight = 0;
        $article->featured_image = '';
        return $article;
    }

    /**
     * Takes the post array and cleans up the information.
     * @param Post array()
     * @return  array
     */
    public function filter($article)
    {

        $image = new DOMDocument();
        $image->loadHTML(trim(str_replace(array('<p>', '</p>'), '', $article['featured_image'])));
        $imgs = $image->getElementsByTagName('img');
        $featured_image_raw = $imgs->item(0)->getAttribute('src');

        $data = array(
            'created' => trim($article['created']),
            'updated' => trim($article['updated']),
            'created_by' => trim($article['created_by']),
            'summary' => trim(iconv('ASCII', 'UTF-8//IGNORE', $article['summary'])),
            'title' => htmlentities(trim(iconv('ASCII', 'UTF-8//IGNORE', $article['title']))),
            'subheading' => htmlentities(trim(iconv('ASCII', 'UTF-8//IGNORE', $article['subheading']))),
            'url' => $this->clean_url($article['url']),
            'category_id' => trim($article['category_id']),
            'body' => trim($article['body']),
            'keywords' => trim(iconv('ASCII', 'UTF-8//IGNORE', $article['keywords'])),
            'author_id' => trim($article['author_id']),
            'created_on' => trim(strtotime($article['created'])),
            'updated_on' => trim($article['updated_on']),
            'description' => htmlentities(trim(iconv('ASCII', 'UTF-8//IGNORE', $article['description']))),
            'status' => trim($article['status']),
            'weight' => $article['weight'],
            'featured_image' => trim(str_replace(array('<p>', '</p>'), '', $article['featured_image'])),
            'featured_image_raw' => $featured_image_raw
        );
        return $data;
    }

    public function clean_url($url)
    {
        $symbols = array('/', '\\', '\'', '"', ',', '.', '<', '>', '?', ';', ':', '[', ']', '{', '}', '|', '=', '+', '_', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '~', '`');
        for ($i = 0; $i < sizeof($symbols); $i++) {
            $url = str_replace($symbols[$i], '', $url);
        }
        return urlencode(strtolower(str_replace(' ', '-', trim($url))));
    }

    /**
     * A helper to get the author for the article
     * @param type $id
     * @return string
     */
    public function get_author($id)
    {
        $query = $this->db->query("SELECT first_name, last_name , user_image_raw ,google_plus FROM users WHERE id = $id");
        $result = array();
        foreach ($query->result() as $row) {
            $result['author_name'] = $row->first_name . ' ' . $row->last_name;
            $result['author_image'] = $row->user_image_raw;
            $result['google'] = $row->google_plus;
        }
        return $result;
    }

}