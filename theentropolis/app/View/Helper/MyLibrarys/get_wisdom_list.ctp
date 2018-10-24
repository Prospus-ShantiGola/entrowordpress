<?php $SessionParentChildId = array();
if(!empty($this->request->data['groupcode_search'])){
	$groupCode = $this->request->data['groupcode_search'];
	$group_code_user_id = substr($group_code_user_id,0,-1);
	$SessionParentChildId = array_unique(explode(",",$group_code_user_id));
	pr($SessionParentChildId);
}

if($fetch_type != 'loadmore') { ?>
<div class="tab-pane active" id="<?php echo $tab_name; ?>" >
    <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  ">
                                    <thead>
                                        <tr class="set-border">                                           
                                            <th>Sub-Category</th>
                                            <th>Date</th>
                                            <th>Posted By</th>
                                            <th>Title</th>
                                            <th>Rating</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="wisdom-wrap">
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6">
                                                                <?php echo $this->Html->image('eluminate-icon.png');?><span>E|Icon Wisdom</span>
                                                                <?php  if($eluminati_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="align-right"  data-type = "Eluminati" data-count ="<?php echo $eluminati_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php  
														
														if(!empty($eluminati_data)) { 
                                                         //   pr($eluminati_data);
                                                           foreach($eluminati_data as $rec) { 
                                                            $result = $this->Eluminati->getEluminatiUser($rec['EluminatiDetail']['eluminati_id']);
                                                        
                                                            $rating_count = $this->Rating->eluminatiRatingCount($rec['EluminatiDetail']['id']).' / 10';

                                                         ?>
                                         
                                                        <tr class="get-eluminati-modal" data-type="Eluminati" data-id="<?php echo $rec['EluminatiDetail']['id'];?>" data-owner = "<?php echo $rec['EluminatiDetail']['eluminati_id'];?>" data-direction="right">
                                                            <td title="<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                                            <td><?php echo date('M j, Y', strtotime($rec['EluminatiDetail']['date_published']));?></td>
                                                            <td><?php echo @$result['Eluminati']['first_name']." ".@$result['Eluminati']['last_name']; ?></td>
                                                            <td title="<?php echo $rec['EluminatiDetail']['source_name'];?>"><a><?php echo $this->Eluminati->text_cut($rec['EluminatiDetail']['source_name'], $length = 25, $dots = true); ?></a></td>

                                                            <td><?php echo  $rating_count; ?> </td>
                                                         
                                                            <td>
                                                                <a ><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php } } else { ?>
                                   
                                                        <tr>
                                                            <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                                        </tr>
                                                       
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6">
                                                                <?php echo $this->Html->image('sage-gray.png');?><span>Advice|Market</span>
                                                               <?php  if($advice_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="align-right"  data-type = "Advice" data-count ="<?php echo $advice_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                           <?php 
														   	if(!empty($advice_data)) {
                                                                  foreach($advice_data as $rec) { 
																	$rating_count = $this->Rating->getRating($rec['Advice']['id']).' / 10';
																
                                                         ?>
														 <?php if(empty($groupCode)){?>
														 <tr class="get-new-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Advice']['id'];?> data-type="Advice">
                                                            <td title="<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                                           <td><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));?></td>
                                                              <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                                                             <td title= "<?php echo $rec['Advice']['advice_title'];?>">
                                                <a ><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 25, $dots = true); ?></a></td>
                                                            <td><?php echo $rating_count; ?>
                                                            </td>
                                                            <td>
                                                                <a><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
														 
														 <?php } else {?>
														 
														 <?php if(in_array($rec['ContextRoleUser']['User']['id'],$SessionParentChildId)){?>
                                                        <tr class="get-new-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Advice']['id'];?> data-type="Advice">
                                                            <td title="<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                                           <td><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));?></td>
                                                              <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                                                             <td title= "<?php echo $rec['Advice']['advice_title'];?>">
                                                <a ><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 25, $dots = true); ?></a></td>
                                                            <td><?php echo $rating_count; ?>
                                                            </td>
                                                            <td>
                                                                <a><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
														 <?php } else {?>
														 
														 <tr class="get-data-network-advice-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Advice']['id'];?> data-type="Advice" data-username="<?php  echo $rec['ContextRoleUser']['User']['username'] ?>" data-userid="<?php echo $rec['ContextRoleUser']['User']['id'] ?>">
                                                            <td title="<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                                           <td><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));?></td>
                                                              <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                                                             <td title= "<?php echo $rec['Advice']['advice_title'];?>">
                                                <a><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 25, $dots = true); ?></a></td>
                                                            <td><?php echo $rating_count; ?>
                                                            </td>
                                                            <td>lock</td>
                                                        </tr>
														 
														 <?php } }?>
                                                        <?php } } else { ?>
                                   
                                                        <tr>
                                                            <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                                        </tr>
                                                       
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6">
                                                                <?php echo $this->Html->image('seeker-icon.png');?><span>Decision|Bank</span>
                                                                <?php   if($hindsight_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="align-right"   data-type = "Hindsight" data-count ="<?php echo $hindsight_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                         <?php  
														 
														 if(!empty($hindsight_data)) {

                                                             foreach($hindsight_data as $rec) { 
																?>
																<?php if(empty($groupCode)){?>
																<tr class="get-data-seeker-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Hindsight']['id'];?> data-type="Hindsight" >
                                                             <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                                                <td><?php echo date('M j, Y', strtotime($rec['Hindsight']['hindsight_decision_date']));?></td>
                                                                <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                                                                <td title= "<?php echo $rec['Hindsight']['hindsight_title'];?>">
                                                                    <a><?php echo $this->Eluminati->text_cut($rec['Hindsight']['hindsight_title'], $length = 25, $dots = true); ?></a>
                                                                </td>
                                                                <td><?php echo $this->Rating->getHindsightRating($rec['Hindsight']['id']);?> / 10<br /></td>
                                                                <td><a><i class="fa fa-eye"></i></a></td>
                                                        </tr>
																<?php } else {?>
																
																
														<?php if(in_array($rec['ContextRoleUser']['User']['id'],$SessionParentChildId)){?>
                                                        <tr class="get-data-seeker-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Hindsight']['id'];?> data-type="Hindsight" >
                                                             <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                                                <td><?php echo date('M j, Y', strtotime($rec['Hindsight']['hindsight_decision_date']));?></td>
                                                                <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                                                                <td title= "<?php echo $rec['Hindsight']['hindsight_title'];?>">
                                                                    <a><?php echo $this->Eluminati->text_cut($rec['Hindsight']['hindsight_title'], $length = 25, $dots = true); ?></a>
                                                                </td>
                                                                <td><?php echo $this->Rating->getHindsightRating($rec['Hindsight']['id']);?> / 10<br /></td>
                                                                <td><a><i class="fa fa-eye"></i></a></td>
                                                        </tr>
										  <?php } else {?>
										  
													<tr class="get-data-network-hindsight-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Hindsight']['id'];?> data-type="Hindsight" data-username="<?php  echo $rec['ContextRoleUser']['User']['username'] ?>" data-userid="<?php echo $rec['ContextRoleUser']['User']['id'] ?>">
                                                             <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                                                <td><?php echo date('M j, Y', strtotime($rec['Hindsight']['hindsight_decision_date']));?></td>
                                                                <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                                                                <td title= "<?php echo $rec['Hindsight']['hindsight_title'];?>">
                                                                    <a><?php echo $this->Eluminati->text_cut($rec['Hindsight']['hindsight_title'], $length = 25, $dots = true); ?></a>
                                                                </td>
                                                                <td><?php echo $this->Rating->getHindsightRating($rec['Hindsight']['id']);?> / 10<br /></td>
                                                             <td>lock</td>
                                                        </tr>
										  
																<?php } } ?>
                                                         <?php } } 
                                                         else { ?>
                                   
                                                            <tr>
                                                                <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                                            </tr>
                                                           
                                                            <?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed   table-data-remove">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6">
                                                                <?php echo $this->Html->image('EC2.png');?><span>E|C<sup>2</sup></span>
                                                               <?php  if($publication_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="align-right"  data-type = "Publiaction" data-count ="<?php echo $publication_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                             <?php  
															 
															 if(!empty($publication_data)) {
                                                                //pr($publication_data);
                                                             foreach($publication_data as $rec) { ?>
                                                         <?php 
															if($rec['Publication']['user_id']!=0){?>
															
															<?php if(empty($groupCode)){ ?>
															
															<tr class="get-data-wisdom-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Publication']['id'];?> data-type="Wisdom">
																													 
																	<td title= "<?php echo $rec['Category']['category_name'];?>">
																	<?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
																   <td><?php echo date('M j, Y', strtotime($rec['Publication']['date_published']));?></td>
																  <td><?php if($rec['User']['first_name']!=''){
																  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ;
																  } else {
																  echo @$rec['Publication']['author_first'];
																  }
																  ?></td>
																	<td title="<?php echo @$rec['Publication']['source_name']?>">
																	<a ><?php echo $this->Eluminati->text_cut($rec['Publication']['source_name'], $length = 25, $dots = true); ?></a></td>
																	<td><?php echo $this->Rating->getWisdomRating($rec['Publication']['id']); ?> / 10<br>
																	</td>
																	<td>
																		<a><i class="fa fa-eye" ></i></a>
																		<?php if($rec['Publication']['user_id']==$this->Session->read('user_id')){?>
																		<a href="javascript:void(0)" class="edit-wisdom" data-id="<?php echo $rec['Publication']['id'];?> "><i class="fa fa-pencil" style="width:57%"></i></a>
																		<?php }?>
																	</td>
																</tr>
															<?php } else {?>
															
															<?php if(in_array($rec['Publication']['user_id'],$SessionParentChildId)){?>
															 <tr class="get-data-wisdom-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Publication']['id'];?> data-type="Wisdom">
																													 
																	<td title= "<?php echo $rec['Category']['category_name'];?>">
																	<?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
																   <td><?php echo date('M j, Y', strtotime($rec['Publication']['date_published']));?></td>
																  <td><?php if($rec['User']['first_name']!=''){
																  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ;
																  } else {
																  echo @$rec['Publication']['author_first'];
																  }
																  ?></td>
																	<td title="<?php echo @$rec['Publication']['source_name']?>">
																	<a ><?php echo $this->Eluminati->text_cut($rec['Publication']['source_name'], $length = 25, $dots = true); ?></a></td>
																	<td><?php echo $this->Rating->getWisdomRating($rec['Publication']['id']); ?> / 10<br>
																	</td>
																	<td>
																		<a><i class="fa fa-eye" ></i></a>
																		<?php if($rec['Publication']['user_id']==$this->Session->read('user_id')){?>
																		<a href="javascript:void(0)" class="edit-wisdom" data-id="<?php echo $rec['Publication']['id'];?> "><i class="fa fa-pencil" style="width:57%"></i></a>
																		<?php }?>
																	</td>
																</tr>
															<?php } else {?>
															<tr class="get-data-network-wisdom-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Publication']['id'];?> data-type="Wisdom" data-username="<?php  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ?>" data-userid="<?php echo $rec['User']['id'] ?>">
																													 
																	<td title= "<?php echo $rec['Category']['category_name'];?>">
																	<?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
																   <td><?php echo date('M j, Y', strtotime($rec['Publication']['date_published']));?></td>
																  <td><?php if($rec['User']['first_name']!=''){
																  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ;
																  } else {
																  echo @$rec['Publication']['author_first'];
																  }
																  ?></td>
																	<td title="<?php echo @$rec['Publication']['source_name']?>">
																	<a><?php echo $this->Eluminati->text_cut($rec['Publication']['source_name'], $length = 25, $dots = true); ?></a></td>
																	<td><?php echo $this->Rating->getWisdomRating($rec['Publication']['id']); ?> / 10<br>
																	</td>
																	<td>
																		lock
																	</td>
																</tr>
															
															<?php } }?>
															 
															 <?php } else { ?>
															 
															 <tr>
																  <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
															   <td><?php echo date('M j, Y', strtotime($rec['Publication']['date_published']));?></td>
															  <td><?php if($rec['User']['first_name']!=''){
																		  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ;
																		  } else {
																		  echo @$rec['Publication']['author_first'];
																		  }
																		  ?></td>
																<td title="<?php echo @$rec['Publication']['source_name']?>"><a href="<?php  echo @$rec['Publication']['rss_feed']?>" target="_Blank"  class="" data-type="" data-id="" data-direction=""><?php echo $this->Eluminati->text_cut($rec['Publication']['source_name'], $length = 25, $dots = true); ?></a></td>
																<td>0 / 10<br>
																</td>
																<td>
																	<a href="<?php  echo @$rec['Publication']['rss_feed']  ?>" target="_Blank"  class="" data-type="" data-id="" data-direction=""><i class="fa fa-eye"></i></a>
																</td>
															</tr>
															 
															 
															 <?php } ?>
                                                             <?php } } 
                                                            else { ?>
                                   
                                                            <tr>
                                                                <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                                            </tr>
                                                           
                                                            <?php } ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
</div>
 <?php  echo '#$$#12'; }

//echo '#$$#'.$total;

  else {?>  
 <?php 
 if(!empty($eluminati_data)) { 

  foreach($eluminati_data as $rec) { 
        $result = $this->Eluminati->getEluminatiUser($rec['EluminatiDetail']['eluminati_id']);

    
        $rating_count = $this->Rating->eluminatiRatingCount($rec['EluminatiDetail']['id']).' / 10';

     ?>

    <tr class="get-eluminati-modal" data-type="Eluminati" data-id="<?php echo $rec['EluminatiDetail']['id'];?>" data-owner = "<?php echo $rec['EluminatiDetail']['eluminati_id'];?>" data-direction="right">
        <td title="<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
        <td><?php echo date('M j, Y', strtotime($rec['EluminatiDetail']['date_published']));?></td>
        <td><?php echo @$result['Eluminati']['first_name']." ".@$result['Eluminati']['last_name']; ?></td>
        <td title="<?php echo $rec['EluminatiDetail']['source_name'];?>"><a><?php echo $this->Eluminati->text_cut($rec['EluminatiDetail']['source_name'], $length = 25, $dots = true); ?></a></td>

        <td><?php echo  $rating_count; ?> </td>
     
        <td>
            <a><i class="fa fa-eye"></i></a>
        </td>
    </tr>
        <?php } 
echo '#$$#'.$eluminati_data_count;
    }
    if(!empty($advice_data)) {
                                                          
     foreach($advice_data as $rec) { 
  

  $rating_count = $this->Rating->getRating($rec['Advice']['id']).' / 10';

 ?>
 <?php if(empty($groupCode)){?>
		 <tr class="get-new-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Advice']['id'];?> data-type="Advice">
			<td title="<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
		   <td><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));?></td>
			  <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
			 <td title= "<?php echo $rec['Advice']['advice_title'];?>">
<a ><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 25, $dots = true); ?></a></td>
			<td><?php echo $rating_count; ?>
			</td>
			<td>
				<a><i class="fa fa-eye"></i></a>
			</td>
		</tr>
		 
		 <?php } else {?>

 
  <?php if(in_array($rec['ContextRoleUser']['User']['id'],$SessionParentChildId)){?>
<tr class="get-new-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Advice']['id'];?> data-type="Advice">
    <td title="<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
   <td><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));?></td>
      <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
     <td title= "<?php echo $rec['Advice']['advice_title'];?>">
<a><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 25, $dots = true); ?></a></td>
    <td><?php echo $rating_count; ?>
    </td>
    <td>
        <a><i class="fa fa-eye"></i></a>
    </td>
</tr>
  <?php } else {?>
  <tr class="get-data-network-advice-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Advice']['id'];?> data-type="Advice" data-username="<?php  echo $rec['ContextRoleUser']['User']['username'] ?>" data-userid="<?php echo $rec['ContextRoleUser']['User']['id'] ?>">
		<td title="<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
	   <td><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));?></td>
		  <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
		 <td title= "<?php echo $rec['Advice']['advice_title'];?>">
<a><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 25, $dots = true); ?></a></td>
		<td><?php echo $rating_count; ?>
		</td>
		<td>lock</td>
	</tr>
  <?php } }?>
<?php }
echo '#$$#'.$advice_data_count;

 }
  if(!empty($hindsight_data)) {

     foreach($hindsight_data as $rec) { 

        ?>
		
		<?php if(empty($groupCode)){?>
				<tr class="get-data-seeker-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Hindsight']['id'];?> data-type="Hindsight" >
			 <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
				<td><?php echo date('M j, Y', strtotime($rec['Hindsight']['hindsight_decision_date']));?></td>
				<td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
				<td title= "<?php echo $rec['Hindsight']['hindsight_title'];?>">
					<a><?php echo $this->Eluminati->text_cut($rec['Hindsight']['hindsight_title'], $length = 25, $dots = true); ?></a>
				</td>
				<td><?php echo $this->Rating->getHindsightRating($rec['Hindsight']['id']);?> / 10<br /></td>
				<td><a><i class="fa fa-eye"></i></a></td>
		</tr>
																<?php } else {?>
<?php if(in_array($rec['ContextRoleUser']['User']['id'],$SessionParentChildId)){?>
<tr class="get-data-seeker-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Hindsight']['id'];?> data-type="Hindsight" >
     <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
        <td><?php echo date('M j, Y', strtotime($rec['Hindsight']['hindsight_decision_date']));?></td>
        <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
        <td title= "<?php echo $rec['Hindsight']['hindsight_title'];?>">
            <a ><?php echo $this->Eluminati->text_cut($rec['Hindsight']['hindsight_title'], $length = 25, $dots = true); ?></a>
        </td>
        <td><?php echo $this->Rating->getHindsightRating($rec['Hindsight']['id']);?> / 10<br /></td>
        <td><a ><i class="fa fa-eye"></i></a></td>
</tr>
<?php } else {?>
<tr class="get-data-network-hindsight-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Hindsight']['id'];?> data-type="Hindsight" data-username="<?php  echo $rec['ContextRoleUser']['User']['username'] ?>" data-userid="<?php echo $rec['ContextRoleUser']['User']['id'] ?>">
	 <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
		<td><?php echo date('M j, Y', strtotime($rec['Hindsight']['hindsight_decision_date']));?></td>
		<td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
		<td title= "<?php echo $rec['Hindsight']['hindsight_title'];?>">
			<?php echo $this->Eluminati->text_cut($rec['Hindsight']['hindsight_title'], $length = 25, $dots = true); ?>
		</td>
		<td><?php echo $this->Rating->getHindsightRating($rec['Hindsight']['id']);?> / 10<br /></td>
	 <td>lock</td>
</tr>
	<?php }} ?>
 <?php }
echo '#$$#'.$hindsight_data_count;

  } 

  if(!empty($publication_data)) {
        //pr($publication_data);
     foreach($publication_data as $rec) { ?>
	 <?php if($rec['Publication']['user_id']!=0){?>
 <?php if(empty($groupCode)){ ?>
															
		<tr class="get-data-wisdom-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Publication']['id'];?> data-type="Wisdom">
																 
				<td title= "<?php echo $rec['Category']['category_name'];?>">
				<?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
			   <td><?php echo date('M j, Y', strtotime($rec['Publication']['date_published']));?></td>
			  <td><?php if($rec['User']['first_name']!=''){
			  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ;
			  } else {
			  echo @$rec['Publication']['author_first'];
			  }
			  ?></td>
				<td title="<?php echo @$rec['Publication']['source_name']?>">
				<a ><?php echo $this->Eluminati->text_cut($rec['Publication']['source_name'], $length = 25, $dots = true); ?></a></td>
				<td><?php echo $this->Rating->getWisdomRating($rec['Publication']['id']); ?> / 10<br>
				</td>
				<td>
					<a><i class="fa fa-eye" ></i></a>
					<?php if($rec['Publication']['user_id']==$this->Session->read('user_id')){?>
					<a href="javascript:void(0)" class="edit-wisdom" data-id="<?php echo $rec['Publication']['id'];?> "><i class="fa fa-pencil" style="width:57%"></i></a>
					<?php }?>
				</td>
			</tr>
		<?php } else {?>
		
		<?php if(in_array($rec['Publication']['user_id'],$SessionParentChildId)){?>
		 <tr class="get-data-wisdom-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Publication']['id'];?> data-type="Wisdom">
																 
				<td title= "<?php echo $rec['Category']['category_name'];?>">
				<?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
			   <td><?php echo date('M j, Y', strtotime($rec['Publication']['date_published']));?></td>
			  <td><?php if($rec['User']['first_name']!=''){
			  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ;
			  } else {
			  echo @$rec['Publication']['author_first'];
			  }
			  ?></td>
				<td title="<?php echo @$rec['Publication']['source_name']?>">
				<a ><?php echo $this->Eluminati->text_cut($rec['Publication']['source_name'], $length = 25, $dots = true); ?></a></td>
				<td><?php echo $this->Rating->getWisdomRating($rec['Publication']['id']); ?> / 10<br>
				</td>
				<td>
					<a><i class="fa fa-eye" ></i></a>
					<?php if($rec['Publication']['user_id']==$this->Session->read('user_id')){?>
					<a href="javascript:void(0)" class="edit-wisdom" data-id="<?php echo $rec['Publication']['id'];?> "><i class="fa fa-pencil" style="width:57%"></i></a>
					<?php }?>
				</td>
			</tr>
		<?php } else {?>
		<tr class="get-data-network-wisdom-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Publication']['id'];?> data-type="Wisdom" data-username="<?php  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ?>" data-userid="<?php echo $rec['User']['id'] ?>">
																 
				<td title= "<?php echo $rec['Category']['category_name'];?>">
				<?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
			   <td><?php echo date('M j, Y', strtotime($rec['Publication']['date_published']));?></td>
			  <td><?php if($rec['User']['first_name']!=''){
			  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ;
			  } else {
			  echo @$rec['Publication']['author_first'];
			  }
			  ?></td>
				<td title="<?php echo @$rec['Publication']['source_name']?>">
				<a><?php echo $this->Eluminati->text_cut($rec['Publication']['source_name'], $length = 25, $dots = true); ?></a></td>
				<td><?php echo $this->Rating->getWisdomRating($rec['Publication']['id']); ?> / 10<br>
				</td>
				<td>
					lock
				</td>
			</tr>
		
		<?php } }?>
 
 <?php } else { ?>
 
 <tr>
      <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
   <td><?php echo date('M j, Y', strtotime($rec['Publication']['date_published']));?></td>
  <td><?php if($rec['User']['first_name']!=''){
			  echo $rec['User']['first_name']. ' '.$rec['User']['last_name'] ;
			  } else {
			  echo @$rec['Publication']['author_first'];
			  }
			  ?></td>
    <td title="<?php echo @$rec['Publication']['source_name']?>"><a href="<?php  echo @$rec['Publication']['rss_feed']?>" target="_Blank"  class="" data-type="" data-id="" data-direction=""><?php echo $this->Eluminati->text_cut($rec['Publication']['source_name'], $length = 25, $dots = true); ?></a></td>
    <td>0 / 10<br>
    </td>
    <td>
        <a href="<?php  echo @$rec['Publication']['rss_feed']  ?>" target="_Blank"  class="" data-type="" data-id="" data-direction=""><i class="fa fa-eye"></i></a>
    </td>
</tr>
 
 
 <?php } ?>
 
 
     <?php }
echo '#$$#'.$publication_data_count;

      } 


    ?>
<?php } ?>   

