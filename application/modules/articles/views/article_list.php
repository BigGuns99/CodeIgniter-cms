<?php foreach ($articles as $article): ?>
<?php 
 $date = getdate(strtotime($article->created)); 
 $published = $date['mon'] . '/' . $date['mday'] .  '/' . $date['year'];
 $author = $helper->get_author($article->author_id);
 ?>
    <div class="teaser">
        
        <h2 class="article_title">
            <a href="<?php echo base_url() , $article->url; ?>"><?php echo $article->title; ?></a>
        </h2>

        <div class="author_tag">  
            <img class ='user' title="<?php echo $author['author_name']; ?>" alt="<?php echo $author['author_name']; ?>" src="<?php echo base_url() . $author['author_image']; ?>"> 
            <span>By <a href='<?php echo $author['google']; ?>'><?php echo $author['author_name']; ?></a>&nbsp; Published &nbsp;<?php echo $published; ?></span>
        </div>
        
        <a href="<?php echo base_url() ,$article->url; ?>" title='<?php echo $article->title; ?>'>
            <?php echo $article->featured_image;?>
        </a>
        
        <?php echo $article->summary; ?>
        
        <a href="<?php echo  base_url() ,  $article->url; ?>" class="readMore">Read More</a>
        <?php if($this->ion_auth->logged_in()):?>
        <a href="<?php echo base_url('articles/admin/edit') . '/' . $article->id ; ?>" class="readMore">Edit</a>
        <?php endif; ?>
    </div>
<?php endforeach; ?>