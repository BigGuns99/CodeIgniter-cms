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