<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Model for all things pages. 
 * @package  CMS
 * @author Danny Nunez
 * @copyright (c) 2013, 300 Development
 */

class category_model extends MY_Model
{

    protected $_table = 'categories';
    protected $_users = 'users';
    protected $_articles = 'articles';

    public function __construct()
    {
        parent::__construct();
    }

    public function update($id, $input, $skip_validation = false)
    {
        return parent::update($id, $input);
    }

    /**
     * Verifies if attempting to create a duplicate url. Returns true if no results are returned or the article being update is the same as the query.
     * @param int id of article
     * @param string title
     * @param string url string
     * @return boolean
     */

    public function is_unique($id , $feild, $value)
    {
        $results = parent::get_by($feild, $value);
        if ($results == null) {
            return true;
        } else {
            if ($results->id == $id) {
                return true;
            } else {
                return false;
            }
        }
    }

    
    /**
     * Gets a nice object to create a presentable list of current article for the users. 
     * @return stdClass Object
     */
    
    public function get_article_list()
    {
        $query = $this->db->query("SELECT * FROM 
        $this->_table 
        INNER JOIN $this->_users
        ON ($this->_table.author_id = $this->_users.id)
        INNER JOIN $this->_categories  
        ON ($this->_table.category_id = $this->_categories.id)");
        return $query;
    }



}