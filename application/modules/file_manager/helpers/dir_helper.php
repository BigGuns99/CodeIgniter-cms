<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * A helper for the directory manager. 
 * @package  CMS
 * @author Danny Nunez <dnunez@300Development.com>
 * @copyright (c) 2013, 300 Development
 * @since 0.1
 * 
 */
class dir_helper extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('file_model', 'directory_model'));
    }

    /**
     * Sets default values for the form when adding new directories.
     * @return stdClass
     */
    public function defaultSettings()
    {
        $dir = new stdClass();
        $dir->title = '';
        $dir->dir_name = '';
        $dir->description = '';
        $dir->parent_dir = array('root');
        return $dir;
    }

    /**
     * Takes array data and preps it to be inserted into the database. 
     * @param array $dir
     * @return array
     */
    public function filter($dir)
    {
        $data = array(
            'title' => $dir['title'],
            'dir_name' => $dir['dir_name'],
            'description' => $dir['description'],
            'server_path' => $dir['server_path'],
            'url_path' => $dir['url_path'],
            'parent_dir' => $dir['parent_dir'],
            'author_id' => $dir['author_id'],
        );
        return $data;
    }

    public function update($dir)
    {
        $data = array(
            'title' => $dir['title'],
            'description' => $dir['description'],
        );
        return $data;
    }

    
    
      /**
     * Takes the user submitted directory name makes it into a url friendly name.  
     * @param String user submitted directory name
     * @return String 
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