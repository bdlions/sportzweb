<div class="row">
    <div class="col-md-2 column">
        <?php $this->load->view("templates/sections/member_left_pane"); ?>
    </div>
    <div class="col-md-7 column">
        <?php $this->load->view("member/newsfeed/status_bar"); ?>
        <?php $this->load->view("member/newsfeed/feed"); ?>
    </div>
    <div class="col-md-3 column">
        <?php $this->load->view("templates/sections/member_right_pane"); ?>
    </div>
</div>