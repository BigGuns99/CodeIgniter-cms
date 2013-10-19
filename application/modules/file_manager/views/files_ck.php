<div class="row clearfix view-header">
    <?php
    if (!isset($funcNum)) {
        $funcNum = $_GET['CKEditorFuncNum'];
    }
    ?>
    <a class=" btn btn-primary pull-right" href="<?php echo base_url('file_manager/file_manager/create_ck') . '/' . $funcNum; ?>"><i class="icon-plus"></i> Add File</a> 
    <form class="pull-left" style="margin:0 3px">
        <section class="pull-left" style="margin:0 3px;">
            <label>Directory</label>
            <select name="parent_dir" id="directory">
                <?php foreach ($directories as $directory): ?>
                    <option value="<?php echo $directory->id; ?>"><?php echo $directory->title ?></option>
                <?php endforeach; ?>
            </select>
        </section> 
        <section class="pull-left" style="margin:0 3px;">
            <br>
            <button style="margin-top:3px;" type="button" id="submit" class="btn">Update</button>
        </section> 
    </form>
</div>
<br/>
<div class="row clearfix" id="results">
    <?php if (count($files) > 0): ?>
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <th>Thumbnail</th>
            <th>Name</th>
            <th>Date Added</th>
            </thead>
            <tbody>  
                <?php foreach ($files as $file): ?>     
                    <tr>
                        <td><img class="thumbnail-small" src="<?php echo base_url($file->url_path); ?>"/></td>
                        <td><?php echo $file->name; ?></td>
                        <td><?php echo date('m/d/Y', $file->created_on); ?></td>
                        <td><a href="#" rel="<?php echo $file->url_path; ?>" class="choose btn btn-primary "> <i class="icon-ok"></i> Choose</a></td>
                        <td><a href="<?php echo base_url('file_manager/file_manager/edit') . '/' . $file->id; ?>" class="btn btn-primary"> <i class="icon-edit"></i> Edit</a></td>
                    </tr>
                <?php endforeach; ?>    
            </tbody>
        </table>
    <?php else: ?> 
        <div class="row clearfix">
            <h4>No files have been created.</h4>
        </div>
    <?php endif; ?>

<script>
        $('a.choose').on("click", function(e) {
            e.preventDefault();
            window.opener.CKEDITOR.tools.callFunction(<?php echo $funcNum; ?>, $(this).attr('rel'));
            window.close();
        });

    $(document).ready(function() {
        $('button#submit.btn').on("click", function(event) {

            var get = {
                directory: $("#directory").val(),
                fileType: 'ck',
                funcNum: '<?php echo $funcNum; ?>'
            }

            $('div#results').html('<img style="position:relative;  left:45%; top:250px;" src="<?php echo base_url(), 'assets/files/splash-images/287.gif'; ?>">');

            $.ajax({
                type: 'get',
                url: '<?php echo base_url(); ?>file_manager/file_manager/filesAjax',
                data: get,
                success: function(data) {
                    $('div#results').html(data);
                }
            });
        });
    });
</script>
</div>