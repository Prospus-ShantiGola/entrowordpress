<?php
$username = $rec['users']['username'];
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
$parent_info = $this->Common->getParentInfo($rec['users']['parent_id']);
$business_id = $this->Kidpreneur->getPublishedBusinessProfile($rec['users']['id']);

//pr($business_id);
//die;
$businesViewCls=(count($business_id)==0)? "":"kid_business_profile_flyin";
$businesViewEnable=(count($business_id)==0)? "disabled":"";
?>

<tr>

    <td><img src="<?php echo $this->Html->url('/') .$image_icon_name; ?>" /></td>
    <?php if ($this->Session->read('isAdmin') == 1) { ?><td><?php echo $rec['users']['first_name'] . " " . $rec['users']['last_name']; ?></td><?php } ?>

    <td><?php echo $rec['users']['username']; ?></td>
    <?php if ($this->Session->read('isAdmin') != 1 && 0 ) { ?><td><?php echo $rec['users']['first_name'] . " " . $rec['users']['last_name']; ?></td><?php } ?>
    <?php if ($this->Session->read('isAdmin') == 1) { ?><td><?php echo date("m/d/y", strtotime($rec['utp']['birth_date'])); ?></td><?php } ?>
    <?php if ($this->Session->read('isAdmin') == 1) { ?><td ><?php echo $rec['u2']['first_name'] . " " . $rec['u2']['last_name']; ?></td><?php } ?>
    <?php if ($this->Session->read('isAdmin') == 1) { ?> <td ><?php echo $rec['identities']['title']; ?></td><?php } ?>
    <td ><?php echo $rec['utp']['organization']; ?></td>
    <?php if ($this->Session->read('isAdmin') == 1) { ?><td ><?php echo $rec[0]['status']; ?></td><?php } ?>

    <?php if ($this->Session->read('isAdmin') != 1) { ?>   <td> <a href="javascript:void(0);" class="getprofile <?php echo $businesViewEnable;?> <?php echo $businesViewCls;?>"  data-direction="right" data-toggle="modal" data-id="<?php echo $business_id[0]['KidBusinessProfile']['id']; ?>" data-action="View" data-limit="0" data-count="2" data-event="Business" ><i class="icons view-icon "  data-toggle="tooltip" data-placement="left" title="View"></i></a></td><?php } ?>

    <td class="action-icons">
        <div class="kid-flex-fix">
        <div class="flex-parent-cred-first">
            <?php if ($this->Session->read('isAdmin') == 1) { ?>
                <div class="flex-child-cred-first">
                    <a href="javascript:void(0);" class="getprofile <?php echo $businesViewCls;?>"  data-direction="right" data-toggle="modal" data-id="<?php echo $business_id[0]['KidBusinessProfile']['id']; ?>" data-action="View" data-limit="0" data-count="2" data-event="Business" ><i class="icons view-icon <?php echo $businesViewEnable;?>"  data-toggle="tooltip" data-placement="left" title="View"></i></a>

                </div>
                <div class="flex-parent-cred ">




                    <div class="flex-child-cred">
                        <span class="change-password-popup" data-change-password-id="<?php echo $rec['users']['id'] ?>" data-toggle="modal" data-target="#change-password">
                            <i class="icons change-password-sm" data-toggle="tooltip" data-placement="left" title="Change Password"></i>
                        </span>
                    </div>
                <?php } ?>

            </div>
            <?php if ($this->Session->read('isAdmin') != 1 && $this->Session->read('user_id') != $rec['users']['id']) { ?>
            <div class="flex-child-cred  "><a class= "openAddToNetwork " data-username="<?php echo $rec['users']['username'] ?>" data-userid="<?php echo $rec['users']['id'] ?>" data-type = "<?php echo $user_type; ?>"><i class="icons kid-add-network" data-toggle="tooltip" data-placement="left" title="Add To Network"></i></a></div>
                <div class="" >

                    <a href="javascript:void(0);"  onclick="jqcc.cometchat.chatWith('<?php echo $rec['users']['id'] ?>');" class="getprofile" data-direction="right"><i class="fa fa-comments-o" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Chat"></i></a>

                </div>
            <?php } ?>
        </div>
        </div>
    </td>

    <?php //}  ?>
</tr>