<?php echo form_open($path, array('class' => 'form-horizontal')); ?>
<!-- USER FRIENDLY TITLE OF THE DIRECTORY --> 
<div class="control-group">
    <?php echo form_label('Name', 'name', array('class' => 'control-label', 'for' => 'name')); ?>
    <div class="controls">
        <?php echo form_input(array('name' => 'name', 'id' => 'name', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $fileset->name); ?> 
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <?php if (isset($method)): ?>
            <?php echo form_hidden('id', $fileset->id); ?>
            <button type="submit" class="btn btn-primary"><i class="icon-trash"></i> Update Fileset</button> | 
            <button type="submit" id="<?php echo $fileset->id; ?>"class="btn btn-danger"><i class="icon-plus"></i> Delete Fileset</button>
            <?php echo form_close(); ?>
        <?php else: ?>
            <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Add Fileset</button>
        <?php endif; ?>
    </div>
</div>
</form>
<script>
    $('button#<?php echo $fileset->id; ?>.btn').click(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('filesets/delete'); ?>",
            data: {id: <?php echo $fileset->id; ?>},
            success: function(data) {
                location = "<?php echo base_url('filesets'); ?>";
            }
        });
    });
</script>