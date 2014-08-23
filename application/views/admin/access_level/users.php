<style type="text/css">
   .td_text_color {color: #428bca;}
   .customrow
   {
       border-bottom: 1px solid #999999;
       padding-bottom: 8px;
       padding-top: 8px;
   }
</style>
<div class="col-md-12">    
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo $user_info['first_name'].' '.$user_info['last_name'].' - '.$user_info['description']; ?>
        </div>

        <div class="panel-body">
            <div class="row col-md-9">
                
                <?php if(!empty($user_list)): ?>
                    <?php foreach($user_list as $user):?>
                    <div class="row customrow col-md-12">
                        <div class="col-md-5">
                            <?php echo $user['first_name'].' '.$user['last_name']?>
                        </div>
                        <div class="col-md-3">
                            <?php echo $user['email']?>
                        </div>
                        <div class="col-md-1">
                            <a href="<?php echo base_url().'admin/access_level/edit_user/'.$user['user_id'] ?>">Edit</a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo base_url().'admin/access_level/delete_user/'.$user['user_id'] ?>">Delete</a>
                        </div>
                    </div>
                    <?php endforeach;?>
                <?php endif;?>   
            </div>
        </div>
    </div>
</div>