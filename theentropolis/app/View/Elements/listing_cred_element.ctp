<?php
$username = $rec['users']['username'];
$inviteeUserId = $rec['users']['id'];

$paymentstatus = $this->Common->getPaymentStatus($rec['users']['id']);
///pr(   $paymentstatus );

if ($paymentstatus['UserTeacherProfile']['payment_status'] == "Pending") {
    $paymentStatus = $paymentstatus['UserTeacherProfile']['payment_status'];
    $profileId = $paymentstatus['UserTeacherProfile']['id'];
    if ($this->Session->read('isAdmin') == 1) {
        $paymentLink = "<a class= 'changePaymentStatus' data-status=" . $paymentStatus . " data-profileid=" . $profileId . ">Pending</a>";
    } else {
        $paymentLink = "Pending";
    }
} else if ($paymentstatus['UserTeacherProfile']['payment_status'] == "Inactive") {
    $paymentStatus = $paymentstatus['UserTeacherProfile']['payment_status'];
    $profileId = $paymentstatus['UserTeacherProfile']['id'];
    if ($this->Session->read('isAdmin') == 1) {
        $paymentLink = "<a class= 'changePaymentStatus' data-status=" . $paymentStatus . " data-profileid=" . $profileId . ">Pending</a>";
    } else {
        $paymentLink = $paymentStatus;
    }
} else {
    if ($paymentstatus['UserTeacherProfile']['payment_status'] == "Success") {
        $paymentLink = "Active";
    }
}


if ($rec['context_role_users']['types'] == 11 || $rec['context_role_users']['types'] == 12) {
    $user_type = 'Advice';
    $class = 'get-sage-profile';
    $owner_user_id = $rec['context_role_users']['context_role_user_id'];
    //$img = $this->Html->image('t-sp.svg');
    $otherClass = '';
} else if ($rec['context_role_users']['types'] == 6) {
    $user_type = 'Advice';
    $class = 'get-sage-profile';
    $owner_user_id = $rec['context_role_users']['context_role_user_id'];
    //  $img = $this->Html->image('sage-gray.png');
    $otherClass = 'get-data-network-advice-modal';
} else if ($rec['context_role_users']['types'] == PARENT_CONTEXT_ID) {
    $user_type = 'Advice';
    $class = 'get-sage-profile';
    $owner_user_id = $rec['context_role_users']['context_role_user_id'];
    // $img = $this->Html->image('sage-icon1.svg');
    $otherClass = 'get-data-network-advice-modal';
} else {
    $user_type = 'Hindsight';
    $class = 'get-seeker-profile';
    //$img = $this->Html->image('seeker-icon.png');
    $owner_user_id = $rec['users']['context_role_user_id'];
    $otherClass = 'get-data-network-hindsight-modal';
}

if (isset($rec['users']['stage_id']) && $rec['users']['stage_id']) {
    $result = $this->User->getStageById($rec['users']['stage_id']);
    if (count($result)) {
        $stage_title = $result['Stage']['stage_title'];
    } else {
        $stage_title = "";
    }
}



$image_icon_name = $this->Common->getRoleIcon($rec['users']['id']);

$img = $this->Html->image($image_icon_name, array('alt' => ''));

$user_role = $this->Common->getRoleByLoggedInUser($rec['users']['id']);
?>

<tr>

    <td><?php echo $img; ?></td>   
<?php if ($this->Session->read('isAdmin') == 1) { ?><td><?php echo $rec['users']['first_name']; ?></td><td><?php echo $rec['users']['last_name']; ?></td><?php } ?>
    <td><?php echo $rec['users']['username']; ?></td>
    <?php if ($this->Session->read('isAdmin') != 1) { ?> <td><?php echo $rec['utp']['organization']; ?></td> <?php } ?>
<?php if ($this->Session->read('isAdmin') == 1) { ?><td><?php echo $rec['users']['email']; ?></td><?php } ?>
    <td title="<?php echo @$stage_title; ?>"><?php echo $this->Eluminati->text_cut(@$stage_title, $length = 10, $dots = true); ?></td>
<!--                                                        <td><a><i class="icons view-icon" data-toggle="tooltip" data-placement="left" title="View"></i></a></td>-->
    <td> <span class="status_tab"><?php echo $paymentLink; ?></span></td>
<?php
//if ($this->Session->read('isAdmin') == 1) {

if ($paymentstatus['UserTeacherProfile']['payment_status'] == "Pending") {
    $disbleClass = 'disabled';
} else {
    $disbleClass = '';
}
?>
    <td class="action-icons">
        <div class="flex-parent-cred-first">
            <div class="flex-child-cred-first">
                <a href="javascript:void(0);" class="<?php echo $class; ?> getprofile" data-type="<?php echo $user_type; ?>" data-id="<?php echo $owner_user_id; ?>"  data-direction="right"><i class="icons view-icon" data-toggle="tooltip" data-placement="left" title="View"></i></a>

            </div>
            <div class="flex-parent-cred <?php echo $disbleClass; ?>">

<?php $disbleCls = ( ($rec['users']['id'] != $this->Session->read('user_id'))) ? "" : "disabled"; ?>          
                <div class="flex-child-cred <?php echo $disbleCls; ?>">
                    <a class="directMessage"
                       data-userinfo='{"userName": "<?php echo $username ?>", "inviteeUserId": <?php echo $inviteeUserId ?> } '>
                        <i class="icons view-icon-grey" data-toggle="tooltip" data-placement="left" title="Send Message"></i>
                    </a>
                </div>

<?php $disbleCls = ($rec['users']['id'] != $this->Session->read('user_id')) ? "" : "disabled"; ?>          
                <div class="flex-child-cred <?php echo $disbleCls; ?>"><a class= "openAddToNetwork " data-username="<?php echo $rec['users']['username'] ?>" data-userid="<?php echo $rec['users']['id'] ?>" data-type = "<?php echo $user_type; ?>"><i class="icons add-network" data-toggle="tooltip" data-placement="left" title="Add To Network"></i></a></div>

<?php if ($this->Session->read('isAdmin') == 1) { ?>

                    <div class="flex-child-cred">
                        <span class="block-popup"  data-id = "<?php echo $rec['users']['id']; ?>" data-type = "<?php echo $user_role;?>" ><i class="icons block-sm" data-toggle="tooltip" data-placement="left" title="Block User" ></i></span>
                    </div>
                    <div class="flex-child-cred">
                        <span class="change-password-popup" data-change-password-id="<?php echo $rec['users']['id'] ?>" data-toggle="modal" data-target="#change-password">
                            <i class="icons change-password-sm" data-toggle="tooltip" data-placement="left" title="Change Password"></i>
                        </span>
                    </div>
<?php } ?>

            </div>
        </div>

    </td>  
                <?php //}  ?>
</tr>