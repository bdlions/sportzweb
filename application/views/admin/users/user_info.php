<div class="row">
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
            <div class="col-sm-6"></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Name : </div></label>
            <div class="col-sm-6"><?php echo $user_info['first_name'].' '.$user_info['last_name']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Email : </div></label>
            <div class="col-sm-6"><?php echo $user_info['email']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Website : </div></label>
            <div class="col-sm-6"><?php echo $user_info['website_address']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Telephone : </div></label>
            <div class="col-sm-6"><?php echo $user_info['telephone']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Date of birth : </div></label>
            <div class="col-sm-6"><?php echo $user_info['dob']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Age : </div></label>
            <div class="col-sm-6"></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Gender : </div></label>
            <div class="col-sm-6"><?php echo $user_info['gender_name']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Country : </div></label>
            <div class="col-sm-6"><?php echo $user_info['country_name']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Profession : </div></label>
            <div class="col-sm-6"><?php echo $user_info['occupation']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Registered : </div></label>
            <div class="col-sm-6"><?php echo $user_info['created_on']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Total number of friends : </div></label>
            <div class="col-sm-6"><?php echo $user_friends['total_friend'];?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Male friends : </div></label>
            <div class="col-sm-6"><?php echo $user_friends['male_friend'];?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Female friends : </div></label>
            <div class="col-sm-6"><?php echo $user_friends['female_friend'];?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Number of applications : </div></label>
            <div class="col-sm-6"><?php echo $total_applications;?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Number of business connections : </div></label>
            <div class="col-sm-6"><?php echo $total_business_profile_connection; ?></div>
        </div>
    </div>
</div>