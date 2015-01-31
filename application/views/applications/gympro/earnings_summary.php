<script>
    function fetch_session_data()
    {
        $("#sessions_tmpl_place").html(null);
        var st_date = $('#st_date').val();
        var fin_date = $('#fin_date').val();
        var status_id = $('#status_id').val();
        if( fin_date=='' || st_date=='' ){
            alert("Please select the dates."); return;
        }
        var gr_or_cl = $("#group_client").val();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo base_url().'applications/gympro/get_earning_summary';?>",
            data: {
                created_for_type_id: gr_or_cl.charAt(0),
                gr_cl_id: gr_or_cl.substring(2),
                start: st_date,
                end: fin_date,
                status_id: status_id
            },
            success: function(data) {
                if(gr_or_cl.charAt(0)=='1'){
                    $("#sessions_tmpl_place").html(tmpl("tmpl_client", data));
                }else if(gr_or_cl.charAt(0)=='2'){
                    $("#sessions_tmpl_place").html(tmpl("tmpl_client", data));
//                        $("#sessions_tmpl_place").html(tmpl("tmpl_client", data));
                }
            }
        });
    }
    $(function () {
        $("#mark_status_dropdown").on('change', function(){
        var session_id_array = Array();
        var cb_name;
            $('input[name^="session_select_"]:checked').each(function(){
                cb_name = $(this).prop( "name" );
                cb_name = cb_name.substring(15);
                session_id_array.push( cb_name );
            });
            if(session_id_array.length ==0)
            {
                alert('Please select atlest 1 session'); return;
            }
            if( $(this).val() != '0' ){
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: "<?php echo base_url().'applications/gympro/update_sessions';?>",
                    data: {
                        session_id_array: session_id_array,
                        status_id: $("#mark_status_dropdown").val()
                    },
                    success: function(data) {
                        alert(data['message']);
                        $('#mark_status_dropdown>option:eq(0)').prop('selected', true);
                        fetch_session_data();
                    }
                });
            }
        });
        $("#group_client, #fin_date, #st_date, #status_id").on('change', function(){
            fetch_session_data();
        });
        
        $("#datepicker").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select date",
            dateFormat: 'dd-mm-yy'
        });
        $("#st_date").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select start date",
            dateFormat: 'dd-mm-yy'
        });
        $("#fin_date").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select end date",
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_client">
    {% var i=0, sessions_array = ((o instanceof Array) ? o[i++] : o); %}
    {% while(sessions_array){ %}
    
        <div class="row form-group">
            <div class="col-md-4" style="color: red; border-bottom: 2px solid darkred; padding: 0px 0px 5px 0px">
                {%=sessions_array['date']%}
            </div>
        </div>
    
        {% var sessions = sessions_array['sessions']; %}
        {% var j=0, session = ((sessions instanceof Array) ? sessions[j++] : sessions); %}
        {% while(session){ %}
            <div class="row form-group" style="border-bottom: 1px solid lightgray; padding-bottom: 10px">
                <div class="row">
                    <div class="col-md-4">{%= session['start']%} - {%= session['end']%}</div>
                    <div class="col-md-3">{%= session['title']%}</div>
                    <div class="col-md-2">{%= session['cost']%}</div>
                    <div class="col-md-2">{%= session['status_title']%}</div>
                    <div class="col-md-1"><input name="session_select_<?php echo '{%= session["id"]%}';?>" type="checkbox"></div>
                </div>
            </div>
            {% session = ((sessions instanceof Array) ? sessions[j++] : sessions); %}
        {% } %}
        {% sessions_array = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<script type="text/x-tmpl" id="tmpl_group">
    {% var i=0, data_by_date = ((o instanceof Array) ? o[i++] : o); %}
    {% while(data_by_date){ %}
    
        <div class="row form-group">
            <div class="col-md-4" style="color: red; border-bottom: 2px solid darkred; padding: 0px 0px 5px 0px">
                {%=data_by_date['date']%}
            </div>
        </div>
    
        {% var groups = data_by_date['groups']; %}
        
        {% var mid_i=0, each_group = ((groups instanceof Array) ? groups[mid_i++] : groups); %}
        {% while(each_group){ %}

            <div class="row form-group" style="border-bottom: 2px solid gray; padding-bottom: 10px">
                <div class="row">
                    <div class="col-md-4">{%= each_group['time']%}</div>
                    <div class="col-md-3">{%= each_group['title']%}</div>
                    <div class="col-md-2"> </div>
                    <div class="col-md-2"> </div>
                    <div class="col-md-1"> <input name="session_select_<?php echo '{%= each_group["id"]%}';?>" type="checkbox"> </div>
                </div>
            </div>            
            
            {% var sessions = each_group['sessions']; %}
            
            {% var j=0, session = ((sessions instanceof Array) ? sessions[j++] : sessions); %}
            {% while(session){ %}
                <div class="row form-group" style="border-bottom: 1px solid lightgray; padding-bottom: 10px">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-3">{%= session['name']%}</div>
                        <div class="col-md-2">{%= session['cost']%}</div>
                        <div class="col-md-2">{%= session['status']%}</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                {% session = ((sessions instanceof Array) ? sessions[j++] : sessions); %}
            {% } %}
            {% each_group = ((groups instanceof Array) ? groups[mid_i++] : groups); %}
        {% } %}
        {% data_by_date = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <?php 
        if($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
        {
            $this->load->view("applications/gympro/template/sections/client_left_pane"); 
        }
        else
        {
            $this->load->view("applications/gympro/template/sections/pt_left_pane"); 
        }            
        ?>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    Earnings Summery
                    <div class="row form-group">
                        <div class="col-md-4" style="border-bottom: 1px solid #999999"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row form-group">
                        <div class="col-md-4" style="padding-right: 0">Group and Client:</div>
                        <div class="col-md-7">
                            <select class="form-control" id="group_client">
                                <!--<option>-- Select --</option>-->
                                <optgroup label="Groups">
                                    <?php foreach ($group_list as $group_info): ?>
                                        <option value="1_<?php echo $group_info['group_id']; ?>"><?php echo $group_info['title']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="Clients">
<!--                                    <option value="2_1">Shem Haye</option>
                                    <option value="2_2">Tan Haye</option>-->
                                    <?php foreach ($client_list as $client_info): ?>
                                        <option value="2_<?php echo $client_info['client_id']; ?>"><?php echo $client_info['first_name'].' '.$client_info['last_name']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
<!--                            <select class="form-control">
                                <?php foreach ($client_list as $client_info): ?>
                                    <option value="<?php echo $client_info['client_id']; ?>"><?php echo $client_info['first_name'].' '.$client_info['last_name']; ?></option>
                                <?php endforeach; ?>
                            </select>-->
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 control-div">Start:</div>
                        <div class="col-md-7">
                            <input id="st_date" style="margin-right: 5px;" value="<?php echo $current_date;?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 control-div">Finish:</div>
                        <div class="col-md-7">
                            <input id="fin_date" style="margin-right: 5px;" value="<?php echo $current_date;?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 control-div">Session:</div>
                        <div class="col-md-7">
                            <select class="form-control" id="status_id">
                                <?php foreach ($status_list as $status): ?>
                                    <option value="<?php echo $status['id']; ?>"><?php echo $status['title']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>                        
                </div>
                <div class="col-md-8">
                    <div class="row form-group" style="text-align: center">
                        <div class="col-md-4" style="background-color: lightblue; padding: 10px 0px 10px 0px">
                            <div style="font-size: 15px">
                                Prepaid
                            </div>
                            <div style="font-size: 20px">
                                120
                            </div>
                            <div style="font-size: 12px">
                                2 sess
                            </div>
                        </div>
                        <div class="col-md-2" style="background-color: lightgreen; padding: 10px 0px 10px 0px" >
                            <div style="font-size: 15px">
                                Paid
                            </div>
                            <div style="font-size: 20px">
                                120
                            </div>
                            <div style="font-size: 12px">
                                2 sess
                            </div>
                        </div>
                        <div class="col-md-3" style="background-color: lightsalmon; padding: 10px 0px 10px 0px" >
                            <div style="font-size: 15px">
                                Cancelled
                            </div>
                            <div style="font-size: 20px">
                                120
                            </div>
                            <div style="font-size: 12px">
                                2 sess
                            </div>
                        </div>
                        <div class="col-md-3" style="background-color: #ff9; padding: 10px 0px 10px 0px" >
                            <div style="font-size: 15px">
                                Total
                            </div>
                            <div style="font-size: 20px">
                                120
                            </div>
                            <div style="font-size: 12px">
                                2 sess
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="border-bottom: 1px solid lightgray; padding-bottom: 10px">
                        <div class="col-md-9" style="font-size: 15px; font-weight: bold; padding-left: 0px">
                            Schedule Session
                        </div>
                        <div class="col-md-3" style="padding-right: 0px">
                            <select class="form-control" id="mark_status_dropdown">
                                <option value="0">Mark as</option>
                                <?php foreach ($status_list as $status): ?>
                                    <option value="<?php echo $status['id']; ?>"><?php echo $status['title']?></option>
                                <?php endforeach; ?>
<!--                                <option>Prepaid</option>
                                <option>Paid</option>
                                <option>Cancelled</option>-->
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group" id="sessions_tmpl_place"></div>
                    
                </div>
            </div>
        </div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
    </div>
</div>
<?php
//$this->load->view("applications/gympro/template/modal/browse_exercise");
?>