<div class="panel panel-default">
    <div class="panel-heading">Comment Detail</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3"><div class="pull-right">UserName : </div></label>
                        <div class="col-sm-9"><?php echo $comment['username']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3"><div class="pull-right">Comment : </div></label>
                        <div class="col-sm-9"><textarea readonly  cols="70" height="100"><?php echo $comment['comment']; ?></textarea></div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>