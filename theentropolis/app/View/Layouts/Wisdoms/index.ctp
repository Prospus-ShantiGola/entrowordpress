<?php  $SessionParentChildId = array();
	 	$group_code_user_id = substr($group_code_user_id,0,-1);
		$SessionParentChildId = array_unique(explode(",",$group_code_user_id));
		
	?>

<style>
    .advanced-search-form{
    right:5px;
    }
    .arrow_box-a:after, .arrow_box:before{
    left:70%;
    }
</style>
 <div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>
<div class="col-md-10 content-wraaper">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title">
            <h1 style="text-transform:uppercase">Wisdom|Search & SHARE</h1>
        </div>
        <div class="home-display row">
            <div class="col-md-12">
                <div class="margin-bottom">
                    <p>Entropolis is powered by our comprehensive and fully curated archive of advice and hindsight wisdom published by our Citizens, and carefully selected and shared 3rd party articles. Wisdom|Search allows you to easily find information and advice to help you work through your business challenges. Our new  upgrade + ADD|3rd PARTY WISDOM makes it easy to share high value and helpful advice you find outside Entropolis with your fellow Citizens. Please read our <a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>" target= "_blank">guidelines</a> for sharing third party content.
                    </p>
                </div>                
                <div class="search-bar clearfix black-btn-wrap">
                    <div class="row">
                        <div class="col-md-8">
                            <?php echo $this->Form->create('Search', array('url'=>'#','id'=>'SearchFrm','class'=>"form-inline wisdom-form",'role'=>'form'));?>      
                            <div class="form-group" style="width:72.5%;">
                                <?php echo $this->Form->input('search_keyword_search', array('class'=>'form-control','id'=>'search_keyword_search', 'placeholder'=>"Search Data", 'style'=>'width:64%; margin-right:5px;', 'label'=>false, 'div'=>false));?> 
                                <?php echo $this->Form->input('user_id', array('options'=>$users,'class'=>'form-control', 'id'=>'user_id',  'style'=>'width:34%', 'label'=>false, 'div'=>false));?>      
                            </div>
                            <button type="button" class="btn search-bar-button1" onclick="search();" style="margin-left:-3px">Go</button>                          
                            </form>
                            <div class="right add-hindsight ">                               
                                <ul>
                                    <li style="font-size:21px;">|</li>
                                    <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
                                </ul>
                                <div class="advanced-search-form arrow_box-a" style="display: none;">
                                    <p>Advanced Search <span  style = 'float:right;'><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                    <form role="form" action="" role="form" method="post" action="" id = "AdvanceSearchFrm" >
                                        <div class="form-group">
                                            <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types, 'id' => 'advance_search_decision_type_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Category')); ?> 
                                        </div>
                                        <div class="form-group add-category" style="display: none;">
                                            <?php echo $this->Form->input('category_id', array('options' => array('' => 'Select Category'), 'id' => 'advance_search_category_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Sub-Category')); ?>  
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_keyword_search" placeholder="Keyword Search" name="advsearchtext"   title="Alphabets or numbers only" value="<?php echo (!isset($this->request->data['advsearchtext'])) ? '' : $this->request->data['advsearchtext'] ?>">
                                        </div>
										
										<div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_group_code_search" placeholder="Group Code" name="group_code"   title="Group Code" value="<?php echo (!isset($this->request->data['group_code'])) ? '' : $this->request->data['group_code'] ?>">
                                        </div>
										
                                        <button type="button" class="btn btn-black right closeAdvanceSearch">Cancel</button>
                                        <button type="submit" class="btn btn-black  margin-right right">Submit</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn search-bar-button1 right add-wisdom" data-toggle="modal" data-target="#add-third-party-wisdom">+ADD | 3rd PARTY WISDOM</button>                            
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-12 hindsight-tab ">
                <div class="categories-wrapper ask-ques-wrap clearfix">
                    <div class="cat-left-col" style="min-height: 446px;">
                        <h3>Category</h3>
                        <ul class="nav nav-tabs tabs  setting-tab">
                            <li class="active"><a href="#all-hindsights" data-toggle="tab" id="all-hindsights-tab" onclick="getListData('all-hindsights','','tab');">All</a></li>
							<?php foreach($decision_types as $key => $tab_name) {
							?> 
                            <?php if(strtoupper($tab_name)==strtoupper('Decision and Hindsight Category')) { ?> 
                            
                            <?php } else { $tabname = str_replace(array(' ',',','&','-'),'',$tab_name);?>
                            <li><a href="#<?php echo $tabname ?>" data-toggle="tab" id="<?php echo $tabname ?>-tab" onclick="getListData('<?php echo $tabname ?>', '<?php echo $key ?>','tab');"><?php echo $tab_name; ?></a></li>
                            <?php } ?>
                            <?php } ?>   
                        </ul>
                    </div>
                    <div class="cat-right-col">

                        <form name="loadDateFrm" id="loadDateFrm" method="Post" action="#" >
                            <input type="hidden" name="active_tab_name" id="active_tab_name">
                            <input type="hidden" name="active_tab_id" id="active_tab_id">
                            <input type="hidden" name="active_category_id" id="active_category_id">
							<input type="hidden" name="active_groupcode_search" id="active_groupcode_search">
                            <input type="hidden" name="active_keyword_search" id="active_keyword_search">
                            <input type="hidden" name="active_user_id" id="active_user_id" value="">
                              <input type="hidden" name="active_user_name" id="active_user_name" value="">
                        </form>
                        <div class="tab-content-hindsight">
                            <div class="tab-pane active" id="all-hindsights">
                               
                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed ">
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
                                                                <a href="javascript:void(0);" id="loadmorebutton" onclick="loadmoredata(this);" class="align-right" data-type = "Eluminati" data-count ="<?php echo $eluminati_data_count;?>">Show More</a>
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
                                                            <td>
															<?php 
															echo @$result['Eluminati']['first_name']." ".@$result['Eluminati']['last_name']; ?>
															</td>
                                                            <td title="<?php echo $rec['EluminatiDetail']['source_name'];?>"><a><?php echo $this->Eluminati->text_cut($rec['EluminatiDetail']['source_name'], $length = 25, $dots = true); ?></a></td>

                                                            <td><?php echo  $rating_count; ?> </td>
                                                         
                                                            <td>
                                                                <a><i class="fa fa-eye"></i></a>
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
                                                                  <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="align-right" data-type = "Advice"  data-count ="<?php echo $advice_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                           <?php  if(!empty($advice_data)) {
															foreach($advice_data as $rec) { 
                                                            $rating_count = $this->Rating->getRating($rec['Advice']['id']).' / 10';
															?>
															<?php if($rec['Advice']['network_type']==1){ ?>
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
															<?php  if(in_array($rec['ContextRoleUser']['User']['id'],$SessionParentChildId)){?>
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
                                                            <td><i class="fa fa-lock"></i></td>
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
                                                                <?php  if($hindsight_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton" onclick="loadmoredata(this);" class="align-right" data-type = "Hindsight" data-count ="<?php echo $hindsight_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                         <?php  if(!empty($hindsight_data)) {
                                                             foreach($hindsight_data as $rec) { ?>
                                          
										  
															<?php if($rec['Hindsight']['network_type']==1){ ?>
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
															<?php } else {?><?php if(in_array($rec['ContextRoleUser']['User']['id'],$SessionParentChildId)){?>
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
                                                             <td><i class="fa fa-lock"></i></td>
                                                        </tr>
										  
															<?php  } }?>
                                                         <?php } } 
                                                         else { ?>
                                   
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
                                                                <?php echo $this->Html->image('EC2.png');?><span>E|C<sup>2</sup></span>
                                                                <?php  if($publication_data_count>2) {?>
                                                                <a href="javascript:void(0);" id="loadmorebutton" onclick="loadmoredata(this);" class="align-right" data-type = "Publication" data-count ="<?php echo $publication_data_count;?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                             <?php  if(!empty($publication_data)) {
                                                                //pr($publication_data);
                                                             foreach($publication_data as $rec) { ?>
																<?php 
																
																if($rec['Publication']['user_id']!=0){?>
															<?php if($rec['Publication']['network_type']==1){ ?>
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
																		<i class="fa fa-lock"></i>
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
                            
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>  
</div>
<script type="text/javascript">

	$(".add-wisdom").on('click',function(){
	setTimeout(function(){
	if($('#add-third-party-wisdom').hasClass('in'))
	{   
						$("body").css({overflow:'hidden'});
						$("#add-third-party-wisdom").css({overflow:'hidden'});
						
	}
	},500);
	
	});
	
    $('body').on('change','#user_id', function(){
           $('#active_user_id').val(this.value);
           $('#active_user_name').val(jQuery('#user_id option:selected').text());
          // alert($('#active_user_name').val());
    });

     $('body').on('change','#advance_search_decision_type_id' , function(){
     jQuery('.add-category').show();
       $.ajax({
           url:'<?php echo $this->webroot?>DecisionBanks/decision_category/',
           data:{
             id:this.value
           },
           type:'get',
           success:function(data){ 
               $('#advance_search_category_id').html(data);
           }
           
       });
    });
        function getListData(tabname, decision_type_id, type, load_row,obj)
        { 
          $('.loading').show();  
		  $('.advanced-search-form').hide();
          if(type == 'tab' || type == 'advance_search')
          {    
               $('#active_tab_name').val(tabname);
               $('#active_tab_id').val(decision_type_id);
               
               if(type == 'tab')
               {    
                   $('#active_category_id').val('');
                   $('#active_keyword_search').val('');
                   $('#active_groupcode_search').val('');
               }
          }
          if(type=='loadmore')
          {
                var data_type  = $(obj).data('type');
          }
          else
          {
            var data_type  ='';
          }
          
        user_select = $('#active_user_name').val();

          jQuery.ajax({
               url:'<?php echo $this->webroot?>wisdoms/get_wisdom_list/',
               data:{
                 'tab_name':tabname,  
                 'decision_type_id':decision_type_id,
                 'fetch_type':type,
                 'category_id':$('#active_category_id').val(),
                 'keyword_search':$('#active_keyword_search').val(),
				 'groupcode_search':$('#active_groupcode_search').val(),
                 'load_row':load_row,
                 'owner_user_id':$('#active_user_id').val(),
                 'user_select':user_select,
                 'data_type':data_type
               },
               type:'POST',
               success:function(data){
             //   alert(data);1
                   $('.loading').hide();  
                   var dataarr = data.split('#$$#');
                   if(type=='loadmore')
                   {
                     // jQuery('.table tbody').append(dataarr[0]); 
                     $(obj).closest('.table-condensed').find('tbody').append(dataarr[0]); 
                     $(obj).data('count',dataarr[1]);
                      
                   }
                   else
                   {
                     jQuery('.tab-content-hindsight').html(dataarr[0]);  
                   }    
                   //var rowCount = $('.table-condensed >tbody >tr').length;
                   var rowCount = $(obj).closest('.table-condensed').find('tbody tr').length;
                  
                   var total_count =  $(obj).data('count');
                  
                   if(total_count <= rowCount)
                   {                  
                        $(obj).hide();
                      
                   }
                   else
                   {
                   
                       $(obj).show();
                   }
                    var colHIG = $('.cat-right-col').height();
                    $('.cat-left-col').css({minHeight: colHIG});
                    $('[data-toggle="tooltip"]').tooltip(); 
                         
                }
               
               
           });
        }
        
        function loadmoredata(obj) { 
          
           var tabname = $('#active_tab_name').val();
           var decision_type_id = $('#active_tab_id').val();
          
          
               $('.table-data-remove').each(function(){     
                var $this = $(this);
                if($this.get(0) != $(obj).closest('.table-condensed').get(0))
                {
                    
                    var row  = $this.find('tbody tr').length;
                    var total_cc = $this.find('tr > th >a').data('count');
                    //alert(total_cc)
                    if(row>2)
                    {
                        $this.find("tr:gt(2)").remove();
                         console.log($this.find('tr > th >a'));
                        if( row == total_cc)
                        {
                            $this.find('tr > th >a').show();
                        }
                    }
                    
                }
                
                
            });
          var rowCount = $(obj).closest('.table-condensed').find('tbody tr').length;

           // $('body').on('click','.update-view-status',function()
           //    {   $('body').css("overflow-y","auto") });

        //$('body').css("overflow-y","auto")
           getListData(tabname, decision_type_id, 'loadmore', rowCount,$(obj));
        }

       // jQuery('body').on('click','')
        
        function advanceSearch()
        {
            //$('#advance_search_keyword_search').val('');
            var tabname = $("#advance_search_decision_type_id option:selected").text();
          //  var tabname = tabname.replace(/\s/g, '');
            var tabname = tabname.replace(/[^A-Za-z0-9]/g, "");
			if(tabname=='Category'){
				tabname = 'all-hindsights';
			}
            var decision_type_id = $('#advance_search_decision_type_id').val();
            var category_id = $('#advance_search_category_id').val();
            var keyword_search = $('#advance_search_keyword_search').val();
			var groupcode_search = $('#advance_search_group_code_search').val();
            $('#active_tab_name').val(tabname);
            $('#active_tab_id').val(decision_type_id);
            $('#active_category_id').val(category_id);
            $('#active_keyword_search').val(keyword_search);
            $('#active_groupcode_search').val(groupcode_search);
            getListData(tabname, decision_type_id, 'advance_search',0);
            $('ul.tabs li').removeClass('active');
            $('#'+tabname+'-tab').closest('li').addClass('active');
            $('.advanced-search-form').hide();
            //alert(tabname + ' => ' + decision_type_id + ' => ' + category_id + '==> ' + keyword_search);
            // $('#advance_search_keyword_search').val('');
        }
        
        $('#AdvanceSearchFrm').bind("submit", function(e) {        
           e.preventDefault();
           advanceSearch();
           return false;
        
        });
        function search()
        {   
           
            var keyword_search = $('#search_keyword_search').val();
            var tabname = $('ul.tabs li.active a').attr('id'); 
            var tabname = $('#active_tab_name').val();
            var decision_type_id = $('#active_tab_id').val();
            $('#active_category_id').val('');
            $('#active_groupcode_search').val('');
            $('#active_keyword_search').val(keyword_search);
            getListData(tabname, decision_type_id, 'search',0);
        
        }
         $('#SearchFrm').bind("submit", function(e) {     
           e.preventDefault();
           search();
           return false;
        
        });
		
		
//# sourceURL=Wisdoms\index1.ctpjs
</script>    


<?php echo $this->element('third_party_wisdom_search');?>   