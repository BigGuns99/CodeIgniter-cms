<div class="row clearfix view-header">
    <a class="btn btn-primary pull-right" href="<?php echo base_url('articles/admin/add'); ?>"><i class="icon-plus"></i> Add Article</a>
    <br/>
    <form class="pull-left">
        <section class="pull-left" style="margin:0 3px;"> 
            <!-- AUTHOR --> 
            <?php echo form_label('Author') ?>
            <select name="author_id" id="author" style="width:200px;">
                <option>All</option>
                <?php foreach ($authors->result() as $author): ?>
                    <option value="<?php echo $author->id; ?>"><?php echo $author->first_name . ' ' . $author->last_name; ?></option>
                <?php endforeach; ?>             
            </select>
        </section>
        <section class="pull-left" style="margin:0 3px;"> 
            <label>Year</label>
            <select id="year" style="width:200px;">
                <option>2013</option>
                <option>2012</option>
                <option>2011</option>
            </select> 
        </section>
        <section class="pull-left" style="margin:0 3px;"> 
            <label>Status</label>
            <select id="status" style="width:200px;">
                <option>LIVE</option>
                <option>DRAFT</option>
            </select> 
        </section> 
        <section class="pull-left" style="margin:0 3px;">
            <br>
            <button style="margin-top:3px;" type="button" id="submit" class="btn">Update</button>
        </section> 
    </form>
</div>
<br/>
<div class="row clearfix">
    <!-- Updated Message --> 
    <?php if (isset($post)): ?>
        <div class="alert well-large">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4> The Article <?php echo $post['title']; ?> was <?php if ($status == 'updated'): ?> updated. <?php elseif ($status == 'added'): ?> added. <?php else: ?> deleted. <?php endif; ?> </h4>
        </div>
    <?php endif; ?> 
    <!-- Error Message --> 
    <?php if (isset($error)): ?>
        <div class="alert well-large">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>The was an error when trying to process your request, please try again.</h4>
        </div>
    <?php endif; ?>
</div>

<div class="row clearfix" id="results">
    <table class="table table-bordered tablesorter table-striped table-hover"  id="mytable" >
        <thead>
        <th>Article</th>
        <th>Category</th>
        <th>Date Published</th>
        <th>Author</th>
        <th>Status</th>
        <th>Actions</th>
        </thead>
        <tbody>  
            <?php foreach ($articles as $article): ?>  
                <tr>
                    <td><?php echo $article->title; ?></td>
                    <td><a href="<?php echo $article->category_id; ?>"><?php echo $article->category_name; ?></a></td>
                    <td><?php echo $article->created; ?></td>
                    <td><?php echo $article->first_name . ' ' . $article->last_name; ?></td>
                    <td><?php echo $article->status; ?></td>
                    <td><a href="<?php echo base_url('articles/admin/edit') . "/$article->id"; ?>" class="btn btn-primary"><i class="icon-edit"></i> Edit</a> | <a href="<?php echo base_url($article->url); ?>" class="btn btn-primary"><i class="icon-edit"></i> View</a></td>
                </tr>         
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('button#submit.btn').on("click", function(event) {

            var get = {
                author: $("#author").val(),
                year: $("#year").val(),
                status: $("#status").val()
            }

            $('div#results').html('<img style="position:relative;  left:45%; top:250px;" src="<?php echo base_url() , 'assets/files/splash-images/287.gif' ;?>">');

            $.ajax({
                type: 'get',
                url: '<?php echo base_url();?>/articles/admin/articlesAjax',
                data: get,
                success: function(data) {
                    $('div#results').html(data);
                }
            });
        });
    });
</script>