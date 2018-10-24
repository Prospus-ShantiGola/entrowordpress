<?php $SessionParentChildId = array();
if(!empty($this->request->data['groupcode_search'])){
	$groupCode = $this->request->data['groupcode_search'];
	}
	$group_code_user_id = substr($group_code_user_id,0,-1);
	$SessionParentChildId = array_unique(explode(",",$group_code_user_id));

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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="wisdom-wrap td-height-fix">
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings">
                                                                <?php echo $this->Html->image('svg-icons/superhero.svg'); ?><span>Superhero | Wisdom</span>
                                                                <?php  if($eluminati_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="btn align-right"  data-type = "Eluminati" data-count ="<?php echo $eluminati_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="custom_scroll maxHeight400">
                                                        <?php  
														
														if(!empty($eluminati_data)) { 
                                                         //   pr($eluminati_data);
                                                           foreach($eluminati_data as $rec) 
                                                               { 
                                                                 echo $this->element('superhero_wisdom_element',array('rec'=>$rec)); 
                                                             } } else { ?>
                                   
                                                        <tr>
                                                            <td class="td-height-fix" colspan= '6' style = "text-align:center;">No records found.</td>
                                                        </tr>
                                                       
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings td-height-fix">
                                                                <?php echo $this->Html->image('svg-icons/advice.svg');?><span>Advice</span>
                                                               <?php  if($advice_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="btn align-right"  data-type = "Advice" data-count ="<?php echo $advice_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="custom_scroll maxHeight400">
                                                           <?php 
														   	if(!empty($advice_data)) {
                                                                  foreach($advice_data as $rec) { 

																	echo $this->element('educator_experience_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId) );
                                                                } } else { ?>
                                   
                                                        <tr>
                                                            <td class="td-height-fix" colspan= '6' style = "text-align:center;">No records found.</td>
                                                        </tr>
                                                       
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings">
                                                                <?php echo $this->Html->image('svg-icons/hindsight.svg');?><span> Mentor Advice</span>
                                                                <?php   if($hindsight_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="btn align-right"   data-type = "Hindsight" data-count ="<?php echo $hindsight_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="custom_scroll maxHeight400">
                                                         <?php  
														 
														 if(!empty($hindsight_data)) {

                                                             foreach($hindsight_data as $rec) { 
                                                                 echo $this->element('mentor_advice_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId) );
																} } 
                                                         else { ?>
                                   
                                                            <tr>
                                                                <td class="td-height-fix" colspan= '6' style = "text-align:center;">No records found.</td>
                                                            </tr>
                                                           
                                                            <?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed remove-scroll  table-data-remove">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings">
                                                               <?php echo $this->Html->image('svg-icons/trepicity-curated.svg'); ?><span>Entropolis | Curated</span>
                                                               <?php  
															   
															   if($publication_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="btn align-right"  data-type = "Publication" data-count ="<?php echo $publication_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                   <tbody class="custom_scroll maxHeight400">
                                                        
                                                             <?php  
                                                             
                                                             if(!empty($publication_data)) {
                                                                //pr($publication_data);
                                                             foreach($publication_data as $rec) { 
                                                                echo $this->element('entropolis_curated_element',array('rec'=>$rec) );
                                                            
                                                                } } 
                                                            else { ?>
                                   
                                                            <tr>
                                                                <td class="td-height-fix" colspan= '6' style = " text-align:center;">No records found.</td>
                                                            </tr>
                                                           
                                                            <?php } ?>
                                                        
                                                    </tbody>
                                </table>

                                 <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings">
                                                                <?php echo $this->Html->image('svg-icons/trepicity-curated.svg'); ?><span>Kidpreneur Library</span>

                                                                <?php if ($kidlib_data_count > 2) { ?>
                                                                    <a href="javascript:void(0);" id="loadmorebutton" onclick="loadmoredata(this);" class="btn align-right" data-type = "KidLibrary" data-count ="<?php echo $kidlib_data_count; ?>">Show More</a>
<?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="custom_scroll maxHeight400">

                                                        <?php
                                                               //   pr($kidlib_data); echo 'sasa';
                                                        if (!empty($kidlib_data)) {
                                                            //pr($kidlib_data);
                                                            foreach ($kidlib_data as $rec) {
                                                               echo $this->element('entropolis_curated_element',array('rec'=>$rec) );
                                                           }
                                                        } else {
                                                            ?>

                                                            <tr>
                                                                <td class="td-height-fix" colspan= '7' style = "text-align:center;">No records found.</td>
                                                            </tr>

<?php } ?>

                                                    </tbody>
                                                </table>
</div>
 <?php  echo '#$$#12'; }

//echo '#$$#'.$total;

  else {?>  
 <?php 
 if(!empty($eluminati_data)) { 

  foreach($eluminati_data as $rec) { 
         echo $this->element('superhero_wisdom_element',array('rec'=>$rec)); 
       } 
echo '#$$#'.$eluminati_data_count;
    }
    if(!empty($advice_data)) {
                                                          
     foreach($advice_data as $rec) { 
    echo $this->element('educator_experience_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId) );

  } 
echo '#$$#'.$advice_data_count;

 }
  if(!empty($hindsight_data)) {

     foreach($hindsight_data as $rec) { 
         echo $this->element('mentor_advice_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId) );
 }
echo '#$$#'.$hindsight_data_count;

  } 
 if(!empty($publication_data)) {
        //pr($publication_data);
     foreach($publication_data as $rec) { 
        
        echo $this->element('entropolis_curated_element',array('rec'=>$rec) );
      }
echo '#$$#'.$publication_data_count;

      } 

 if(!empty($kidlib_data)) {
        //pr($kidlib_data);
     foreach($kidlib_data as $rec) { 
        
        echo $this->element('entropolis_curated_element',array('rec'=>$rec) );
      }
echo '#$$#'.$kidlib_data_count;

      } 



       } ?>   
