<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Model for all things pages. 
 * 
 * 
 * @package  CMS
 * @author Danny Nunez
 * @copyright (c) 2013, 300 Development
 * 
 * 
 */
class article_model extends MY_Model
{

    protected $_table = 'articles';
    protected $_users = 'users';
    protected $_categories = 'categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function update($id, $input, $skip_validation = false)
    {
        return parent::update($id, $input);
    }

    public function delete($id)
    {
        return parent::delete($id);
    }

    /**
     * Verifies if attempting to create a duplicate url. Returns true if no results are returned or the article being update is the same as the query.
     * @param int id of article
     * @param string title
     * @param string url string
     * @return boolean
     */
    public function is_unique($id, $feild, $value)
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
     * 
     * @return STD Class Object - An object of users 
     */
    
    
    public function get_authors()
    {
        $this->db->select('id , first_name, last_name');
        return $this->db->get('users');
    }

    
    
    /**
     * This will grab the latest 6 articles and create a url based on the date created. 
     * @return array of objects
     */
    
    
    
    public function nav_list($info)
    {

        // Get all articles with a status of LIVE(Published) within the given month requested
        $dateRange = $this->getDateRange(strtotime($info->created));
        $this->db->select('title , url , created_on');
        $this->db->where(array('created_on >=' => $dateRange['start'], 'created_on <=' => $dateRange['end'], 'status' => 'LIVE'));
        $this->db->order_by('weight');
        $query = $this->db->get($this->_table);
        $articles = array();
        foreach ($query->result_object() as $article) {
            $date = getdate($article->created_on);
            $year = $date['year'];
            $month = strtolower($date['month']);
            $article->url = $year . '/' . $month . '/' . $article->url;
            $articles[] = $article;
        }
        return array('articles' => $articles, 'block_title' => $date['month'] . ' ' . $date['year']);
    }

    
    
    /**
     * This is used to grab the latest 6 articles published ordered by weight. ( Lowest to highest )
     * @return array of objects
     * @todo - Add MYSQL/Active record version of the query
     */
    
    
    public function get_latest()
    {
        $status = "'" . 'LIVE' . "'";
        $query = $this->db->query("SELECT TOP 6
            id , 
            created , 
            updated , 
            author_id , 
            summary , 
            title , 
            url , 
            created_on , 
            featured_image
            FROM articles 
            WHERE status = $status 
            ORDER BY created DESC, weight ASC
");
        $articles = array();
        foreach ($query->result_object() as $article) {
            $date = getdate($article->created_on);
            $year = $date['year'];
            $month = strtolower($date['month']);
            $article->url = $year . '/' . $month . '/' . $article->url;
            $articles[] = $article;
        }

        $date = getdate();
        return array('articles' => $articles, 'block_title' => $date['month'] . ' ' . $date['year']);
    }

    /**
     * 
     * @return Array - A multi-demensional array of the latest 25 articles created. 
     * @todo - Add MYSQL version of the query 
     */
    public function articles()
    {
        /*
        MSSQL VERSION 
        $query = $this->db->query("SELECT TOP 25 * FROM articles_list ORDER by created DESC");
        */ 
        
        /* MYSQL VERSION */
        
        $this->db->limit(25);
        $this->db->order_by('created','desc');
        $query = $this->db->get($this->_table);
        
        $articles = array();
        foreach ($query->result_object() as $article) {
            $date = getdate(strtotime($article->created));
            $year = $date['year'];
            $month = strtolower($date['month']);
            $article->url = $year . '/' . $month . '/' . $article->url;
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * @param1 String - Earliest date 
     * @param2 String - Latest date 
     * @return Array - multi-demensional array of all articles contained within the given range
     */
    public function articles_archive($start, $end)
    {
        $start = strtotime($start);
        $end = strtotime($end);
        $this->db->where(array('created_on >=' => $start, 'created_on <=' => $end));
        $this->db->order_by("created", "DESC");
        $query = $this->db->get($this->_table);
        $articles = array();
        foreach ($query->result_object() as $article) {
            $date = getdate(strtotime($article->created));
            $year = $date['year'];
            $month = strtolower($date['month']);
            $article->url = $year . '/' . $month . '/' . $article->url;
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * This will grab the latest 6 LIVE articles and create a urls based on the date created. 
     * @return array - Used to build a navigation bar
     */
    
    public function nav_listFront()
    {
        // Get the max date for any article that has a statusof LIVE
        $this->db->select_max('created');
        $this->db->where('status', 'LIVE');
        $lastPublishedDate = $this->db->get($this->_table);
        foreach ($lastPublishedDate->result_object() as $value) {
            $time = $value;
        }
        // Get all articles with a status of LIVE(Published) within the given month requested
        $dateRange = $this->getDateRange(strtotime($time->created));
        $this->db->select('title , url , created_on');
        $this->db->where(array('created_on >=' => $dateRange['start'], 'created_on <=' => $dateRange['end'], 'status' => 'LIVE'));
        $this->db->order_by('weight');
        $query = $this->db->get($this->_table);
        // Build array to pass to the controller 
        $articles = array();
        foreach ($query->result_object() as $article) {
            $date = getdate($article->created_on);
            $year = $date['year'];
            $month = strtolower($date['month']);
            $article->url = $year . '/' . $month . '/' . $article->url;
            $articles[] = $article;
        }
        return array('articles' => $articles, 'block_title' => $date['month'] . ' ' . $date['year']);
    }

    /**
     * 
     * @return Array - Archive list of month and count of articles published during the month. 
     */
    public function archive()
    {
        // Get the latest article date that has a status of LIVE 
        $this->db->select_max('created');
        $this->db->where('status', 'LIVE');
        $latest = $this->db->get($this->_table);
        foreach ($latest->result_object() as $value) {
            $endDate = $value;
        }
        // Get the earlist article date that has a status of LIVE 
        $this->db->select_min('created');
        $this->db->where('status', 'LIVE');
        $first = $this->db->get($this->_table);
        foreach ($first->result_object() as $value) {
            $firstDate = $value;
        }

        /**
         * @param1 String - Earliest date 
         * @param2 String - latest date 
         * @return Array - multi-demensional array of all months contained within the given range
         */
        
        function get_months($date1, $date2)
        {
            $time1 = strtotime($date1);
            $time2 = strtotime($date2);
            $my = date('mY', $time2);
            $months = array();
            $f = '';
            
            // This prevents the latest Live articles month from appearing on the archive list. 
            // Only the months prior to the current list will appear. 
            while ($time1 < $time2) {
                //Set $time1 to 15 day ahead of the curently set value
                $time1 = strtotime((date('Y-m-d', $time1) . ' +15days'));
                // Check if the month of time1 is not equal to the value of $f
                if (date('F', $time1) != $f) {
                    //Set $f to the month of time1
                    $f = date('F', $time1);
                    /* If the month and year of $time1 is not equal to $my
                     *  ( The month and year of $time2 ) and $time1(Start Date) is less 
                     * than $time2(End Date) */
                    if (date('mY', $time1) != $my && ($time1 < $time2))
                        $months[] = array(date('Y-m-01', $time1), date('Y-m-t', $time1));
                }
            }
            
            //return multi-demensional array of all months contained in the database
            return $months;
        }

        $myDates = get_months($firstDate->created, $endDate->created);
        $this->db->select('id,created');
        $this->db->order_by('created', 'asc');
        $query = $this->db->get($this->_table);
        $archiveList = array();
        foreach ($myDates as $value) {
            $count = 0;
            foreach ($query->result_array() as $article) {
                if ($article['created'] >= $value[0] AND $article['created'] <= $value[1]) {
                    $count++;
                }
            }
            if ($count > 0) {
                $archiveList[] = array(
                    'year' => date('Y', strtotime($value[0])),
                    'month' => date('F', strtotime($value[0])),
                    'count' => $count
                );
            }
        }

        return array_reverse($archiveList);
    }

    /**
     * @Description - Take a get request array and querry the articles_list view.
     * @param Get request Array $get
     * @return Array
     */
    public function ajax($get)
    {
        $year = $get['year'];
        $start = strtotime("$year-01-01");
        $end = strtotime("$year-12-31");
        $status = "'" . $get['status'] . "'";
        $author = $get['author'];
        // Build query string for query based on get array. 
        $queryString = "SELECT * FROM articles_list";

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
        created_on >= $start AND created_on <= $end ORDER BY created_on ASC";

        $query = $this->db->query($queryString);
        $articles = array();
        foreach ($query->result_object() as $article) {
            $date = getdate(strtotime($article->created));
            $year = $date['year'];
            $month = strtolower($date['month']);
            $article->url = $year . '/' . $month . '/' . $article->url;
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * 
     * @param TIMESTAMP $timeStamp - Expects a time stamp. This is used to determin the 
     * first date and last date of a month. Used for quering all articles in a month.  
     * @return Array - An array containing the first date and last date of a month from the
     *  date gievn as the parameter. 
     */
    public function getDateRange($timeStamp)
    {
        $date = getdate($timeStamp);
        // get total days in a month
        $days = cal_days_in_month(CAL_GREGORIAN, $date['mon'], $date['year']);
        //Set start date and end date for use in SQL query
        if ($date['mon'] < 10) {
            $start = strtotime($date['year'] . '-0' . $date['mon'] . '-' . '01' . '00:00');
            $end = strtotime($date['year'] . '-0' . $date['mon'] . '-' . $days . '23:59');
        } else {
            $start = strtotime($date['year'] . '-' . $date['mon'] . '-' . '01' . '00:00');
            $end = strtotime($date['year'] . '-' . $date['mon'] . '-' . $days . '23:59');
        }
        return array('start' => $start, 'end' => $end);
    }

}