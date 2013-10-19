<?php

/**
 * Redirect Helper
 * @package	     CMS
 * @subpackage  sitemap/helpers
 * @category	Helper
 * @copyright   (c) 2013, 300 Development
 * @since		Version 0.1
 * @author	    Danny Nunez
 */

class redirect_helper extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function defaultSettings()
    {
        $redirect = new stdClass();
        $redirect->articleID = '';
        $redirect->redirect = '';
        return $redirect;
    }

    /**
     * Takes the post array and cleans up the information.
     * @param Post array()
     * @return  array
     */

    public function filter($info)
    {
        $data = array(
            'articleID' => $info['article_id'],
            'redirect' => $info['redirect']
        );

        return $data;
    }

    public function clean_url($url)
    {
        $symbols = array('\\', '\'', '"', ',', '.', '<', '>', '?', ';', ':', '[', ']', '{', '}', '|', '=', '+', '_', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '~', '`');
        for ($i = 0; $i < sizeof($symbols); $i++) {
            $url = str_replace($symbols[$i], '', $url);
        }
        return urlencode(strtolower(str_replace(' ', '-', trim($url))));
    }
    
    
    

}