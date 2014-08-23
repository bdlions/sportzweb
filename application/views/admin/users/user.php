<div class="panel panel-default">
    <div class="panel-heading">User Info</div>
    <div class="panel-body">
        <div class="row col-md-10">
            <div class="row">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Info</a></li>
                    <li><a href="#2" data-toggle="tab">Followers</a></li>
                    <li><a href="#3" data-toggle="tab">Applications</a></li>
                    <li><a href="#4" data-toggle="tab">Visit</a></li>
                    <li><a href="#5" data-toggle="tab">Log</a></li>
                    <li><a href="#6" data-toggle="tab">Conversation</a></li>
                    <li><a href="#7" data-toggle="tab">SNS</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">
                        <?php $this->load->view('admin/users/user_info'); ?>
                    </div><!--/.tab1 -->
                    <div class="tab-pane" id="2">
                       <?php $this->load->view('admin/users/user_followers'); ?>
                    </div><!--/.tab2 -->

                    <div class="tab-pane" id="3">
                        <?php $this->load->view('admin/users/user_applications'); ?>
                    </div><!--/.tab3 -->
                    <div class="tab-pane" id="4">
                        <?php $this->load->view('admin/users/user_visit'); ?>
                    </div><!--/.tab4 -->
                    <div class="tab-pane" id="5">
                        <?php $this->load->view('admin/users/user_log'); ?>
                    </div><!--/.tab5 -->
                    <div class="tab-pane" id="6">
                        <?php $this->load->view('admin/users/user_conversation'); ?>
                    </div><!--/.tab6 -->
                    <div class="tab-pane" id="7">
                        <?php $this->load->view('admin/users/user_sns'); ?>
                    </div><!--/.tab7 -->
                </div>
            </div>
        </div>
    </div>
</div>

