<?php $author = $helper->get_author($article->author_id); ?>
<div>
    <h1><?php echo $article->title; ?></h1>

    <h2><?php echo $article->subheading; ?></h2>

    <div class="author_tag">  
        <img class ='user' title="<?php echo $author['author_name']; ?>" alt="<?php echo $author['author_name']; ?>" src="<?php echo base_url() . $author['author_image']; ?>"> 
      
        <span>By <a href='<?php echo $author['google']; ?>'><?php echo $author['author_name']; ?></a>&nbsp; Published &nbsp;<?php echo $published; ?> 
            <?php if ($this->ion_auth->logged_in()): ?>
                | <a href="<?php echo base_url('articles/admin/edit') . '/' . $article->id; ?>" class="readMore">Edit</a>
            <?php endif; ?>
        </span>
    </div>

    <div class="featured_image">
        
        <a href="<?php echo $article->url; ?>" title='<?php echo $article->title; ?>'> 
            <?php echo $article->featured_image;?>
        </a>

    </div>

    <article><?php echo $article->body; ?></article>
    
</div>