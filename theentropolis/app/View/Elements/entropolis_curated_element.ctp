<!--  <?php if ($rec['Publication']['user_id'] != 0) { 
if ($rec['Publication']['network_type'] == 1) { 

  } else { 
 if (in_array($rec['Publication']['user_id'], $SessionParentChildId)) { 

 } else {


 }
}

 } else { 

  } ?>
 -->


<?php if ($rec['Publication']['user_id'] != 0) { 

    $modal_open_class = 'get-data-wisdom-modal';
    $var_href = 'javascript:void(0)';
 }else{
     $modal_open_class = '';
      $var_href  = @$rec['Publication']['rss_feed']. '"target="_Blank"';
 }?>



<tr>
    <td title= "<?php echo $rec['Category']['category_name']; ?>">
    <?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
    <td><?php echo date('M j, Y', strtotime($rec['Publication']['date_published'])); ?></td>
    <td><?php
    if ($rec['User']['first_name'] != '') {
    echo $rec['User']['first_name'] . ' ' . $rec['User']['last_name'];
    } else {
    echo @$rec['Publication']['author_first'];
    }
    ?></td>
    <td title="<?php echo @$rec['Publication']['source_name'] ?>">
    <span class="titleClr" ><?php echo $this->Eluminati->text_cut($rec['Publication']['source_name'], $length = 25, $dots = true); ?></span></td>
    <td><?php echo $this->Rating->getWisdomRating($rec['Publication']['id']); ?> / 10<br>
    </td>


    <td>

    <div class="flex-parent">
    <div class="flex-child flex-fix">


        <a href="<?php echo $var_href; ?> " class="<?php echo  $modal_open_class ?>" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Publication']['id']; ?> data-type="Wisdom">
            <i class="icons view-icon" data-toggle="tooltip" data-placement="left" title="View"></i>
        </a>

        </div>

    <?php if($rec['Publication']['user_id'] == $this->Session->read('user_id')){?>
    <div class="flex-child flex-fix ">


        <a href="javascript:void(0)" class="edit-wisdom" data-id="<?php echo $rec['Publication']['id']; ?> "><i class="fa fa-pencil" data-toggle="tooltip" data-placement="left" title="Edit" ></i></a>


  
    </div>
    <?php } $disbleCls = ($rec['Blog']['object_id'] == $rec['Publication']['id'] && $rec['Publication']['user_id'] == $this->Session->read('user_id'))? "": "disabled";?>
    <div class="flex-child flex-fix <?php echo $disbleCls;?>">


        <a data-advice-id ="<?php echo $rec['Publication']['id']; ?>" data-id ="<?php echo $rec['Blog']['id']; ?>" data-href="javascript:void(0)" class="delete-wisdom-blog-data"><i class="icons delete-blog" data-toggle="tooltip" data-placement="left" title="Blog"></i></a>

        </div>
        </div>

    </td>
</tr>