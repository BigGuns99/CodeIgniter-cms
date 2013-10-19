<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2013, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'pages/pages';
$route['dashboard'] = 'articles/admin';
$route['404_override'] = '';
$route['auth'] = 'users/auth';
$route['auth/(.*)'] = 'users/auth/$1';

/* Article Routing */

// Frontend_Controller
$route['(:num)/(:any)/(:any)'] = 'articles/articles/view/$3';
$route['(archive)/(:any)/(:any)'] = 'articles/articles/archive/$1/$2';

// Articles
$route['articles'] = 'articles/admin';
$route['articles/add'] = 'articles/admin/add';
$route['articles/insert'] = 'articles/admin/insert';
$route['articles/edit/(:num)'] = 'articles/admin/edit/$1';
$route['articles/update'] = 'articles/admin/update';
$route['articles/delete'] = 'articles/admin/delete';

// Categories
$route['categories'] = 'articles/categories';
$route['categories/add'] = 'articles/categories/add';
$route['categories/insert'] = 'articles/categories/insert';
$route['categories/edit/(:num)'] = 'articles/categories/edit/$1';
$route['categories/update'] = 'articles/categories/update';
$route['categories/delete'] = 'articles/categories/delete';

/*Redirect Routing*/
$route['redirects'] = 'redirects/redirect';
$route['redirects/webconfig'] = 'redirects/redirect/createWebconfig';
$route['redirects/add'] = 'redirects/redirect/add';
$route['redirects/insert'] = 'redirects/redirect/insert';
$route['redirects/edit/(:num)'] = 'redirects/redirect/edit/$1';
$route['redirects/update'] = 'redirects/redirect/update';
$route['(redirects)/(:any)'] = 'redirects/redirect/$1';

/* File Manager Routing*/
$route['files'] = 'file_manager/file_manager';
$route['files/add'] = 'file_manager/file_manager/add';
$route['files/insert'] = 'file_manager/file_manager/insert';
$route['files/edit/(:num)'] = 'file_manager/file_manager/edit/$1';
$route['files/update'] = 'file_manager/file_manager/update';
$route['files/delete'] = 'file_manager/file_manager/delete';

/* FileSets Routing*/
$route['filesets'] = 'file_manager/filesets';
$route['filesets/add'] = 'file_manager/filesets/add';
$route['filesets/insert'] = 'file_manager/filesets/insert';
$route['filesets/edit/(:num)'] = 'file_manager/filesets/edit/$1';
$route['filesets/update'] = 'file_manager/filesets/update';
$route['filesets/delete'] = 'file_manager/filesets/delete';
$route['uploader/add'] = 'file_manager/uploader/add';

/* Directory Manager Routing*/
$route['directories'] = 'file_manager/directory_manager';
$route['directories/add'] = 'file_manager/directory_manager/add';
$route['directories/insert'] = 'file_manager/directory_manager/insert';
$route['directories/edit/(:num)'] = 'file_manager/directory_manager/edit/$1';
$route['directories/update'] = 'file_manager/directory_manager/update';
$route['directories/delete'] = 'file_manager/directory_manager/delete';

/*Pages*/

$route['contact'] = 'pages';
$route['about'] = 'pages';

/* End of file routes.php */
/* Location: ./application/config/routes.php */