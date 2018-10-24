


<div id="addStudentFlyout" class="modal fade right student-add-details add-student-fly"  >    
</div>


<script type="text/javascript">

$('body').on('change','#addStudentFlyout input,select', function(){
   $('#addStudentFlyout #addStudent').removeClass('form-edited');
   $('#addStudentFlyout #addStudent').addClass('form-edited');
});

$('body').on('click','#addStudentFlyout .close-student-modal',function(){  
    
    if($('#addStudentFlyout #addStudent').hasClass('form-edited')){        
        bootbox.dialog({
        title: 'Confirmation',
        message: "Are you sure want to cancel?",
        buttons: {
            noclose: {
            label: "Yes", 
            className:'btn-default',    
           
            callback: function(){   

            $('#addStudentFlyout #addStudent').removeClass('form-edited');
            $('#addStudentFlyout').modal('hide');  
             
            }
        },
            ok: {
            label: "No",
            className:'btn-default', 
           
            callback: function(){
        

            }
            }
            }
        });        
    }
    else
    {
        $('#addStudentFlyout').modal('hide');
    }
})


$('body').on('click','.view-student-info,.kid-edit-modal',function(){
    var student_id = $(this).data('id');
    $.ajax({
      url:'<?php echo Router::url(array("controller"=>"users", "action"=>"getStudentInfo"));?>',
       
        data: {
            'student_id':student_id,
            'role':$(this).data('role'),
            'action':$(this).data('action'),
            'formtitle':$(this).data('formtitle')
        },
        type: 'POST',
        success: function (data) {
      

                $('#addStudentFlyout').modal('show');
                $('#addStudentFlyout').html(data);
                addKidpreneurForm.init();

        }
    });
})

</script>