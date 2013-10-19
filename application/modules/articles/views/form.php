<div class="row clearfix">
    <section class="title">
        <?php if ($method == 'create'): ?>
            <h3 class="pull-left" >Create</h3>
        <?php else: ?>
            <h3 class="pull-left" >Edit</h3>
        <?php endif ?>
        <?php if ($method == 'edit'): ?>
            <a href="<?php echo base_url('/articles/admin/delete') . '/' . $article->id; ?>" class="btn btn-danger pull-right"><i class="icon-trash"></i> Delete</a>
        <?php else: ?>
            <a href="<?php echo base_url('/articles/admin'); ?>" class="btn btn-danger pull-right">  Cancel</a>
        <?php endif; ?>
    </section>
    <?php if (isset($error)): ?>
        <div class=" well-large warning">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
</div>


<div class="row clearfix">
    <?php echo form_open_multipart($path); ?>
    <fieldset>
        <legend>Content</legend>
        <section id="content">
            <?php if ($method == 'edit'): ?>
                <?php echo form_hidden('id', $article->id); ?>
            <?php endif; ?>
            <?php
            echo form_hidden('updated_on', now());
            echo form_hidden('updated', unix_to_human(now()));
            echo form_hidden('created_by', '1');
            ?>
            <!-- TITLE -->
            <?php echo form_label('Title', 'title', array('class' => 'control-label', 'for' => 'title')); ?>
            <?php echo form_input(array('name' => 'title', 'id' => 'title', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%', 'required' => ''), $article->title); ?> 
            <!-- SUBHEADING  -->
            <?php echo form_label('Subheading', 'subheading', array('class' => 'control-label', 'for' => 'subheading')); ?>
            <?php echo form_input(array('name' => 'subheading', 'id' => 'subheading', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%'), $article->subheading); ?>
            <!-- FEATURED IMAGE -->
            <?php echo form_label('Featured Image', 'featured_image', array('class' => 'control-label', 'for' => 'featured_image')); ?>
            <?php echo form_textarea(array('name' => 'featured_image', 'id' => 'featured_image'), $article->featured_image); ?> 
            <!-- URL  --> 
            <?php echo form_label('Url', 'url', array('class' => 'control-label', 'for' => 'url')); ?>
            <?php echo form_input(array('name' => 'url', 'id' => 'url', 'maxlength' => '100', 'size' => '50', 'style' => 'width:50%', 'required' => ''), $article->url); ?>
            <!-- STATUS  --> 
            <?php echo form_label('Status', 'status', array('class' => 'control-label', 'for' => 'status')); ?>
            <?php echo form_dropdown('status', array('DRAFT' => 'DRAFT', 'LIVE' => 'LIVE'), $article->status); ?> 
            <!-- SUMMARY --> 
            <?php echo form_label('Summary', 'summary', array('class' => 'control-label', 'for' => 'summary')); ?>
            <?php echo form_textarea(array('name' => 'summary', 'id' => 'summary'), $article->summary); ?> 
            <!-- BODY --> 
            <?php echo form_label('Main Content', 'body', array('class' => 'control-label', 'for' => 'body')); ?>
            <?php echo form_textarea(array('name' => 'body', 'id' => 'body'), $article->body); ?> 

        </section>
    </fieldset>
    <fieldset>
        <legend>SEO</legend>
        <section id="seo" >    
            <!-- KEYWORDS --> 
            <?php echo form_label('Keywords', 'keywords', array('class' => 'control-label', 'for' => 'keywords')); ?>

            <?php
            if (isset($article->keywords)) {
                echo form_input(array('name' => 'keywords', 'id' => 'keywords', 'style' => 'width:80%', 'required' => ''), $article->keywords);
            } else {
                echo form_input(array('name' => 'keywords', 'id' => 'keywords', 'style' => 'width:80%', 'required' => ''));
            }
            ?>
            <!-- CATEGORY --> 
            <?php echo form_label('Category', 'category_id', array('class' => 'control-label', 'for' => 'category_id')); ?>
            <select name="category_id">
                <?php foreach ($categories as $category): ?>

                    <?php if ($category->id == $article->category_id): ?>
                        <option value="<?php echo $category->id; ?>" selected="<?php echo $article->category_id; ?>"><?php echo $category->name; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>             
            </select>

            <!-- WEIGHT --> 
            <?php echo form_label('Weight', 'weight', array('class' => 'control-label', 'for' => 'weight')); ?>
            <select name="weight">
                <?php for ($i = 1; $i <= 50; $i++): ?>
                    <?php if ($article->weight == $i): ?>
                        <option value="<?php echo $i; ?>" selected="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endif; ?>
                <?php endfor; ?>             
            </select>

            <!-- DESCRIPTION --> 
            <?php echo form_label('Description', 'description', array('class' => 'control-label', 'for' => 'description')); ?> 
            <?php
            if (isset($article->description)) {
                echo form_input(array('name' => 'description', 'style' => 'width:90%;', 'required' => ''), $article->description);
            } else {
                echo form_input(array('name' => 'description', 'style' => 'width:90%;', 'required' => ''));
            }
            ?>
            
            <!-- DATE PUBLISHED --> 
            <?php echo form_label('Date Published') ?>
            <?php
            if (!isset($article->created)) {
                echo form_input('created', date('Y-m-d'), 'maxlength="10" id="datepub" class="text width-20"');
            } else {
                echo form_input('created', $article->created, 'maxlength="10" id="datepub" class="text width-20"');
            }
            ?>
            
            
            <!-- AUTHOR --> 
            <?php echo form_label('Author') ?>
            <select name="author_id">
                <?php foreach ($authors->result() as $author): ?>
                    <?php if ($author->id == $article->author_id): ?>
                        <option value="<?php echo $author->id; ?>" selected="<?php echo $article->author_id; ?>"><?php echo $author->first_name . ' ' . $author->last_name; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $author->id; ?>"><?php echo $author->first_name . ' ' . $author->last_name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>             
            </select>
        </section>
    </fieldset>
    <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Add Article</button>
    <?php echo form_close() ?>    
</div>
<script> 
    CKEDITOR.replace('body', {
        filebrowserBrowseUrl: '<?php echo base_url('file_manager/file_manager/ckeditor'); ?>',
    });
   CKEDITOR.replace('summary', {
        filebrowserBrowseUrl: '<?php echo base_url('file_manager/file_manager/ckeditor'); ?>',
    });
    CKEDITOR.replace('featured_image', {
        filebrowserBrowseUrl: '<?php echo base_url('file_manager/file_manager/ckeditor'); ?>',
    });  
    $('#datepub').datepicker({ dateFormat: "yy-mm-dd" });
    $('#datepup').datepicker({ dateFormat: "yy-mm-dd" });
</script>