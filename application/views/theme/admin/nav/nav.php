<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo base_url(); ?>"><?php echo $this->config->item('site_name'); ?></a>
            <div class="btn-group pull-right">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <!-- TODO : add in ion_auth helper function to dynamically find and display the current users name. --> 
                    <i class="icon-user"></i> User
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url('auth/edit_user'); ?>">Profile</a></li>
                    <li><a href="#">Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url('auth/logout'); ?>">Logout</a></li>
                </ul>
            </div>
            <div class="nav-collapse">
                <ul class="nav">
                    <!-- ARTICLES -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Articles
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('articles/admin'); ?>">All</a></li>
                            <li><a href="<?php echo base_url('articles/admin/add'); ?>">Add</a></li>
                        </ul>
                    </li>
                    <!-- MEDIA -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Media
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('files'); ?>">Files</a></li>
                            <li><a href="<?php echo base_url('files/add'); ?>">Add File</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('directories'); ?>">Directories</a></li>
                            <li><a href="<?php echo base_url('directories/add'); ?>">Add Directory</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('filesets'); ?>">Filesets</a></li>
                            <li><a href="<?php echo base_url('filesets/add'); ?>">Add Fileset</a></li>
                        </ul>
                    </li>
                    <!-- CATEGORIES --> 
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Categories
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('categories'); ?>">All</a></li>
                            <li><a href="<?php echo base_url('categories/add'); ?>">Add</a></li>
                        </ul>
                    </li>
                    <!-- SITEMAP/REDIRECTS -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            SiteMap/Redirects
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('redirects'); ?>">Redirects</a></li>
                            <li><a href="<?php echo base_url('redirects/add'); ?>">Add Redirect</a></li>
                            <li><a href="<?php echo base_url('redirects/webconfig'); ?>">Update Web.Config</a>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('sitemap/siteMap'); ?>">Refresh Sitemap</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>