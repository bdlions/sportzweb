<html>
<body>
    <p><b>Hello <?php echo $first_name?> <?php echo $last_name?></b></p>
    <h1><?php echo sprintf(lang('email_activate_heading'), $identity);?></h1>
    <p><?php echo sprintf(lang('email_activate_subheading'), anchor('auth/activate/'. $id .'/'. $activation, lang('email_activate_link')));?></p>
</body>
</html>