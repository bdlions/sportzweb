<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">

    <div class="row top_margin">
        <div class="col-md-2">
            <!--left nav custom fore teis page-->
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#add_client').show();">ADDING CLIENT</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#contact_details').show();">Contact Details</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#health').show();">Health</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#notes').show();">Notes</a>
            </div>
        </div>



        <!--ADDING CLIENT-->
        <div class="col-md-7">
            <div class="pad_title">
                ADDING CLIENT
            </div>
            <div class="pad_body">
                <form class="form-horizontal" role="form">

                    <!--<div class="row" style="display: none">-->
                    <div class="row hidden_tab" id="add_client" style="display: block">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">First Name: </label>
                                <div class="col-sm-6">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Last Name: </label>
                                <div class="col-sm-6">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Gender </label>
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="sex"> Male
                                    <br>
                                    <input type="radio" name="sex"> Female 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email: </label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Start Date: </label>
                                <div class="col-sm-4">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">End Date: </label>
                                <div class="col-sm-4">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Birth Date: </label>
                                <div class="col-sm-4">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Client Status </label>
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="cl_status"> Active
                                    <br>
                                    <input type="radio" name="cl_status"> Inactive 
                                    <br>
                                    <input type="radio" name="cl_status"> Potential 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Occupation: </label>
                                <div class="col-sm-4">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Company Name: </label>
                                <div class="col-sm-4">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Photo: </label>
                                <div class="col-sm-4">
                                    <input type="file">
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--CONTACT DETAILS-->
                    <!--<div class="row" style="display: none">-->
                    <div class="row hidden_tab" id="contact_details">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Phone: </label>
                                <div class="col-sm-6">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Mobile: </label>
                                <div class="col-sm-6">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Mobile: </label>
                                <div class="col-sm-8">
                                    <input class="form-control"><br>
                                    If sending SMS reminders please use an international format and include both country and area code and avoid spaces. For example: New Zealand: 64212614687, Australia: 61407142657
                                    <br><a>See a list of supported mobile networks worldwide.</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Receive SMS alerts </label>
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="rcv_sms" value="yes"> Yes
                                    <br>
                                    <input type="radio" name="rcv_sms" value="no"> No 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Address: </label>
                                <div class="col-sm-8">
                                    <textarea style="width: 100%"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Emergency contact: </label>
                                <div class="col-sm-6">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Emergency phone: </label>
                                <div class="col-sm-6">
                                    <input class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--HEALTH-->
                    <!--<div class="row" style="display: none">-->
                    <div class="row hidden_tab" id="health">
                        <div class="col-md-12">
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Smoker?</label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Blood pressure too high or too low?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Any known cardiovascular problems?</label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Smoker?</label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">High cholesterol?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Overweight?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Any injuries or orthopaedic problems?</label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Taking any prescribed medication or dietary supplements?</label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Any other medical conditions or problems not previously mentioned?</label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <input class="form-control">
                                </div>
                            </div>

                            <div class="form-group pad_lines">
                                <label class="col-sm-4 patapota">Height: </label>
                                <div class="col-sm-4">
                                    <input class="form-control">cm
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <label class="col-sm-4 patapota">Resting Heart Rate: </label>
                                <div class="col-sm-6">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <label class="col-sm-4 patapota">Blood Pressure: </label>
                                <div class="col-sm-6">
                                    <input class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--NOTES-->
                    <!--<div class="row" style="display: none">-->
                    <div class="row hidden_tab" id="notes">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Current workout: </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Goals: </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Notes: </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <div>
                    <button style="line-height: 22px;">Save Client</button> or <a href="<?php echo base_url().'applications/gympro/manage_clients'?>" style="font-size: 16px; line-height: 22px;">Cancel</a>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
function clicled_a()
{
//            .style.display = 'none';
//    var classes = document.getElementsByClassName('hidden_tab');
    
//    document.getElementById('contact_details').style.display = 'block';
    $('.hidden_tab').hide();$('#contact_details').show();
}
function clicled_b()
{
    $('.hidden_tab').hide();$('#add_client').show();
}
</script>
