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
class fileset_helper extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('file_model', 'directory_model' , 'fileset_model'));
    }
    
        public function defaultSettings()
    {
        $fileset = new stdClass();
        $fileset->name = '';
        return $fileset;
    }
    
        /**
     * Takes array data and preps it to be inserted into the database. 
     * @param array $dir
     * @return array
     */
    public function filter($fileset)
    {
        $data = array(
            'name' => trim($fileset['name']),
        );
        return $data;
    }

}