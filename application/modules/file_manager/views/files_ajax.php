<?php if (count($files) > 0): ?>

    <table class="table table-bordered table-striped table-hover">
        <thead>
        <th>Thumbnail</th>
        <th>Name</th>
        <th>Date Added</th>
    </thead>
    <tbody>  
        <?php foreach ($files as $file): ?>     
            <tr>
                <td><img class="thumbnail-tiny" src="<?php echo base_url($file->url_path); ?>"/></td>
                <td><?php echo $file->name; ?></td>
                <td><?php echo date('m/d/Y', $file->created_on); ?></td>
                <td><a href="<?php echo base_url('file_manager/file_manager/edit') . '/' . $file->id; ?>" class="btn btn-primary"> <i class="icon-edit"></i> Edit</a></td>
            </tr>
        <?php endforeach; ?>    
    </tbody>
    </table>  
<?php else: ?> 
    <div class="row clearfix">
        <h4>No files have been created.</h4>
    </div>
<?php endif; ?>
