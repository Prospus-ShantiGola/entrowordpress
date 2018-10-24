<div class="col-md-10 content-wraaper admin-wrap">      
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title take_tour_title relative">
            <h1> Start Here</h1>
            <?php 
            //if ($flagAdd) {
            echo $this->Html->link('Add Video',array('controller'=>'tourVideos','action'=>'add'),array('class'=>'right btn btn-orange-small start-here-vd '.$addBtnStatus.'')); 
            //} ?>

        </div>   
        <div class="table-wrap" id="postsPaging">
            <table class="table table-striped eluminati-table table-hover user-table action-table take_tour_list" cellspacing="0" cellpadding="0" width="100%">
                <thead>
                    <tr>
                        <th>&nbsp;<?php echo ('S.No'); ?></th>
                        <th><?php echo ('Tag'); ?></th>
                        <th><?php echo ('Title'); ?></th>
                        <th><?php echo ('URL'); ?></th>
                        <th><?php echo ('Created Date'); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                </thead>
            <?php 
            $i = 1;
            foreach ($tourVideos as $tourVideo) { ?>
                <tr>
                    <td>&nbsp;<?php echo ($i++);?></td>
                    <td>
			<?php echo $tourVideo['Tag']['tag_name']; ?>
                    </td>
                    <td><?php echo h($tourVideo['TourVideo']['title']); ?>&nbsp;</td>
                    <td><?php echo h($tourVideo['TourVideo']['video_url']); ?>&nbsp;</td>
                    <td><?php echo h(date('M d, Y', strtotime($tourVideo['TourVideo']['timestamp']))); ?>&nbsp;</td>
                    <td class="actions">
                        <a href="edit/<?=$tourVideo['TourVideo']['id']?>"  data-id ="<?php echo $tourVideo['TourVideo']['id'];?>"><i class="icons edit-icon" data-toggle="tooltip" data-placement="left" title="Edit"></i></a>
			 
                        <?php if($tourVideo['TourVideo']['tag_id']!=6){?><a href="javascript:void(0);" class= 'delete-eluminati' data-id ="<?php echo $tourVideo['TourVideo']['id'];?>"><i class="icons delete-icon" data-toggle="tooltip" data-placement="left" title="Delete"></i></a><?php }?>
                    </td>
                </tr>
            <?php } ?>
            </table>
        </div>
    </div>
</div> <!-- content-wraaper ends -->

<script type="text/javascript">
    jQuery(document).ready(function () {

        jQuery("body").on("click", '.delete-eluminati', function () {
            var obj = jQuery(this);
            var vidHtml = '';
            var vid_id = jQuery(this).data('id');
            //var page_title = jQuery(this).closest ('tr').find('.page-title').attr('value'); 
            bootbox.dialog({
                title: 'Confirm Deletion',
                message: "Are you sure delete this video?",
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function () {
                            jQuery.ajax({
                                type: 'POST',
                                url: '<?php echo Router::url(array('controller'=>'tourVideos', 'action'=>'delete'));?>',
                                data:
                                    {
                                        'vid_id': vid_id
                                    },
                                success: function (data)
                                {
                                    location.reload();
                                    obj.closest('tr').remove();
                                    vidHtml = $.trim($("#postsPaging .table tbody tr").length);
//                                    if (vidHtml == 0) {
//                                        $("#postsPaging .table tbody").append('<tr><td colspan="8"> No records found.</td></tr>');
//                                    }
                                }
                            });
                        }
                    },
                    danger: {
                        label: "No",
                        className: "btn-black"
                    }
                }
            });
        });
    });
</script>