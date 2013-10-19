<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * The model for the upload_directories table. 
 * @package  CMS
 * @author Danny Nunez <dnunez@300Development.com>
 * @copyright (c) 2013, 300 Development
 * @since 0.1
 * 
 */
class directory_model extends MY_Model
{

    protected $_table = 'directories';
    protected $_root_dir = '';

    public function __construct()
    {
        parent::__construct();
    }

    protected function setRootDir()
    {
        $this->_root_dir = '\assets\files\\';
    }

    public function getRootDir()
    {
        $this->setRootDir();
        return $this->_root_dir;
    }
    
    
    
    
    
    

   

}