<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @package file manager
 * @author Danny Nunez <dnunez@300Development.com>
 * @copyright (c) 2013, 300 Development
 * @since 0.1
 * 
 */

class fileset_model extends MY_Model
{

     protected $_table = 'filesets';
    
    
    public function __construct()
    {
        parent::__construct();
    }
    
    
}