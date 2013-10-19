<?php

echo form_open_multipart($path, array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));

if (isset($method)) {
    echo form_hidden('id', $file->id);
} else {
    echo form_hidden('created_on', now());
}
echo form_hidden('updated_on', now());
echo form_hidden('author_id', $this->ion_auth->get_user_id());
?>
<!-- NAME OF THE FILE --> 
<div class="control-group">
    <?php echo form_label('Name', 'name', array('class' => 'control-label', 'for' => 'name')); ?>
    <div class="controls">
        <?php echo form_input(array('name' => 'name', 'id' => 'name', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $file->name); ?> 
    </div>
</div>

<!-- ALT ATTRIBUTE --> 
<div class="control-group">
    <?php echo form_label('Alt Attribute', 'alt_attribute', array('class' => 'control-label', 'for' => 'alt_attribute')); ?>
    <div class="controls">
        <?php echo form_input(array('name' => 'alt_attribute', 'id' => 'alt_attribute', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $file->alt_attribute); ?>
    </div>
</div>

<!-- DESCRIPTION  --> 
<div class="control-group">
    <?php echo form_label('Description', 'description', array('class' => 'control-label', 'for' => 'description')); ?> 
    <div class="controls">
        <?php echo form_input(array('name' => 'description', 'id' => 'description', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $file->description); ?> 
    </div>
</div>

<!-- FILE SET  --> 
<div class="control-group">
    <?php echo form_label('File Set', 'file_set', array('class' => 'control-label', 'for' => 'file_set')); ?>
    <div class="controls">
        <select name="file_set">
            <?php foreach ($filesets as $fileset): ?>
                <?php if ($fileset->id == $file->file_set): ?>
                    <option value="<?php echo $fileset->id; ?>" selected="<?php echo $fileset->id; ?>"><?php echo $fileset->name ?></option>
                <?php else: ?>
                    <option value="<?php echo $fileset->id; ?>"><?php echo $fileset->name ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- SLIDER LINK  --> 
<div class="control-group">
    <?php echo form_label('Title', 'title', array('class' => 'control-label', 'for' => 'title')); ?> 
    <div class="controls">
        <?php echo form_input(array('name' => 'title', 'id' => 'title', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $file->title); ?>
    </div>
</div>
<div class="control-group">
    <?php echo form_label('Link', 'link', array('class' => 'control-label', 'for' => 'link')); ?> 
    <div class="controls">
        <?php echo form_input(array('name' => 'link', 'id' => 'link', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $file->link); ?>
    </div>
</div>
<?php if (isset($method)): ?>  
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Update File</button>
        </div>
    </div>
    </form> 
<?php endif; ?>

<?php if (!isset($method)): ?>
    <!-- PARENT DIRECTORY --> 
    <div class="control-group">
        <?php echo form_label('Directory', 'dir_id', array('class' => 'control-label', 'for' => 'dir_id')); ?>
        <div class="controls">
            <select id="dir_id" name="dir_id">
                <?php foreach ($directories as $parentDir): ?>
                    <?php if($mode  == 'add' OR $directory->id == 0):?>
                        <option value="0" selected="">Default</option>
                        option>
                    <?php else:?>
                        <option value="0">Default</option>
                    <?php endif; ?>    
                    <?php if($parentDir->id == $directory->id): ?>
                        <option value="<?php echo $parentDir->id; ?>" selected=""><?php echo $parentDir->title ?></option>
                    <?php else: ?>
                        <option value="<?php echo $parentDir->id; ?>"><?php echo $parentDir->title ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="control-group">
        <?php echo form_label('Upload', 'upload', array('class' => 'control-label', 'for' => 'upload')); ?> 
        <div class="controls">
            <input type="file" name="userfile" size="20" />
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Add File</button>
        </div>
    </div>
    </form>  
<?php endif; ?>

<?php if (isset($method)): ?>
    <table class="table table-bordered table-striped table-hover">
        <tbody>  
            <tr>
                <th>File</th>
                <td class="span2"><img class="thumbnail-small" src="<?php echo base_url() . $file->url_path; ?>"/></td>
            </tr>
            <tr>
                <th>File Path</th>
                <td><?php echo $this->data['root_path'] ,  $file->full_path; ?></td>
            </tr>
            <tr>
                <th>Url</th>
                <td><a href="<?php echo base_url($file->url_path); ?>"><?php echo base_url($file->url_path); ?></a></td>
            </tr>
        </tbody>
    </table>
    <?php
    echo form_open('file_manager/file_manager/delete', array('class' => 'form-horizontal'));
    echo form_hidden('id', $file->id);
    ?>
    <button type="submit" class="btn btn-danger"><i class="icon-trash"></i> Delete</button>
    <?php echo form_close(); ?></td>

<?php endif; ?>