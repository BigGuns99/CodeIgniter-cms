<div class="row clearfix">
    <h3 class="pull-left">Categories</h3>
    <a class=" btn btn-primary pull-right" href="<?php echo base_url('categories/add');?>"><i class="icon-plus"></i> Add Category</a>
</div>
<!-- Updated Message --> 
<?php if(isset($post)):?>
<div class="alert well-large">
      <button type="button" class="close" data-dismiss="alert">&times;</button>  
    <h4> The category was <?php if($status == 'updated'):?> updated. 
    <?php elseif ($status == 'deleted'):?> deleted
        <?php else:?> added. <?php endif;?> </h4>
</div>
<?php endif;?>
<!-- Error Message --> 
<?php if(isset($error)):?>
<div class="alert well-large">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>The was an error when trying to process your request, please try again.</h4>
</div>
<?php endif;?>
<?php if(count($categories) > 0):?>
    <table class="table table-bordered table-striped table-hover">
          <thead>
        <th>Name</th>
        <th>Url</th>
          </thead>
        <tbody>  
        <?php foreach ($categories as $category): ?>     
            <tr>
                <td><?php echo $category->name; ?></td>
                <td><?php echo $category->url; ?></td>
                <td><a href="<?php echo base_url('articles/admin_categories/edit') . '/'. $category->id; ?>" class="btn btn-primary"><i class="icon-edit"></i> Edit</a> | <a href="<?php echo base_url('articles/admin_categories/delete') . '/'. $category->id; ?>" class="btn btn-danger"><i class="icon-trash"></i> Delete</a></td>
            </tr>
        <?php endforeach; ?>    
        </tbody>
    </table>
        <?php else:?> 
<div class="row clearfix">
        <h4>No categories have been created.</h4>
</div>
        <?php endif;?>