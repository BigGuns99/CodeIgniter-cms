<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @package	Sitemap Module
 * @author	Danny Nunez
 * @copyright (c) 2013, 300 Development
 * @since		Version 0.1
 */

class redirect_model extends MY_Model
{

    protected $_table = 'redirects';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_records()
    {
        $redirects = array();
        $this->db->order_by('redirectID','DESC');
        $query = $this->db->get('redirects_view');
        foreach ($query->result() as $row) {
            $redirects[] = $row;
        }
        return $redirects;
    }

    public function get_articles()
    {
        $articles = array();
        $query = $this->db->get('articles_list');
        foreach ($query->result_array() as $row) {
            $date = getdate(strtotime($row['created']));
            $row['year'] = $date['year'];
            $row['month'] = $date['month'];
            $articles[] = $row;
        }
        return $articles;
    }

    /** 
     *
     * @param Array - the post array from the form submission
     * @return boolean
     * 
     */

    public function is_unique($info)
    {
        $this->db->where('redirect', $info['redirect']);
        $this->db->from($this->_table);
        $results = $this->db->count_all_results();
        if ($results == 0) {
            return true;
        } else {
            return false;
        }
    }
}