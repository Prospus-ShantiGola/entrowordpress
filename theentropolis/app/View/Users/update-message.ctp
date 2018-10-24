<?php if( $content['response'] == 'success'){ ?>
   <div class="alert-success" style="padding:8px">  Updated successfully.  </div>
<?php }
else if($content['response'] == 'count-error'){ ?>
    <div class="alert-danger" style="padding:8px">Please tick at-least one box.  </div>
<?php }

else if($content['response'] == 'empty-error'){ ?>
    <div class="alert-danger" style="padding:8px">Please enter other value.  </div>
<?php }
else if($content['response'] == 'password-length-error'){ ?>
    <div class="alert-danger" style="padding:8px">Passwords must be at least 3 characters long.  </div>
<?php }
else if($content['response'] == 'not-match'){ ?>
    <div class="alert-danger" style="padding:8px">New password and confirm password should be matched.  </div>
<?php }
else if($content['response'] == 'invalid-pass'){ ?>
    <div class="alert-danger" style="padding:8px">Current password should be valid.  </div>
<?php }
else { ?>
    <div class="alert-danger" style="padding:8px">Sorry ! did not  Update.  </div>
<?php }?>