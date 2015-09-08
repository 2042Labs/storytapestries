
<style type="text/css">
    #wdw_login_view {
        padding-top: 20px;
        border: 1px solid;
        border-color: #dcdcdc;
        border-radius: 4px;
    }
    .login_form_box, .register_form_box {
        margin-left: 40px;
    }
</style>

<script>

    function show_register_form(obj)
    {
        jQuery('.login_form_box').hide();
        jQuery('.register_form_box').show();

    }



</script>

<div id="wdw_login_view" class="entry-content">
    <div class="login_form_box">
        <h3>Log In </h3>
        <form name="loginform" id="loginform" action="<?php echo home_url();?>/wp-login.php" method="post">

            <p class="login-username">
                <label for="user_login">Username</label>
                <input type="text" name="log" id="user_login" class="input" value="" size="20">
            </p>
            <p class="login-password">
                <label for="user_pass">Password</label>
                <input type="password" name="pwd" id="user_pass" class="input" value="" size="20">
            </p>

            <p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember Me</label></p>
            <p class="login-submit">
                <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In">
                <input type="hidden" name="redirect_to" value="<?php echo home_url();?>/?page_id=<?php echo $wdw_post_id;?>&action=<?php echo $wdw_post_action;?>">
            </p>
            <p class="forgot_link">
                New User? 	<a href="javascript:void(0)" class="logreg-link" onclick="show_register_form(this);" id="tmpl-reg-link">Register Now</a>
            </p>
        </form>
    </div>



<div class="register_form_box" style="display: none;">
    <h3>Sign Up </h3>

    <form method="post" action="<?php echo home_url();?>/wp-login.php?action=register">
        <input type="hidden" name="redirect_to" value="<?php echo home_url();?>/?page_id=<?php echo $wdw_post_id;?>&action=<?php echo $wdw_post_action;?>&success=1">
        <input type="hidden" name="user-cookie" value="1">
        <div class="wdw-form-group">
            <label for="user_login" class="col-sm-3 control-label">Username</label>
            <div class="col-sm-6">
                <input id="user_login" class="form-control" type="text" name="user_login">
            </div>
        </div>
        <div class="wdw-form-group">
            <label for="user_email" class="col-sm-3 control-label">Your Email</label>
            <div class="col-sm-6">
                <input id="user_email" class="form-control" type="email" name="user_email">
            </div>
        </div>
        <div class="wdw-form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn button-primary">Register</button>
            </div>
        </div>
    </form>
</div>

</div>
<style type="text/css">

.wdw-form-group div {
    margin: 10px;
}
.wdw-form-group label {
    margin: 10px;
}
</style>