<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Article Helper
 * @package	 CMS
 * @subpackage	Article/helpers
 * @category	Helpers
 * @author	Danny Nunez
 */

class adview_helper extends Frontend_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('ad_model'));
    }

    public function hello(){
        return "Hello from the adview class"; 
    }

}