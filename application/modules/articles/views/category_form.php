<div class="tabbable">
    <div class="tab-content">
        <section class="title">
            <?php if ($method == 'create'): ?>
            <?php else: ?>
                <h4>Edit</h4>
            <?php endif ?>
        </section>
        <?php if (isset($error)): ?>
            <div class="alert well-large">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4><?php echo $error; ?></h4>
            </div>
        <?php endif; ?>
        <?php echo form_open($path); ?>
        <fieldset>
            <legend>Category</legend>
            <section id="content">
                <?php if ($method == 'edit'): ?>
                    <?php echo form_hidden('id', $category->id); ?>
                <?php endif; ?>
                <!-- NAME -->
                <?php echo form_label('Name', 'name', array('class' => 'control-label', 'for' => 'name')); ?>
                <?php echo form_input(array('name' => 'name', 'id' => 'name', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $category->name); ?> 
                <!-- URL -->
                <?php echo form_label('Url', 'url', array('class' => 'control-label', 'for' => 'url')); ?>
                <?php echo form_input(array('name' => 'url', 'id' => 'url', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $category->url); ?>
            </section>
        </fieldset>
        <?php echo form_submit(array('type' => 'submit', 'name' => 'submit', 'class' => 'btn btn-primary'), 'Add Category'); ?>
        <?php echo form_close() ?>    
    </div>
</div>