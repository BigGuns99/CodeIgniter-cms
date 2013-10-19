<?php

/**
 *               SiteMap Helper
 * @package	      CMS
 * @subpackage	 sitemap/helpers
 * @category	 Helper
 * @copyright    (c) 2013, 300 Development
 * @since		 Version 0.1
 * @author	     Danny Nunez
 */

class sitemap_helper extends Admin_Controller
{


    public function __construct()
    {
        parent::__construct();
    }


    public function convert($articles) {

        $sitemapXml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        foreach ($articles as $article) {
            $url = $sitemapXml->addChild('url');
            $url->addChild('loc', $article);
            $url->addChild('lastmod', date('Y-m-d'));
            $url->addChild('changefreq', 'weekly');
            $url->addChild('priority', '1.0');
        }

        $location = $this->config->item('root_path') . '\sitemap.xml';
        $sitemapXml->asXML($location);

    }

    public function filtered($query){

            $articles = array();
            foreach ($query as $article) {
            $date = getdate($article->created_on);
            $year = $date['year'];
            $month = strtolower($date['month']);
            $article->url = $year . '/' . $month . '/' . $article->url;
            $articles[] = base_url() . $article->url;
            }

            $this->convert($articles);
            return true; 

    }

}