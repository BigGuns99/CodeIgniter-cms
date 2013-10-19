<div class="row clearfix">
    <h3 class="offset1">Redirects</h3>
</div>

<div class="row clearfix">
    
    <?php echo form_open($path, array('class' => 'form-horizontal')); ?>
    
    <?php
    // Used only when editing a a redirect record
    if(isset($edit)){
        echo form_hidden('id', $redirects->id);
    }
    ?>
    
    <!-- Redirect --> 
    <div class="control-group">
        <?php echo form_label('Redirect', 'redirect', array('class' => 'control-label', 'for' => 'redirect')); ?>
        <div class="controls">
            <?php echo form_input(array('name' => 'redirect', 'id' => 'redirect', 'maxlength' => '255', 'size' => '50', 'style' => 'width:99%'), $redirects->redirect); ?> 
        </div>
    </div>

    <!-- Article to redirect to  --> 
    <div class="control-group">
        <?php echo form_label('Article', 'article_id', array('class' => 'control-label', 'for' => 'article_id')); ?>
        <div class="controls">
            <select name="article_id" style="width:100%;">
                <?php foreach ($articles as $article): ?>
                    <?php if ($redirects->articleID == $article['id']): ?>   
                        <option value="<?php echo $redirects->articleID; ?>" selected="<?php echo $redirects->articleID; ?>"><?php echo $article['year'], '  ', $article['month'], "  - ", $article['title']; ?></option>   
                    <?php else: ?>
                          <option  style="width:100%;" value="<?php echo $article['id']; ?>"><?php echo $article['year'], '  ', $article['month'], "  - ", $article['title']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>             
            </select>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <?php if (isset($edit)): ?>
                <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Update Redirect </button> | 
                <button type="submit" id="submit"class="btn btn-danger"><i class="icon-trash"></i> Delete Advertisement</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Add Redirect</button>
            <?php endif; ?>
        </div>
    </div>

</form>

</div><!-- END row clearfix --> 