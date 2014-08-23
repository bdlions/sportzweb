<script type='text/javascript'>
    $(function() {
        $('a[href="#update_post_viewers"]').on("click", function() {
            collapse_all_form();
            $("#update_post_viewers_from").removeClass("hidden");
            return false;
        });
        $('a[href="#update_post_commentors"]').on("click", function() {
            collapse_all_form();
            $("#update_post_commentors_from").removeClass("hidden");
            return false;
        });
        $('a[href="#update_posters"]').on("click", function() {
            collapse_all_form();
            $("#update_posters_from").removeClass("hidden");
            return false;
        });

        $('a[href="#update_contact"]').on("click", function() {
            collapse_all_form();
            $("#update_contact_from").removeClass("hidden");
            return false;
        });
        $('a[href="#update_post_tag"]').on("click", function() {
            collapse_all_form();
            $("#update_post_tag_from").removeClass("hidden");
            return false;
        });
        $('a[href="#update_search"]').on("click", function() {
            collapse_all_form();
            $("#update_search_from").removeClass("hidden");
            return false;
        });
        $('a[href="#update_followers"]').on("click", function() {
            collapse_all_form();
            $("#update_followers_form").removeClass("hidden");
            return false;
        });

        function collapse_all_form() {
            $("#update_post_viewers_from").addClass("hidden");
            $("#update_post_commentors_from").addClass("hidden");
            $("#update_posters_from").addClass("hidden");
            $("#update_contact_from").addClass("hidden");
            $("#update_search_from").addClass("hidden");
            $("#update_post_tag_from").addClass("hidden");
            $("#update_followers_form").addClass("hidden");
        }
    });
</script>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">Privacy settings</div>
        <div class="panel-body form-horizontal">
            <div class="form-group">
                <div class="col-md-4"><label>Who can see my posts?</label></div>
                <div class="col-md-6">
                    <?php echo ${"permission" . COLLABORATE_PERMISSION_VIEW_POST}->type ?>
                    <?php echo form_open(base_url() . "settings.html?menu=privacy&section=post_viewers", array('id' => 'update_post_viewers_from', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_dropdown("permission", $collaborator_types, ${"permission" . COLLABORATE_PERMISSION_VIEW_POST}->collaborator_type, 'class=form-control'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-2">
                    <a href="#update_post_viewers">Edit</a>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-4"><label>Who can comment on my posts?</label></div>
                <div class="col-md-6">
                    <?php echo ${"permission" . COLLABORATE_PERMISSION_COMMENT_ON_POST}->type ?>
                    <?php echo form_open(base_url() . "settings.html?menu=privacy&section=post_comment", array('id' => 'update_post_commentors_from', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_dropdown('permission', $collaborator_types, ${"permission" . COLLABORATE_PERMISSION_COMMENT_ON_POST}->collaborator_type, 'class=form-control'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-2">
                    <a href="#update_post_commentors">Edit</a>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4"><label>Who can post on my profile?</label></div>
                <div class="col-md-6">
                    <?php echo ${"permission" . COLLABORATE_PERMISSION_POST_ON_PROFILE}->type ?>
                    <?php echo form_open(base_url() . "settings.html?menu=privacy&section=post_on_profile", array('id' => 'update_posters_from', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_dropdown('permission', $collaborator_types, ${"permission" . COLLABORATE_PERMISSION_POST_ON_PROFILE}->collaborator_type, 'class=form-control'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-2">
                    <a href="#update_posters">Edit</a>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4"><label>Who can contact me?</label></div>
                <div class="col-md-6">
                    <?php echo ${"permission" . COLLABORATE_PERMISSION_CONTACT}->type ?>
                    <?php echo form_open(base_url() . "settings.html?menu=privacy&section=contact", array('id' => 'update_contact_from', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_dropdown('permission', $collaborator_types, ${"permission" . COLLABORATE_PERMISSION_CONTACT}->collaborator_type, 'class=form-control'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-2">
                    <a href="#update_contact">Edit</a>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-4"><label>Who can tag me in posts?</label></div>
                <div class="col-md-6">
                    <?php echo ${"permission" . COLLABORATE_PERMISSION_TAG_ME_IN_PHOTOS}->type ?>
                    <?php echo form_open(base_url() . "settings.html?menu=privacy&section=tag_photo", array('id' => 'update_post_tag_from', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_dropdown('permission', $collaborator_types, ${"permission" . COLLABORATE_PERMISSION_TAG_ME_IN_PHOTOS}->collaborator_type, 'class=form-control'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-2">
                    <a href="#update_post_tag">Edit</a>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-4"><label>Who can search for me?</label></div>
                <div class="col-md-6">
                    <?php echo ${"permission" . COLLABORATE_PERMISSION_SEARCH_FOR_ME}->type ?>
                    <?php echo form_open(base_url() . "settings.html?menu=privacy&section=search_me", array('id' => 'update_search_from', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_dropdown('permission', $collaborator_types, ${"permission" . COLLABORATE_PERMISSION_SEARCH_FOR_ME}->collaborator_type, 'class=form-control'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-2">
                    <a href="#update_search">Edit</a>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4"><label>Accept followers:</label></div>
                <div class="col-md-6">
                    <?php echo $user_follower_acceptance_type->description ?>
                    <?php echo form_open(base_url() . "settings.html?menu=privacy&section=following", array('id' => 'update_followers_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_dropdown('permission', $followers_types, $user_follower_acceptance_type->value, 'class=form-control'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-2">
                    <a href="#update_followers">Edit</a>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4"><label>Be notified by email when someone:</label></div>
                <?php echo form_open(base_url() . "settings.html?menu=privacy&section=set_notification", array('role' => 'form', 'class' => 'form-horizontal')) ?>
                <div class="col-md-8">
                    <?php foreach ($notification_types as $notification_type) { ?>
                    
                        <div class="row form-group">
                            <div class="col-md-9">
                                <?php echo $notification_type->description ?>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="notification_<?php echo $notification_type->value?>" <?php echo isset($user_notifications-> {"notification_" . $notification_type->value }) == true ? "checked":"" ?>>
                            </div>
                        </div>

                    <?php } ?>
                    <div class="row form-group">
                        <div class="col-md-5 col-md-offset-7">
                            <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-left')); ?></div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
