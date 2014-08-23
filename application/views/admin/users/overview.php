<script type="text/javascript">
    $(function() {
        $("#button_search_users").on("click", function() {
            if($("#start_age").val().length == 0 || $("#end_age").val().length == 0)
            {
                alert('Please assign date range correctly.');
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/users/get_users_by_ages",
                data: {
                    start_age:$("#start_age").val(),
                    end_age: $("#end_age").val()
                },
                success: function(data) {
                     $("#tbody_user_list").html(tmpl("tmpl_user_list", data['user_list']));                                        
                }
            });
        });        
    });
</script>
<div class="panel panel-default">
    <div class="panel-heading">Overview</div>
    <div class="panel-body">
        <div class="row col-md-10">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total number of members : </div></label>
                    <div class="col-sm-6"><?php echo $total_members?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total male members : </div></label>
                    <div class="col-sm-6"><?php echo $total_male_members?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total female members : </div></label>
                    <div class="col-sm-6"><?php echo $total_female_members?></div>
                </div>
            </div>  
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Member aged between</div></label>
                    <div class="col-sm-2">
                        <?php echo form_input(array('name' => 'start_age', 'id' => 'start_age', 'value'=>'0', 'class' => 'form-control')); ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo form_input(array('name' => 'end_age', 'id' => 'end_age', 'value'=>'100', 'class' => 'form-control')); ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo form_button(array('name' => 'button_search_users', 'id' => 'button_search_users', 'class' => 'form-control btn button-custom', 'content' => 'Search')); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <div class="row">                
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>Total members</th>
                                <th>Male</th>
                                <th>Female</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_user_list">                
                            <?php foreach($user_list_country as $user_list){?>
                                <tr>
                                    <td><?php echo $user_list['country_name']?></td>
                                    <td><?php echo ($user_list['total_male_members']+$user_list['total_female_members'])?></td>
                                    <td><?php echo $user_list['total_male_members']?></td>
                                    <td><?php echo $user_list['total_female_members']?></td>
                                </tr>                                
                            <?php } ?>
                        </tbody>
                    </table>
                </div>           
            </div>
        </div>
    </div>
</div>

<script type="text/x-tmpl" id="tmpl_user_list">
    {% var i=0, user_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(user_info){ %}
        <tr>
            <td>{%= user_info.country_name %}</td>
            <td>{%= +user_info.total_male_members + +user_info.total_female_members %}</td>
            <td>{%= user_info.total_male_members %}</td>
            <td>{%= user_info.total_female_members %}</td>
        </tr> 
    {% user_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

