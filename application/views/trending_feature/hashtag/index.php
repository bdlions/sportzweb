<div class="col-md-2 column">
    <?php $this->load->view("templates/sections/member_left_pane");?>
</div>
<div class="col-md-7 column">
    <?php //$this->load->view("member/newsfeed/status_bar");?>
    <div class="col-md-12" style="padding-bottom: 25px;padding-left: 0px !important;">
        <div class="col-md-11" style="border: 2px solid #c3c3c3; padding: 8px 8px;">
            <?php echo '#'.$hashtag; ?>
        </div>
    </div>
    
    <?php $this->load->view("member/newsfeed/feed");?>
</div>
<div class="col-md-3 column">
    <?php $this->load->view("templates/sections/member_right_pane");?>
</div>