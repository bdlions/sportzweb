<div class="row">
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
            <div class="col-sm-6"></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Last login : </div></label>
            <div class="col-sm-6"><?php echo $user_log['last_login']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Total logins : </div></label>
            <div class="col-sm-6"><?php echo $user_log['total_login']?></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">Average time login : </div></label>
            <div class="col-sm-6"><?php echo $user_log['average_hour'].' hours '.$user_log['average_minute'].' minutes';?></div>
        </div>
    </div>    
</div>