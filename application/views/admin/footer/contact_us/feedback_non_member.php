<div class="panel panel-default">
    <div class="panel-heading">Customer Feedback</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Customer Email</th>
                                <th style="text-align: center;">Phone</th>
                                <th style="text-align: center;">Feedback</th>
                                <th style="text-align: center;">Time</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_feedback_list">
                            <?php foreach($feedback_list as $feedback){?>
                            <tr>
                                <td><?php echo $feedback['name'];?></td>
                                <td><?php echo $feedback['email'];?></td>
                                <td><?php echo $feedback['phone'];?></td>
                                <td><?php echo $feedback['description'];?></td>
                                <td><?php echo $feedback['created_on'];?></td> 
                                <td><a onclick="open_modal_delete_confirm(<?php echo $feedback['id']?>)" >Delete</a></td>   
                            </tr> 
                            <?php } ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-2" style="padding-left: 10px;">
                <a href="<?php echo base_url(); ?>admin/contact_us">
                        <input type="button" value="Back" id="back_button" class="form-control btn button-custom">
                    </a>
            </div>
        </div>        
    </div>
</div>
<?php $this->load->view("admin/footer/contact_us/modal_delete_member_feedback_confirm")?>
