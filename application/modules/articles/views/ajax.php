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