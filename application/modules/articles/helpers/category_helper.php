<?php

/**
 * Article Category Helper
 * @package	 CMS
 * @subpackage	Article
 * @category	Helpers
 * @author	Danny Nunez
 */
class category_helper extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('article_model'));
    }

    public function defaultSettings()
    {
        $category = new stdClass();
        $category->name = '';
        $category->url = '';
        return $category;
    }

    /**
     * Takes the post array and cleans up the information. this will be used to send to the insert or update method of MY_MODEL.
     * @param Post array()
     * @return  array
     */
    
    public function filter($category)
    {
        $data = array(
            'name' => htmlentities(trim($category['name'])),
            'url' => $this->clean_url($category['url']),
        );
        return $data;
    }
    
    /**
     * Take a string entered for as a url and strips out all space and un allowed characters. Replace spaces with "-" and then urlencodes the string. 
     * @param string $url
     * @return string
     */
    public function clean_url($url)
    {
        $symbols = array('/', '\\', '\'', '"', ',', '.', '<', '>', '?', ';', ':', '[', ']', '{', '}', '|', '=', '+', '_', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '~', '`');
        for ($i = 0; $i < sizeof($symbols); $i++) {
            $url = str_replace($symbols[$i], '', $url);
        }
        return urlencode(strtolower(str_replace(' ', '-', trim($url))));
    }

}