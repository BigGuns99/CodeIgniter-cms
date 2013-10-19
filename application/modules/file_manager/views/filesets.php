<div class="row clearfix view-header">
<a class=" btn btn-primary pull-right" href="<?php echo base_url('filesets/add'); ?>"><i class="icon-plus"></i> Add Fileset</a>
</div>
<br/>
<div class="row clearfix">
<?php if(count($filesets) > 0):?>
    <table class="table table-bordered table-striped table-hover">
          <thead>
        <th>Name</th>
          </thead>
        <tbody>  
        <?php foreach ($filesets as $fileset): ?>     
            <tr>
                <td><?php echo $fileset->name; ?></td>
                <td><a href="<?php echo base_url('file_manager/filesets/edit'). '/' . $fileset->id; ?>" class="btn btn-primary pull-right"> <i class="icon-edit"></i> Edit</a></td>
            </tr>
        <?php endforeach; ?>    
        </tbody>
    </table>
        <?php else:?> 
<div class="row clearfix">
        <h4>No filesets have been created.</h4>
</div>
        <?php endif;?>
</div>