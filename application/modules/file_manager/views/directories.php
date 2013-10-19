<div class="row clearfix view-header">
<a class=" btn btn-primary pull-right" href="<?php echo base_url('directories/add'); ?>"><i class="icon-plus"></i> Add Directory</a>
</div>
<br/>
<div class="row clearfix">
<?php if(count($directories) > 0):?>
    <table class="table table-bordered table-striped table-hover">
          <thead>
        <th>Name</th>
        <th>Server Path</th>
        <th>Url</th>
        <th>Edit</th>
          </thead>
        <tbody>  
        <?php foreach ($directories as $directory): ?>     
            <tr>
                <td><?php echo $directory->title; ?></td>
                <td><?php echo $this->config->item('root_path') . '\\' . $directory->server_path; ?></td>
                <td><?php echo base_url($directory->url_path); ?></td>     
                <td><a href="<?php echo base_url('file_manager/directory_manager/edit'). '/' . $directory->id; ?>" class="btn btn-primary"> <i class="icon-edit"></i> Edit</a></td>
            </tr>
        <?php endforeach; ?>    
        </tbody>
    </table>
        <?php else:?> 
<div class="row clearfix">
        <h4>No directories have been created.</h4>
</div>
        <?php endif;?>
</div>