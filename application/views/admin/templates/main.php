<div class="row">
    <div class="col-md-12">
        <div class="index">
            <div class="main">
                <div class="home-left">
                    <div class="home-left-tit"></div>
                    <div class="home-left-tab">							   
                        <form action="/join.php" method="post">
                            <div style=" color:#686868; display:none;" id="codediv"><font size="+1">Security Check</font><br><br>Please enter the characters below.<br><br><img id="coder" src="simg/simg.php"> <a href="#" onclick="$('#coder').attr('src', 'simg/simg.php?' + new Date());">Change</a><br><br> <input name="code" type="text" class="home-ipnut" id="code" style=""><br><br><a href="#" onclick="checkcode();"><img src="<?php echo base_url() ?>resources/images/reg-menu.png" border="0"></a></div>
                            <table width="400" id="oldtb">
                                <tbody><tr height="40">
                                        <td class="home-left-tab-l" style="width:100px;"><?php echo lang('create_user_fname_label', 'first_name'); ?></td>
                                        <td class="home-left-tab-r"><?php echo form_input($first_name); ?></td>
                                    </tr>
                                    <tr height="40">
                                        <td class="home-left-tab-l">Last Name:</td>
                                        <td class="home-left-tab-r"><input name="LastName[0]" type="text" class="home-ipnut" id="LastName"></td>
                                    </tr>
                                    <tr height="40">
                                        <td class="home-left-tab-l">Your Email:</td>
                                        <td class="home-left-tab-r"><input name="Email[0]" type="text" class="home-ipnut email" id="Email[0]"></td>
                                    </tr>
                                    <tr height="40">
                                        <td class="home-left-tab-l">Confirm Email:</td>
                                        <td class="home-left-tab-r"><input name="Email[0]" type="text" class="home-ipnut email" id="Email[0]"></td>
                                    </tr>
                                    <tr height="40">
                                        <td class="home-left-tab-l">Enter Password:</td>
                                        <td class="home-left-tab-r"><input name="Password[0]" type="password" class="home-ipnut" id="Password"></td>
                                    </tr>									  
                                    <tr>
                                        <td class="home-left-tab-l"></td>
                                        <td class="home-left-tab-r"><a href="#" onclick="checkemail()"><img src="<?php echo base_url() ?>resources/images/reg-menu.png" border="0"></a></td>
                                    </tr>

                                </tbody></table>
                        </form>
                    </div>
                    <div class="home-left-txt"><a href="/Business/register.php">Create a profile for your  business.</a></div>
                </div>
                <div class="home-right" style="text-align: left;padding-left: 10px;"><img src="<?php echo base_url() ?>resources/images/index1376265189.jpg" style="margin-top:30px;height:auto;"><div style="width:100%; font-weight:bold; text-align:left; padding-left:5px;">Timothy Ward - Krisana Thai Boxing Gym</div></div>
            </div>
        </div>
    </div>
</div>