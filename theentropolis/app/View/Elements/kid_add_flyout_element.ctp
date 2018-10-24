<!-- Edit Mode-student-flyout -->
    <div class="modal-dialog">
         <div class="page-loading-modal" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
        <!-- Modal content-->
        <?php if($action =='Edit')
        {
            $formtitle = $students["User"]["username"];

        } 
        
            $readonly = 'readonly';
            $readonlyparent = ($this->Session->read('roles')=="Teacher")? 'readonly': ""; //pr($this->Session->read('roles'));?>
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title"><?php  echo $formtitle ;?></h4>
                   <ul class="students-action-links">
                        <?php if($action =='Edit')
                        {?>
                           <li class=""><a href="javascript:void(0);" onclick = "$('.submit-kidform').trigger('click')">Save Updates</a></li>
                    
                        <?php }else{?>
                       <!--   <li class=""><a href="javascript:void(0);" onclick = "$('.submit-kidform').trigger('click')">Save</a></li> -->
                      
                            <?php }?>
                               <li class="close-student-modal" ><a href="javascript:void(0);">Cancel</a></li>
                    </ul>
            </div>
            <form class="form-horizontal studentFromValidate" name="addStudent" id="addStudent" data-action ='<?php echo $action;?>' data-role ='<?php echo $role;?>'>
                <div class="modal-body custom_scroll addmodalstudentscroll" id="container12">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="text" class="form-control"  value = "<?php  echo  $students['User']['first_name'];?>"id="student_fname" name="first_name" placeholder="First Initial*" maxlength = '20'>
                        </div>
                        <div class="col-sm-6 manage-left-pad">
                            <input type="text" class="form-control" value = "<?php  echo  $students['User']['last_name'];?>" id="student_lname" name="last_name" placeholder="Last Name*" maxlength = '20'>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" autocomplete="off" class="form-control"  id="student_avatar_name" value = "<?php  echo  $students['User']['username'];?>" name="student_avatar_name" placeholder="Kidpreneur Avatar Name*" <?php  if($students['User']['username']!='') {echo  $readonly; }?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="student_password" name="student_password" placeholder="Create a Secret Password*" value = "<?php  echo  base64_decode($students['UserTeacherProfile']['teacher_password']);?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="student_confirm_password" id="student_confirm_password" placeholder="Confirm your Secret Password*" value = "<?php  echo  base64_decode($students['UserTeacherProfile']['teacher_password']);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control datepicker  " id="birth_date" readonly name="birth_date"  value = "<?php if($action =='Edit'){ echo  date('m/d/Y',strtotime($students["UserTeacherProfile"]["birth_date"]));}?>"  placeholder="Date of Birth*">
                        </div>
                    </div>
                   <div class="form-group"> 
                        <div class="col-sm-12">
                           <select class="form-control" name="gender" >
                             <option value =''>Gender*</option>
                            <option value ='Male' <?php if($students["User"]["gender"] =='Male'){echo 'selected="selected"';}?>>Male</option>
                             <option value ='Female' <?php if($students["User"]["gender"] =='Female'){echo 'selected="selected"';}?>>Female</option>
                           </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 ui-widget">
                            <input type="text" class="form-control"  id="student_school_name" name="student_school_name"  value = "<?php  if($teacher_info['UserTeacherProfile']['organization']!='' && $this->Session->read('roles')=="Teacher") {echo $teacher_info['UserTeacherProfile']['organization'];} ?>" placeholder="School Name*" <?php  if($teacher_info['UserTeacherProfile']['organization']!='') {echo  $readonlyparent; }?>>
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="student_promotional"   value="<?php  if($teacher_info['UserTeacherProfile']['kbn_number']!='' && $this->Session->read('roles')=="Teacher") {echo $teacher_info['UserTeacherProfile']['kbn_number']; }?>" name="student_promotional" placeholder="School KBN / Promotional Code" <?php  echo  $readonly; ?> >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="" name="year_group"   value="<?php  if($teacher_info['UserTeacherProfile']['year_group']!='') {echo $teacher_info['UserTeacherProfile']['year_group'];} ?>"   placeholder="School Year Level*" <?php  if($teacher_info['UserTeacherProfile']['year_group']!='') {echo  $readonly; }?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="" name="student_teachername" value = "<?php echo  $teacher_info['User']['username']; ?>" placeholder="My Teacher / Principal's Full Name" readonly >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="" name="student_teacher_email" placeholder="My Teacher / Principal's Email Address" value="<?php  echo  $teacher_info['User']['email_address'];?>" readonly >
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="role" name="role" value="<?php echo $role; ?>">
                     <input type="hidden" class="form-control" id="role" name="action_type" value="<?php echo $action; ?>">
                              <input type="hidden" class="form-control" id="role" name="student_id" value="<?php echo $students["User"]["id"]; ?>">
                </div>

                <?php if($action !='Edit')
                    {   $cls = '';
                     }else
                     {
                      
                        $cls = 'hide';
                     } ?>
                <div class="modal-footer">
                    <button type="submit" class="form-control btn btn-blue submit-kidform <?php echo $cls ?>" >Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .ui-datepicker-days-cell-over a.ui-state-default {
    color: #ffffff;
    background: #7e9198;
}
    </style>
<!-- Edit Mode-student-flyout -->
<script type="text/javascript">
$(function () {
     $("#student_school_name").keyup(function() {
  $("#student_promotional").val('');
});
$( "#student_school_name" ).autocomplete({
      source:"<?php echo Router::url(array('controller' => 'Users', 'action' => 'get_schoolnames')); ?>",
      appendTo: ".ui-widget",
      select: function( event, ui ) {
        ui.item.value;
        $.ajax( {
          url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'get_kbn')); ?>",
          dataType: "json",
          data: {
            term: ui.item.value
          },
          success: function( data ) {
        console.log(data);    
        $("#student_promotional").val(data[0]);
          }
        } );
      }
    });
    //changes implement on 20 Aug 2018
    $('#birth_date').datepicker({ 
//                        minDate: "-12Y", 
                           defaultDate: '<?php echo MIN_AGE;?>',
            //         maxDate: '<?php echo MIN_AGE;?>',                     
//                    Removed as per discussion on 20 march 18
                   });

            $('#birth_date').on('change',function(){
                if($(this).val()!='')
                {
                    $(this).removeClass('selected-error-fields');
                    $('#birth_date-error').css('display',"none")
                }

            }) 

            $('#student_avatar_name').on('keyup',function(){
               $('.custom_error').remove();
                $.ajax({
                            url: './users/checkAvatarName',
                            data: 
                            {
                                'student_avatar_name':$('#student_avatar_name').val()
                            },
                            type: 'POST',
                            success: function (data) {
                                if (data.result == "error") {                               
                                 $('.custom_error').remove();
                                 $("#student_avatar_name").after('<label class="selected-error-fields custom_error" id="student_avatar_name-error">'+data.error_msg+'</label>');
                                } else {
                                     $('.custom_error').remove();
                                }
                            }
                        });

            }) 


        });


var addmodalstudentscroll = '.addmodalstudentscroll';
containerHeightTemp(addmodalstudentscroll)
//rightFlyoutContainerHeightTemp();
customScroll();
function containerHeightTemp(selector) {
    setTimeout(function () {
        var totalHeight = $('.modal-content:visible').outerHeight(true),
                bufferH = 26,
                profileDetailsH = $('.top-section:visible').outerHeight(true) 
                                    + $('.modal-footer:visible').outerHeight(true) 
                                    + parseInt($('.modal-dialog:visible').css('margin-top'));


        var calculatedHeight = totalHeight - (profileDetailsH) - 150;
     

        $(selector+":visible").css('height', calculatedHeight+'px');
    }, 200);
}
</script>