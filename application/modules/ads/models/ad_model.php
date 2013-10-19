<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Model for all things pages. 
 * 
 * 
 * @package     
 * @author      Danny Nunez
 * @copyright   (c) 2013, 300 Development
 * 
 */

class ad_model extends MY_Model
{

    protected $_table = 'ads';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list()
    {
        $query = $this->db->get('ads_list');
        $ads = array();
        foreach ($query->result() as $row) {
            $ads[] = $row;
        }
        return $ads;
    }
    
     /**
     * @Description - Take a get request array and query the ads table
     * @param Get request Array $get
     * @return Array
     */
    public function adsAjax($get)
    {
        $year = $get['year'];
        $start = strtotime("$year-01-01");
        $end = strtotime("$year-12-31");
        $status = "'" . $get['status'] . "'";
        $author = $get['author'];
        // Build query string for query based on get array. 
        $queryString = "SELECT * FROM ads_list";

        if ($author != 'All') {
            $queryString = $queryString . " WHERE
        author_id = $author ";
        }

        if ($author != 'All') {
            $queryString = $queryString . " AND
        status = $status";
        } else {
            $queryString = $queryString . " WHERE
        status = $status";
        }

        $queryString = $queryString . "AND
        created >= $start AND created <= $end ORDER BY created ASC";

        $query = $this->db->query($queryString);
        $articles = array();
        foreach ($query->result_object() as $article) {
            $articles[] = $article;
        }
        return $articles;
    }
    

}