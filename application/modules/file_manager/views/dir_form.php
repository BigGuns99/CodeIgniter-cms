<?php echo form_open($path, array('class' => 'form-horizontal')); ?>
<?php echo form_hidden('author_id', $this->ion_auth->get_user_id()); ?>

<?php
if (isset($method)) {
    echo form_hidden('id', $directory->id);
}
?>
<!-- USER FRIENDLY TITLE OF THE DIRECTORY --> 
<div class="control-group">
        <?php echo form_label('Title', 'title', array('class' => 'control-label', 'for' => 'title')); ?>
    <div class="controls">
<?php echo form_input(array('name' => 'title', 'id' => 'title', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $directory->title); ?> 
    </div>
</div>
    <?php if (!isset($method)): ?>
    <!-- SEO FRIENDLY TITLE OF THE DIRECTORY --> 
    <div class="control-group">
            <?php echo form_label('Directory name', 'dir_name', array('class' => 'control-label', 'for' => 'dir_name')); ?>
        <div class="controls">
    <?php echo form_input(array('name' => 'dir_name', 'id' => 'dir_name', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $directory->dir_name); ?> 
        </div>
    </div>
    <?php endif; ?>
<!-- DESCRIPTION OF THE DIRECTORY'S PURPOSE  --> 
<div class="control-group">
        <?php echo form_label('Description', 'description', array('class' => 'control-label', 'for' => 'description')); ?> 
    <div class="controls">
<?php echo form_input(array('name' => 'description', 'id' => 'description', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $directory->description); ?> 
    </div>
</div>
    <?php if (!isset($method)): ?>
    <!-- PARENT DIRECTORY --> 
    <div class="control-group">
                <?php echo form_label('Parent Directory', 'parent_dir', array('class' => 'control-label', 'for' => 'parent_dir')); ?>
        <div class="controls">
            <select name="parent_dir">
                <?php foreach ($directories as $parentDir): ?>
                    <?php if($directory->id == ''):?>
                        <option value="0" selected="">Default</option>
                        option>
                    <?php else:?>
                        <option value="0">Default</option>
                    <?php endif;?>
                    <?php if($parentDir->id == $directory->id): ?>
                        <option value="<?php echo $parentDir->id; ?>" selected=""><?php echo $parentDir->title ?></option>
                    <?php else: ?>
                        <option value="<?php echo $parentDir->id; ?>"><?php echo $parentDir->title ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
        <?php endif; ?>
<div class="control-group">
    <div class="controls">
        <?php if (isset($method)): ?>
            <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Update Directory</button>
        <?php else: ?>
            <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Add Directory</button>
<?php endif; ?>
    </div>
</div>
</form>
<?php if (isset($method)): ?>
    <div class='well-large'> 
        <h4>Current Info</h4>
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <th>Title</th>
            <th>Directory Name</th>
            <th>Description</th>
            <th>Server Path</th>.
            <th>Url Path</th>
            </thead>
            <tbody>  
                <tr>
                    <td><?php echo $directory->title; ?></td>
                    <td><?php echo $directory->dir_name; ?></td>
                    <td><?php echo $directory->description; ?></td>
                    <td><?php echo $this->config->item('root_path') . $directory->server_path; ?></td>
                    <td><?php echo base_url($directory->url_path); ?></td>
                </tr>
            </tbody>
        </table>
        <h4>Files</h4>
        <?php
        $map = directory_map($this->config->item('root_path') . '\\' . $directory->server_path, 1);
        if (count($map) > 0):
            ?>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <th>Title</th>
                <th>Type</th>
                </thead>
                <tbody>  
                            <?php foreach ($map as $value): ?> 
                        <tr>
                            <td><?php echo $value; ?></td>
                            <td><?php
                    $info = new SplFileInfo($this->config->item('root_path') . '\\' . $directory->server_path . $value);
                    echo $info->getExtension();
                                ?>
                            </td>
                            <td>
                                <?php if (in_array($info->getExtension(), array('jpg', 'png', 'gif'))): ?> 
                                    <img class="thumbnail-tiny" src="<?php echo base_url($directory->url_path) . '/' . $value; ?>"
            <?php else: ?>
                                         <i class='icon-large icon-file'></i>
                        <?php endif; ?>
                            </td>
                        </tr>  
            <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p> There are currently no files in this directory.<p>
                <?php
                echo form_open('directories/delete', array('class' => 'form-horizontal'));
                echo form_hidden('id', $directory->id); 
                ?>
                 <button type="submit" class="btn btn-danger"><i class="icon-plus"></i> Delete Directory</button>
                 <?php echo form_close();?>
                 
    <?php endif; ?>    
    </div>
<?php endif; ?>