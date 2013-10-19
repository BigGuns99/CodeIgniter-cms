<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Article Helper
 * @package	        
 * @subpackage	    Article/helpers
 * @category	    Helpers
 * @author	        Danny Nunez
 */

class ad_helper extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('ad_model'));
    }

    public function defaultSettings()
    {
        $ad = new stdClass();
        $ad->title = '';
        $ad->category_id = '';
        $ad->body = '';
        $ad->status = 'DRAFT';
        $ad->featured_image = '';
        return $ad;
    }

    /**
     * Takes the post array and cleans up the information.
     * @param Post array()
     * @return  array
     */
    
    public function filter($info)
    {
        
        $image = new DOMDocument();
        $image->loadHTML(trim(str_replace(array('<p>', '</p>'), '', $info['featured_image'])));
        $imgs = $image->getElementsByTagName('img');
        $featured_image_raw = $imgs->item(0)->getAttribute('src');
        
        $data = array(
            'title' => htmlentities(trim($info['title'])),
            'body' => $info['body'],
            'category_id' => $info['category_id'],
            'author_id' => $info['author_id'],
            'created' => $info['created'],
            'updated' => $info['updated'],
            'updated_by' => $info['updated_by'],
            'status' => $info['status'],
            'featured_image' => trim(str_replace(array('<p>','</p>'), '', $info['featured_image'])),
            'featured_image_raw' => $featured_image_raw
        );

        return $data;
        
    }

    /**
     * A helper to get the author for the article
     * @param type $id
     * @return string
     */
    
    public function get_author($id)
    {
        $query = $this->db->query("SELECT first_name, last_name FROM users WHERE id = $id");
        foreach ($query->result() as $row) {
            $result = $row->first_name . ' ' . $row->last_name;
        }
        return $result;
    }

}