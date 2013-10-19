<div class="row clearfix">
    <h3 class="offset1">Ads</h3>
</div>
<div class="row clearfix">
    <?php echo form_open($path, array('class' => 'form-horizontal')); ?>

    <!-- TITLE--> 
    <div class="control-group">
        <?php echo form_label('Title', 'title', array('class' => 'control-label', 'for' => 'title')); ?>
        <div class="controls">
            <?php echo form_input(array('name' => 'title', 'id' => 'title', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $ad->title); ?> 
        </div>
    </div>

    <!-- CATEGORY --> 
    <div class="control-group">
        <?php echo form_label('Category', 'category_id', array('class' => 'control-label', 'for' => 'category_id')); ?>
        <div class="controls">
            <select name="category_id">
                <?php foreach ($categories as $category): ?>
                    <?php if ($category->id == $ad->category_id): ?>
                        <option value="<?php echo $category->id; ?>" selected="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>             
            </select>
        </div>
    </div>
    <div class="control-group">
        <?php echo form_label('Featured Image', 'featured_image', array('class' => 'control-label', 'for' => 'featured_image')); ?>
        <div class="controls">
            <?php echo form_textarea(array('name' => 'featured_image', 'id' => 'featured_image'), $ad->featured_image); ?> 
        </div>
    </div>
    <!-- BODY--> 
    <div class="control-group">
        <?php echo form_label('Body', 'body', array('class' => 'control-label', 'for' => 'body')); ?>
        <div class="controls">
            <?php echo form_textarea(array('name' => 'body', 'id' => 'body'), $ad->body); ?>
        </div>
    </div>
    <!-- STATUS  --> 
    <div class="control-group">
        <?php echo form_label('Status', 'status', array('class' => 'control-label', 'for' => 'status')); ?>
        <div class="controls">
            <?php echo form_dropdown('status', array('DRAFT' => 'DRAFT', 'LIVE' => 'LIVE'), $ad->status); ?> 
        </div>
    </div>

    <?php
    if (isset($method)) {
        echo form_hidden('id', $ad->id);
        echo form_hidden('created', $ad->created);
        echo form_hidden('author_id', $user->get_user_id());
        echo form_hidden('updated_by', $user->get_user_id());
        echo form_hidden('updated', time());
    } else {
        echo form_hidden('created', time());
        echo form_hidden('author_id', $user->get_user_id());
        echo form_hidden('updated_by', $user->get_user_id());
        echo form_hidden('updated', time());
    }
    ?>
    <div class="control-group">
        <div class="controls">
            <?php if (isset($method)): ?>
                <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Update Advertisement</button> | 
                <button type="submit" id="<?php echo $ad->id; ?>"class="btn btn-danger"><i class="icon-trash"></i> Delete Advertisement</button>
                <?php echo form_close(); ?>
            <?php else: ?>
                <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Add New Ad</button>
            <?php endif; ?>
        </div>
    </div>
</form>
</div>
<script>

    CKEDITOR.replace('body', {
        filebrowserBrowseUrl: '<?php echo base_url('file_manager/file_manager/ckeditor'); ?>',
        enterMode: Number(2)
    });
    
    CKEDITOR.replace('featured_image', {
        filebrowserBrowseUrl: '<?php echo base_url('file_manager/file_manager/ckeditor'); ?>',
    });  

</script>

<?php if (isset($method)): ?>
    <script>
        $('button#<?php echo $ad->id; ?>.btn').click(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('ads/ads/delete'); ?>",
                data: {id: <?php echo $ad->id; ?>},
                success: function(data) {
                    console.log(data);
                    location = "<?php echo base_url('ads/ads'); ?>";
                }
            });
        });
    </script>
<?php endif; ?>