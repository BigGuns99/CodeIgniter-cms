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
class file_model extends MY_Model
{

    protected $_table = 'files';

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

    public function pagination($records, $start)
    {
        $results = array();
        $query = $this->db->query("SELECT *
        FROM $this->_table
        WHERE id BETWEEN $records AND $start 
        ORDER BY id DESC");
        foreach ($query->result() as $row) {
            $results[] = $row;
        }
        return $results;
    }

    public function latest()
    {
        $results = array();
        // MSSQL
        // $query = $this->db->query("SELECT TOP 25 * FROM $this->_table ORDER BY id DESC");
        // MYSQL 
        $this->db->limit(25);
        $this->db->order_by('id','desc');
        $query = $this->db->get($this->_table);
        
        foreach ($query->result() as $row) {
            $results[] = $row;
        }
        return $results;
    }

    public function ajax($dir)
    {
        $id = $dir['directory'];
        $query = $this->db->query("SELECT * FROM $this->_table WHERE dir_id = $id");
        $results = array();
        foreach ($query->result() as $row) {
            $results[] = $row;
        }
        return $results;
    }

}