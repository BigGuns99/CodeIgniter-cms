<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of file_helper
 *
 * @author dnunez
 */
class filemanager_helper extends Admin_Controller
{

    public $name = '';
    public $description = '';
    public $alt_attribute = '';
    public $file_set = '';
    public $title = '';
    public $link = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('file_model','directory_model'));
    }

    public function defaultSettings()
    {
        $file = new stdClass();
        $file->name = $this->name;
        $file->description = $this->description;
        $file->alt_attribute = $this->alt_attribute;
        $file->description = $this->description;
        $file->file_set = $this->file_set;
        $file->title = $this->title;
        $file->link = $this->link;
        return $file;
    }

    /**
     * Takes the post array and cleans up the information.
     * @param Post array()
     * @return  array
     */
    
    public function filter($file)
    { 
        $directory = $this->directory_model->get($file['dir_id']);
        $data = array(
            'name' => trim(iconv('ASCII', 'UTF-8//IGNORE', $file['name'])),
            'filename' => $file['file_name'],
            'full_path' => $directory->server_path . '/'. $file['file_name'],
            'url_path' => $directory->url_path . '/'. $file['file_name'],
            'description' => trim(htmlentities(iconv('ASCII', 'UTF-8//IGNORE', $file['description']))),
            'extension' => $file['file_ext'],
            'mimetype' => $file['file_ext'],
            'width' => $file['image_width'],
            'height' => $file['image_height'],
            'filesize' => $file['file_size'],
            'alt_attribute' => trim(iconv('ASCII', 'UTF-8//IGNORE', $file['alt_attribute'])),
            'file_set' => $file['file_set'],
            'author_id' => $file['author_id'],
            'updated_on' => $file['updated_on'],
            'created_on' => $file['created_on'],
            'title' => $file['title'],
            'link' => $file['link'],
            'dir_id' => $file['dir_id']
        );
        return $data;
    }

}