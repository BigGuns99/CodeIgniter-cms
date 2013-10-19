<div class="row clearfix view-header">
    <a class=" btn btn-primary pull-right" href="<?php echo base_url('ads/ads/add'); ?>"><i class="icon-plus"></i> Add Advertisement</a>
    
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
<?php if (isset($status)): ?>
    <div class="alert well-large">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4> The ad  <?php echo $title ?> was <?php if ($status == 'updated'): ?> updated. <?php elseif ($status == 'added'): ?> added. <?php else: ?> deleted. <?php endif; ?> </h4>
    </div>
<?php endif; ?>
<div class="row clearfix" id="results">
    <?php if (count($ads) > 0): ?>
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <th>Title</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Author</th>
            <th>edit</th>
            </thead>
            <tbody>  
                <?php foreach ($ads as $ad): ?>     
                    <tr>
                        <td><?php echo $ad->title; ?></td>
                        <td><?php echo date('m/d/Y', $ad->created); ?></td>
                        <td><?php echo date('m/d/Y', $ad->updated); ?></td>
                         <td><?php echo $ad->first_name . ' ' . $ad->last_name; ?></td>
                        <td><a href="<?php echo base_url('ads/ads/edit') . '/' . $ad->id; ?>" class="btn btn-primary"> <i class="icon-edit"></i> Edit</a></td>
                    </tr>
                <?php endforeach; ?>    
            </tbody>
        </table>
    <?php else: ?> 
        <div class="row clearfix">
            <h4>No ads were found, please try again</h4>
        </div>
    <?php endif; ?>
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
                url: '<?php echo base_url();?>ads/ads/adsAjax',
                data: get,
                success: function(data) {
                    $('div#results').html(data);
                }
            });
        });
    });
</script>