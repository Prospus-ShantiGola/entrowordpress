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
            <h1 style="text-transform:uppercase">My|Library</h1>
        </div>
        <div class="home-display row">
            <div class="col-md-12">    
                <div class="margin-bottom">
                    <p>Your private collection of wisdom to save for future reference. Build a comprehensive reference archive of valuable and up to date advice and hindsight wisdom from our continually expanding database to help you make better business decisions, expand your knowledge and identify connections at critical points in your entrepreneurial journey.</p>
                </div>            
                <div class="search-bar clearfix black-btn-wrap">
                    <div class="row">
                        <div class="col-md-8">
                          
                            <?php echo $this->Form->create('Search', array('url'=>'#','id'=>'SearchFrm','class'=>"form-inline",'role'=>'form'));?>      
                            <div class="form-group">
                                <?php echo $this->Form->input('search_keyword_search', array('class'=>'form-control','id'=>'search_keyword_search', 'placeholder'=>"Search Data", 'style'=>'width:64%; margin-right:5px;', 'label'=>false, 'div'=>false));?> 
                                <?php echo $this->Form->input('user_id', array('options'=>$users,'class'=>'form-control', 'id'=>'user_id',  'style'=>'width:34%', 'label'=>false, 'div'=>false));?>      
                            </div>
                            <button type="button" class="btn search-bar-button1" onclick="search();" style="margin-left:-3px">Go</button>
                            <?php echo $this->Form->end();?>


                        </div>
                         <div class="col-md-4">
                            <div class="right add-hindsight ">
                                <ul>
                                    <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
                                </ul>
                                <div class="advanced-search-form arrow_box-a" style="display: none;">
                                    <p>Advanced Search <span  style = 'float:right;'><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                    <form role="form" action="" role="form" method="post" action="" id = "AdvanceSearchFrm">
                                        <div class="form-group">
                                            <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types, 'id' => 'advance_search_decision_type_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Category', 'required' => 'required')); ?> 
                                        </div>
                                        <div class="form-group add-category" style="display: none;">
                                            <?php echo $this->Form->input('category_id', array('options' => array('' => 'Select Category'), 'id' => 'advance_search_category_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Sub-Category', 'required' => 'required')); ?>  
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_keyword_search" placeholder="Keyword Search" name="advsearchtext" required="required"  title="Alphabets or numbers only" data-placement = "left" value="<?php echo (!isset($this->request->data['advsearchtext'])) ? '' : $this->request->data['advsearchtext'] ?>">
                                        </div>
                                        <button type="button" class="btn btn-black right closeAdvanceSearch">Cancel</button>
                                        <button type="submit" class="btn btn-black  margin-right right">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-12 hindsight-tab ">
                <h2 class="orange">Showroom</h2>
                <div class="categories-wrapper ask-ques-wrap clearfix">
                    <div class="cat-left-col" style="min-height: 446px;">
                        <h3>Category</h3>
                         <ul class="nav nav-tabs tabs  setting-tab">
                            <?php foreach($decision_types as $key => $tab_name) { ?> 
                            <?php if(strtoupper($tab_name)==strtoupper('Decision and Hindsight Category')) { ?> 
                            <li class="active"><a href="#all-hindsights" data-toggle="tab" id="all-hindsights-tab" onclick="getListData('all-hindsights','','tab');">All</a></li>
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
                            <input type="hidden" name="active_keyword_search" id="active_keyword_search">
                            <input type="hidden" name="active_user_id" id="active_user_id" value="">
                        </form>
                        <div class="tab-content-hindsight">
                            <?php  if(!empty($library_data)) {  ?>
                                    <button type="button" name="advice" class="btn search-bar-button1 delete-advice" disabled="">Remove</button> 
                                 
                                     <?php } ?>                    
                            <div class="tab-pane active" id="all-hindsights">
                                <!--  <table class="table table-striped table-condensed my_challenge showroom-table" > -->
                                <table class="table table-striped advices-table library-wrap script-call main-table-wrap table-condensed  remove-scroll">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="check_all" name="" value=""></th>
                                            <th>Sub-Category</th>
                                            <th>Date</th>
                                            <th></th>
                                            <th>Posted By</th>
                                            <th>Title</th>
                                            <th>Rating</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php  //pr($library_data);
                                         //die;
										 $commonclass= '';$commonFlag= '0'; $i=-1; $objType= '';
                                         if(!empty($library_data)) { ?>
                                           <?php foreach($library_data as $keys=> $rec) { 
                                            
                                                 $category_ary = $this->Rating->getCategoryTitle($rec['MyLibrary']['category_id']);
                                                 if(strtoupper($rec['MyLibrary']['object_type']) == strtoupper('advice') )
                                                {
                                                    
													$objType = 'Advice';

													$image =  $this->Html->image('sage-gray.png');
                                                    $modal_class ='get-new-modal';
                                                    $rating_count = $this->Rating->getRating($rec['MyLibrary']['object_id']).' / 10';
                                                    $result =  $this->Advice->getAdviceByAdviceId($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['Advice']['advice_decision_date'])); 
													$userDetail = $this->Rating->UserInfo($rec['MyLibrary']['owner_user_id'],'Advice');
                                                    $full_name = $userDetail['User']['username'];
													if($result['Advice']['draft']=='1'){
														$commonclass = 'edit-advice-mylibrary';
														$commonFlag = '1';
                                                        $modal_class ='edit-advice-mylibrary';
													}

                                                    $blog_status = $rec['MyLibrary']['blog_status'];


                                                }
                                                else if(strtoupper($rec['MyLibrary']['object_type']) == strtoupper('hindsight')) {
													
                                                    $image = $this->Html->image('seeker-icon.png');
                                                    $modal_class ='get-data-seeker-modal';
                                                    $rating_count =  $this->Rating->getHindsightRating($rec['MyLibrary']['object_id']).' / 10';
                                                    $result =  $this->Advice->getHindsightByHindsightId($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['DecisionBank']['hindsight_decision_date'])); 
                                                    $userDetail = $this->Rating->UserInfo($rec['MyLibrary']['owner_user_id'],'Advice');
                                                    $full_name = $userDetail['User']['username'];
													 
													if($result['DecisionBank']['draft']=='1'){
														$commonclass = 'edit-hindsight-mylibrary';
														$commonFlag = '1';
														 $objType = 'Hindsight';
                                                         $modal_class ='edit-hindsight-mylibrary';
													}
                                                $blog_status = $rec['MyLibrary']['blog_status'];
												}
												
												else if(strtoupper($rec['MyLibrary']['object_type']) == strtoupper('wisdom')) {
													$objType = 'wisdom';
												  $userdata = $this->User->getUserData($rec['MyLibrary']['owner_user_id']);
																		
												   if($userdata['context_role_id']=='5'){
														$image = $this->Html->image('seeker-icon.png');
												   } else {
														$image = $this->Html->image('sage-gray.png');
												   }                                                    
													
                                                    $modal_class ='get-data-wisdom-modal';
                                                    $rating_count =  $this->Rating->getWisdomRating($rec['MyLibrary']['object_id']).' / 10';
                                                    $result =  $this->Advice->getWisdomByPublicationId($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['Publication']['date_published'])); 
                                                    $userDetail = $this->Rating->wisdomUserInfo($rec['MyLibrary']['owner_user_id'],'Wisdom');
                                                    $full_name = $userDetail['User']['username'];
													$commonFlag = 0;

                                                    $blog_status = $rec['MyLibrary']['blog_status'];
                                                }
												else
                                                {
                                                    $objType = 'eluminate';
													$image = $this->Html->image('eluminate-icon.png');
                                                    $modal_class ='get-eluminati-modal';
                                                    $rating_count = $this->Rating->eluminatiRatingCount($rec['MyLibrary']['object_id']).' / 10';

                                                    $userDetail = $this->Rating->UserInfo($rec['MyLibrary']['owner_user_id'],'Eluminati');
                                                    $full_name = $userDetail['Eluminati']['first_name']." ".$userDetail['Eluminati']['last_name'];
                                                    $result = $this->Eluminati->getEluminatiDetailById($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['EluminatiDetail']['date_published'])); 
													$commonFlag = 0;
                                                    $blog_status = '';

                                                } 
                                               //  pr($userDetail);

                                            ?>
                                         <tr class="<?php echo $modal_class; ?>" data-type="<?php echo $rec['MyLibrary']['object_type'] ?>" data-blogstatus = "<?php echo $blog_status ;?>" data-owner = "<?php echo $rec['MyLibrary']['owner_user_id']?>" data-id="<?php echo $rec['MyLibrary']['object_id'] ?>" data-direction="right" >
                                            <td><input type="checkbox" class="check-hindsight" name="MyLibrary[]" value="<?php echo $rec['MyLibrary']['id']; ?>"></td>
                                             <td title= "<?php echo $category_ary['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($category_ary['Category']['category_name'], $length = 10, $dots = true); ?></td>

                                            <td><?php echo $date ;?></td>
                                            <td> <?php echo $image; ?> </td>
                                            <td><?php echo $full_name; ?></td>

                                            <td title="<?php echo $rec['MyLibrary']['title'];?>"><a><?php echo $this->Eluminati->text_cut($rec['MyLibrary']['title'], $length = 25, $dots = true); ?></a></td>

                                            <td><?php echo $rating_count;?><br></td>

                                            <td>
                                                <?php if( $modal_class!='edit-hindsight-mylibrary' && $modal_class!='edit-advice-mylibrary' )
                                                {?>
                                                <a><i class="fa fa-eye"></i></a> 
                                                <?php } ?>                         
												<?php if( ($commonFlag == '1' && $objType == 'Advice') && $userDetail['User']['id']==$this->Session->read('user_id'))  {?>
												<a  data-id ="<?php echo $rec['MyLibrary']['object_id']; ?>" class="<?php echo $commonclass;?>" data-blogstatus = "<?php echo $blog_status ;?>"><i class="fa fa-pencil" ></i></a>
												<?php } ?>
												
												<?php if( ($commonFlag == '1' && $objType == 'Hindsight') && $userDetail['User']['id']==$this->Session->read('user_id'))  {?>
												
												<a  data-id ="<?php echo $rec['MyLibrary']['object_id']; ?>" class="<?php echo $commonclass;?> add-hindsight my_decisionbank"><i class="fa fa-pencil" ></i></a>
												<?php } ?>
                                            </td>
                                        </tr>
                                         <?php 
										 
										 if( ($commonFlag == '1' && $objType == 'Advice') && $userDetail['User']['id']==$this->Session->read('user_id'))  {
											$AdviceDetails = $this->Advice->getAdviceDetails($rec['MyLibrary']['object_id']);
											echo $this->element('edit_advice_modal_element', array('adviceData'=>$AdviceDetails));
										 }?>
										 
										 <?php 
										 if( ($commonFlag == '1' && $objType == 'Hindsight') && $userDetail['User']['id']==$this->Session->read('user_id'))  {
										 	$hindsightDetails = $this->Hindsight->getHindsightDetails($rec['MyLibrary']['object_id']);
											echo $this->element('edit_hindsight_modal_element', array('adviceInfoData'=>$hindsightDetails));
											
										 }?>
                                         <?php $i++;} ?>
                                    </tbody>
                                     <?php } else { ?>
                                     
                                    <tr>
                                        <td colspan= '8' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                    </tr>
                                 
                                     <?php } ?>
                                </table>
                            </div>
                               <?php if($total>10){?>
                            <div class="margin-bottom clearfix load-more-btn" id="loadmorebtn">
                                <button class="btn btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                            </div>
                             <?php }?>
                        </div>
                    </div>
                </div>
                <!-- categories-wrapper ends -->
                <!--  <div id="tabs" class="tabCls">
                    <span id="panLeft" class="panner" data-scroll-modifier='-1'><img src="/entropolis/img/arrow-left.png" alt="" /></span>
                    <span id="panRight" class="panner" data-scroll-modifier='1'><img src="/entropolis/img/arrow-right.png" alt="" /></span>
                    <div id="container-scroll" class="container-scroll">
                    
                        <div id="parent"> 
                            
                        </div>
                    </div>
                    
                    
                    
                    </div> -->
            </div>
        </div>
    </div>
</div>   

<script type="text/javascript">

    $('body').on('change','#user_id' , function(){
           $('#active_user_id').val(this.value);
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
    function getListData(tabname, decision_type_id, type, load_row)
        { 
		
          $('.loading').show();  
          if(type == 'tab' || type == 'advance_search')
          {    
               $('#active_tab_name').val(tabname);
               $('#active_tab_id').val(decision_type_id);
               
               if(type == 'tab')
               {    
                   $('#active_category_id').val('');
                   $('#active_keyword_search').val('');
               }
          }

         
          jQuery.ajax({
               url:'<?php echo $this->webroot?>myLibrarys/get_library/',
               data:{
                 'tab_name':tabname,  
                 'decision_type_id':decision_type_id,
                 'fetch_type':type,
                 'category_id':$('#active_category_id').val(),
                 'keyword_search':$('#active_keyword_search').val(),
                 'load_row':load_row,
                 'owner_user_id':$('#active_user_id').val()
               },
               type:'POST',
               success:function(data){
                   $('.loading').hide();  
                   var dataarr = data.split('#$$#');
                   if(type=='loadmore')
                   {
                      jQuery('.table tbody').append(dataarr[0]); 

                      
                   }
                   else
                   {
                     jQuery('.tab-content-hindsight').html(dataarr[0]);  
                   }    
                   var rowCount = $('.table-condensed >tbody >tr').length;
                   if(dataarr[1] <= rowCount)
                   {
                       $('#loadmorebtn').hide();
                      
                   }
                   else
                   {
                       $('#loadmorebtn').show();
                   }
				   
				   $(".feature-editor").each(function(i,v){
	
				
											
						CKEDITOR.instances[$(v).attr('id')].config.wordcount = {	
						// Whether or not you want to show the Word Count
						showWordCount: true,
					
						// Whether or not you want to show the Char Count
						showCharCount: false,
						
						showParagraphs: false,
				
						// Maximum allowed Word Count
						maxWordCount: 800,
						// Maximum allowed Char Count
						maxCharCount: 800,
						
						hardLimit: false
					 };
	   });	
                     var colHIG = $('.cat-right-col').height();
                       $('.cat-left-col').css({minHeight: colHIG});
    
                         
                }
               
               
           });
        }
        
        function loadmoredata() { 
           //alert("tab name=> "+$('#active_tab_name').val() + "tab id=> "+$('#active_tab_id').val());
           var tabname = $('#active_tab_name').val();
           var decision_type_id = $('#active_tab_id').val();
           var rowCount = $('.table-condensed >tbody >tr').length;
           getListData(tabname, decision_type_id, 'loadmore', rowCount);
        }
        
        function advanceSearch()
        {
            //$('#advance_search_keyword_search').val('');
            var tabname = $("#advance_search_decision_type_id option:selected").text();
          //  var tabname = tabname.replace(/\s/g, '');
             var tabname = tabname.replace(/[^A-Za-z0-9]/g, "");

            var decision_type_id = $('#advance_search_decision_type_id').val();
            var category_id = $('#advance_search_category_id').val();
            var keyword_search = $('#advance_search_keyword_search').val();
            $('#active_tab_name').val(tabname);
            $('#active_tab_id').val(decision_type_id);
            $('#active_category_id').val(category_id);
            $('#active_keyword_search').val(keyword_search);
            getListData(tabname, decision_type_id, 'advance_search',0);
            $('ul.tabs li').removeClass('active');
            $('#'+tabname+'-tab').closest('li').addClass('active');
            $('.advanced-search-form').hide();
            //alert(tabname + ' => ' + decision_type_id + ' => ' + category_id + '==> ' + keyword_search);
            $('#advance_search_keyword_search').val('');
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
            $('#active_keyword_search').val(keyword_search);
            getListData(tabname, decision_type_id, 'search',0);
        
        }
         $('#SearchFrm').bind("submit", function(e) {     
           e.preventDefault();
           search();
           return false;
        
        });
$(document).ready(function () {
      $('body').on('click','.check-hindsight',function(e){
        e.stopPropagation();
           var showThis = 0;
           $('.check-hindsight').each(function(){
               $this = $(this);
               if($this.is(':checked', true)){
    
              
    
                   showThis = 1;
                   return false;
               }
               else{
                   showThis = 0;
               }
    
    
           });
    
                var total_length = $('.check-hindsight').length;
                var total_checked_length = $('.check-hindsight:checked').length;
    
                if (total_length == total_checked_length) {
                    $(".check_all").prop( "checked", true );
                } 
                 else
                {
                    $(".check_all").prop( "checked", false );
                }
                   
           if(showThis == 1){
               $('.delete-advice').prop('disabled', false).css({opacity:'1'});
           }
           else{
               $('.delete-advice').prop('disabled', true).css({opacity:'0.2'});
               $(".check_all").prop( "checked", false );
           }
           
       });
    
    
     $('body').on('click','.delete-advice',function(){
         
          bootbox.dialog({
                title: "Confirm Deletion",
                message: "Are you sure you want to delete ?",            
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function() {
         
                             $('.loading').show();  
                             var data_val = '';
                             $('.check-hindsight').each(function(){ 
                                   $this = $(this);
                                   if($this.is(':checked', true)){
                                    if( data_val ==''){
                                      data_val = $this.val();
                                    }else{
                                       data_val = data_val+"~"+ $this.val();
                                    }
                                   }
                                   
                              });
    
                              jQuery.ajax({
                                   url:'<?php echo $this->webroot?>myLibrarys/deleteLibraryList/',
                                   data:{
                                      
                                     'data_val':data_val,
                                   
                                   },
                                   type:'POST',
                                   success:function(data){
                                      $('.loading').hide();  
                                      $('.check-hindsight').each(function(){ 
                                          $this = $(this);
                                          if($this.is(':checked', true)){
                                             $this.closest('tr').remove();

                                              $('.delete-advice').prop('disabled', true).css({opacity:'0.2'});
                                              $(".check_all").prop( "checked", false );
                                          }
                                      });               
                                   
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
    
       $('body').on('click','.check_all',function(e){
        e.stopPropagation();
          $this = $(this);
    
                  if($this.is(':checked', true)){
                    $('.check-hindsight').prop( "checked", true );
                     $('.delete-advice').prop('disabled', false).css({opacity:'1'});
               
               }else{
                  $('.check-hindsight').prop( "checked", false );
                    $('.delete-advice').prop('disabled', true).css({opacity:'0.2'});
               }
    
               // $('.check-hindsight').trigger('click');
          
    
       });
    });
	
	$(document).ready(function () {
	jQuery('body').on('click','.edit-hindsight-mylibrary',function(e){

        var $this = $(this);
        var data_id = $this.data("id"); 
        e.stopPropagation();
		
		// $(".hindsight-"+data_id).modal('show');
        $("#hindsight-"+data_id ).modal('show');
        $("#hindsight-"+data_id ).find( 'textarea.short_description_editor' ).ckeditor();
	    $("#hindsight-"+data_id ).find( 'textarea.hindsight_detail_editor' ).ckeditor();
	    $("#hindsight-"+data_id ).find( 'textarea.hindsight_description_editor' ).ckeditor();
	    $("#hindsight-"+data_id ).find( 'textarea.hindsightDetail' ).ckeditor();
 
		});
		
		 $(".feature-editor").each(function(i,v){
		
		
		
		CKEDITOR.instances[$(v).attr('id')].config.wordcount = {	
		// Whether or not you want to show the Word Count
		showWordCount: true,
	
		// Whether or not you want to show the Char Count
		showCharCount: false,
		
		showParagraphs: false,

		// Maximum allowed Word Count
		maxWordCount: 800,
		// Maximum allowed Char Count
		maxCharCount: 800,
		
		hardLimit: false
	};
	});
		
});
        /*function use here to edit advice*/
        
	jQuery('body').on('click','.edit-advice-mylibrary',function(e){
		
		
		
		
		 
	
	
        var $this = $(this);
        var data_id = $this.data("id"); 
       
         var blog = $this.data("blogstatus"); 
      

      // $("#new-advice-"+data_id).find('.error-message').html('');
        if(blog == 0 || blog == "")
        {
              
                  $("#new-advice-"+data_id).find(".create-advice").trigger('click');
                
                $("#new-advice-"+data_id).find(".advice-wrapper-post").show();
                $("#new-advice-"+data_id).find(".feature-blog-wrapper-post").hide(); 
          
          
        }
        else
        {
          
                $("#new-advice-"+data_id).find(".feature-blog").trigger('click');

                $("#new-advice-"+data_id).find(".advice-wrapper-post").hide();
                $("#new-advice-"+data_id).find(".feature-blog-wrapper-post").show(); 
            
            


        }
        
		e.stopPropagation();
		$("#new-advice-"+data_id).modal('show');

        setTimeout(function(){
             var idBlog = $("#new-advice-"+data_id).find('.feature-editor').attr('id');
              
                // for featured_blog_id
                CKEDITOR.instances[idBlog].config.wordcount = { 
                        // Whether or not you want to show the Word Count
                        showWordCount: true,
                    
                        // Whether or not you want to show the Char Count
                        showCharCount: false,
                        
                        showParagraphs: false,

                        // Maximum allowed Word Count
                        maxWordCount: 800,
                        // Maximum allowed Char Count
                        maxCharCount: 800,
                        
                        hardLimit: false
                    };

                },100);
        
		
		});
		
		
		/*function here to save hindsight in the draft*/
		
		
		$('body').on('click','.editHindsightAsDraft', function(e){
		
			var $this = $(this),
			currentAdviceId = $this.data('id'),
			formWrapper = $('#hindsight-'+currentAdviceId);
				e.preventDefault();
				var network_type;

				if($("input[type='radio'].editradioClass").is(':checked')) {
				network_type = $("input[type='radio'].editradioClass:checked").val();
				}

				var executive_summary = formWrapper.find('#hindsight_description_editor').val();
				var challenge_addressing = formWrapper.find('#short_description_editor').val();
				var decision_type_id = formWrapper.find('.decision_types').val(),
				category_id  = formWrapper.find('.addcategory_'+currentAdviceId).val(),
				advice_title = formWrapper.find('.sage-title-inp-'+currentAdviceId).val(),
			    published_date = $('#datepicker_advice_'+currentAdviceId).val();
				outcome = formWrapper.find('.outcome_'+currentAdviceId).val();
				var hindsight_description = executive_summary;
			
			//var editorClone =  $("#hindsight-"+currentAdviceId ).find('.snippet').clone().removeClass('snippet').addClass('maintain-count-value');
			hindsight = new Array();
			var i = 0;
			formWrapper.find('.hindsightDetail').each(function(){        
			detailId = $(this).data('id');
			hindsight[i] = detailId+'~'+$(this).val();
			i++;
			});
			
			if(advice_title.trim() == ''){
			   var wrap = formWrapper.find('.sage-title-inp-'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('Please enter title.');
			}
			else{
			   var wrap = formWrapper.find('.sage-title-inp-'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('');
			}

			if(decision_type_id == ''){
			   var wrap = formWrapper.find('.decision_types').closest('.form-group');
			   wrap.find('.error-message').html('Please select category.');
			}
			else{
			   var wrap = formWrapper.find('.decision_types').closest('.form-group');
			   wrap.find('.error-message').html('');
			}

			if(category_id == ''){
			   var wrap = formWrapper.find('.addcategory_'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('Please select sub-category.');
			}
			else{
			   var wrap = formWrapper.find('.addcategory_'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('');
			}
			if(published_date == ''){
			   var wrap = formWrapper.find('#datepicker_advice_'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('Please select date.');
			}
					
			/* else{
			var wrap = formWrapper.find('#executive_summary').closest('.form-group');
			wrap.find('.error-message').html('');
			} */
			
			if(outcome == ''){
			var wrap = formWrapper.find('.outcome_'+currentAdviceId).closest('.form-group');
			wrap.find('.error-message').html('Please rate the decision.');
			}
			else{
			var wrap = formWrapper.find('.outcome_'+currentAdviceId).closest('.form-group');
			wrap.find('.error-message').html('');
			}
			
			if(advice_title.trim() == '' || decision_type_id == '' || category_id == '' || published_date == ''|| outcome==''){
			$('.page-loading-ajax').hide();
			return false;
		}

    var datas = {'obj_id':currentAdviceId, 'executive_summary':executive_summary, 'challenge_addressing':challenge_addressing, 
        'hindsight':hindsight, 'advice_title':advice_title, 'decision_type_id':decision_type_id, 'category_id':category_id,
        'published_date':published_date,'hindsight_description':hindsight_description,'outcome':outcome,'network_type':network_type};

			$.ajax({
			type:'POST',
			url:'<?php echo $this->webroot?>DecisionBanks/updateHindsightDraftLibrary/',
			data:datas,
			success:function(data){
			$('.page-loading-ajax').hide();
			if(data == 1){
			    $("#hindsight-"+currentAdviceId).modal('hide');
				//$("#thanks-draft-wisdom-add-"+currentAdviceId).modal('show');
			}
			else{
			   bootbox.alert('Sorry! record did not update.');
				}
			}
    });
		
	});	
		/*end code here*/
		
		
		/*function here to submit hindsight details*/
		
		$('body').on('click','.shareHindsight', function(e){
			var $this = $(this),
			currentAdviceId = $this.data('id'),
			formWrapper = $('#hindsight-'+currentAdviceId);
				e.preventDefault();
				var share_type = $this.data('share-type');
                var network_type;
            if(share_type == "blog"){
               if($('#AllEntopolis1-'+currentAdviceId).is(':checked')==true) {
                    network_type = '1'; 
				}else {
                    network_type = '0';	
				}
             }else{
               if($('#AllEntopolis-'+currentAdviceId).is(':checked')==true) {
				network_type = '1';
				}
				else {
				network_type = '0';	
				}

            }  
				
				var executive_summary = formWrapper.find('#hindsight_description_editor').val();
				var challenge_addressing = formWrapper.find('#short_description_editor').val();
				var decision_type_id = formWrapper.find('.decision_types').val(),
				category_id  = formWrapper.find('.addcategory_'+currentAdviceId).val(),
				advice_title = formWrapper.find('.sage-title-inp-'+currentAdviceId).val(),
			    published_date = $('#datepicker_advice_'+currentAdviceId).val();
				var outcome = formWrapper.find('.outcome_'+currentAdviceId).val();
				var hindsight_description = executive_summary;
			
			//var editorClone =  $("#hindsight-"+currentAdviceId ).find('.snippet').clone().removeClass('snippet').addClass('maintain-count-value');
			hindsight = new Array();
			var i = 0;
			formWrapper.find('.hindsightDetail').each(function(){        
			detailId = $(this).data('id');
			hindsight[i] = detailId+'~'+$(this).val();
			i++;
			});
			
			if(advice_title.trim() == ''){
			   var wrap = formWrapper.find('.sage-title-inp-'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('Please enter title.');
			}
			else{
			   var wrap = formWrapper.find('.sage-title-inp-'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('');
			}

			if(decision_type_id == ''){
			   var wrap = formWrapper.find('.decision_types').closest('.form-group');
			   wrap.find('.error-message').html('Please select category.');
			}
			else{
			   var wrap = formWrapper.find('.decision_types').closest('.form-group');
			   wrap.find('.error-message').html('');
			}

			if(category_id == ''){
			   var wrap = formWrapper.find('.addcategory_'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('Please select sub-category.');
			}
			else{
			   var wrap = formWrapper.find('.addcategory_'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('');
			}
			if(published_date == ''){
			   var wrap = formWrapper.find('#datepicker_advice_'+currentAdviceId).closest('.form-group');
			   wrap.find('.error-message').html('Please select date.');
			}
					
			/* else{
			var wrap = formWrapper.find('#executive_summary').closest('.form-group');
			wrap.find('.error-message').html('');
			} */
			
			if(outcome == ''){
			var wrap = formWrapper.find('.outcome_'+currentAdviceId).closest('.form-group');
			wrap.find('.error-message').html('Please rate the decision.');
			}
			else{
			var wrap = formWrapper.find('.outcome_'+currentAdviceId).closest('.form-group');
			wrap.find('.error-message').html('');
			}
			
			if(advice_title.trim() == '' || decision_type_id == '' || category_id == '' || published_date == ''|| outcome==''){
			$('.page-loading-ajax').hide();
			return false;
		}

        if(share_type == "blog"){
             var datas = {'obj_id':currentAdviceId, 'executive_summary':executive_summary, 'challenge_addressing':challenge_addressing, 
            'hindsight':hindsight, 'advice_title':advice_title, 'decision_type_id':decision_type_id, 'category_id':category_id,
            'published_date':published_date,'hindsight_description':hindsight_description,'outcome':outcome,'network_type':network_type,'data_share_type':share_type};
        }else{
			var datas = {'obj_id':currentAdviceId, 'executive_summary':executive_summary, 'challenge_addressing':challenge_addressing, 
            'hindsight':hindsight, 'advice_title':advice_title, 'decision_type_id':decision_type_id, 'category_id':category_id,
            'published_date':published_date,'hindsight_description':hindsight_description,'outcome':outcome,'network_type':network_type}; 
		}            
    

			$.ajax({
			type:'POST',
			url:'<?php echo $this->webroot?>DecisionBanks/updateHindsightLibrary/',
			data:datas,
			success:function(data){
			$('.page-loading-ajax').hide();
			if(data == 1){
			    $("#hindsight-"+currentAdviceId).modal('hide');
				//$("#thanks-draft-wisdom-add-"+currentAdviceId).modal('show');
			}
			else{
			   bootbox.alert('Sorry! record did not update.');
				}
			}
    });
			
			
		});
		
		/*end code here*/
		
		
		
		
		
		/*function use here to edit advice*/
		$('body').on('click','.shareAdvice', function(e){
		var $this = $(this),
		currentAdviceId = $this.data('id'),
		formWrapper = $('#new-advice-'+currentAdviceId);
	   var decision_data =  formWrapper.find("#decision_type_id option:selected").text();
	   e.preventDefault();
		var network_type;
			
		if($('#AllEntopolis-'+currentAdviceId).is(':checked')) {
				network_type = '1';
				}
				else {
				network_type = '0';	
				}
		
		var executive_summary = formWrapper.find('#executive_summary').val();
		var challenge_addressing = formWrapper.find('#challenge_addressing').val();
		var key_advice_point = formWrapper.find('#key_advice_points').val();
		var source_url = formWrapper.find("#source_url").val();
		var decision_type_id = formWrapper.find('.decision_types').val(),
		 category_id  = formWrapper.find('.addcategory_'+currentAdviceId).val(),
		 advice_title = formWrapper.find('.sage-title-inp-'+currentAdviceId).val(),
		
		published_date = $('#datepicker-'+currentAdviceId).val();
   
   if(advice_title.trim() == ''){
       var wrap = formWrapper.find('.sage-title-inp-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please enter title.');
   }
   else{
       var wrap = formWrapper.find('.sage-title-inp-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(decision_type_id == ''){
       var wrap = formWrapper.find('.decision_types').closest('.form-group');
       wrap.find('.error-message').html('Please select category.');
   }
   else{
       var wrap = formWrapper.find('.decision_types').closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(category_id == ''){
       var wrap = formWrapper.find('.addcategory_'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select sub-category.');
   }
   else{
       var wrap = formWrapper.find('.addcategory_'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   if(published_date == ''){
       var wrap = formWrapper.find('#datepicker-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select date.');
   }
   else{
       var wrap = formWrapper.find('#datepicker').closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(executive_summary.trim() == ''){
       var wrap = formWrapper.find('#executive_summary').closest('.form-group');
       wrap.find('.error-message').html('Please enter snapshot .');
   }
   else{
       var wrap = formWrapper.find('#executive_summary').closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(advice_title.trim() == '' || decision_type_id == '' || category_id == '' || executive_summary.trim() == '' || published_date == ''){
        //$('.page-loading-ajax').hide();
		
       return false;
   }
		var datas = {'obj_id':currentAdviceId, 'executive_summary':executive_summary, 'challenge_addressing':challenge_addressing, 
       'key_advice_point':key_advice_point, 'advice_title':advice_title, 'decision_type_id':decision_type_id, 'category_id':category_id,
       'published_date':published_date,'network_type':network_type,'source_url':source_url};
	   
        $.ajax({
            url:"<?php echo Router::url(array('controller' => 'Advices', 'action' => 'updateAdviceLibrary')) ?>",
            data:datas,
            type:'POST',
            success:function(data){
                
					 if(data.result!="error"){
                     
                       $('ul.tabs li').removeClass('active');
              
                        $('#'+data.decision_data.name+'-tab').closest('li').addClass('active'); 
                       


                            $("#new-advice-"+currentAdviceId).modal('hide');
                            getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
                    
                  }
                  else{
                      bootbox.alert('Sorry! record did not update.');
                  }
                }
            
    
        });
	   
	});
	

    /*function use share and edit blog advice*/
        $('body').on('click','.shareBlogAdvice', function(e){
        var $this = $(this),
        currentAdviceId = $this.data('id'),
        formWrapper = $('#Featureblogform-'+currentAdviceId);
     
        var network_type;
            
        if($('#AllEntopolis-'+currentAdviceId).is(':checked')) {
                network_type = '1';
                }
                else {
                network_type = '0'; 
                }
        
        var source_url = $("#source-url-val").val();
        var decision_type_id = $('#descision-type-val-'+currentAdviceId).val();
        var category_id  = $('.category-type-val-'+currentAdviceId).val();
        var advice_title = $("#advice-title-val-"+ currentAdviceId).val();
        var published_date = $('#datepicker-advice-val-'+currentAdviceId).val();
        var feature_blog = $('#feature_blog-'+currentAdviceId).val();
       
   if(advice_title == ''){
       var wrap = $('#advice-title-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please enter title.');
   }
   else{
       var wrap = $('#advice-title-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(decision_type_id == ''){
       var wrap = $('#descision-type-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select category.');
   }
   else{
       var wrap = $('#descision-type-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(category_id == ''){
       var wrap = $('.category-type-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select sub-category.');
   }
   else{
       var wrap = $('.category-type-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   if(published_date == ''){
       var wrap = $('#datepicker-advice-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select date.');
   }
   else{
       var wrap = $('#datepicker-advice-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(feature_blog.trim() == ''){
       var wrap = $('#feature_blog-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please enter snapshot .');
   }
   else{
       var wrap = $('#feature_blog-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(advice_title == '' || decision_type_id == '' || category_id == '' || feature_blog == '' || published_date == ''){
        //$('.page-loading-ajax').hide();
        
       return false;
   }
        var datas = {'obj_id':currentAdviceId, 'feature_blog':feature_blog, 'advice_title':advice_title, 'decision_type_id':decision_type_id, 'category_id':category_id,
       'published_date':published_date,'network_type':network_type,'source_url':source_url};
       
        $.ajax({
            url:"<?php echo Router::url(array('controller' => 'Advices', 'action' => 'shareBlog')) ?>",
            data:datas,
            type:'POST',
            success:function(data){
                
                     if(data.result!="error"){
                      $('ul.tabs li').removeClass('active');
              
                        $('#'+data.decision_data.name+'-tab').closest('li').addClass('active'); 
                        formwrap.get(0).reset();


                    $("#edit-blog-"+currentAdviceId).modal('hide');
                    getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
                    
                  }
                  else{
                      bootbox.alert('Sorry! record did not update.');
                  }
                }
            
    
        });
       
    });

     //Share advice as blog

    $('body').on('click','.shareBlogAdssvice', function(e){
        var $this = $(this),
        currentAdviceId = $this.data('id'),
        datas = $('#Featureblogform-'+currentAdviceId).serialize();
     
        var network_type;
            
        if($('#AllEntopolisblog-'+currentAdviceId).is(':checked')) {
                network_type = '1';
                }
                else {
                network_type = '0'; 
                }
            
                
        var addintional = 'network_type=' + network_type;
        datas = datas + '&' + addintional; 
       
        $.ajax({

            url:"<?php echo Router::url(array('controller' => 'Advices', 'action' => 'shareBlog')) ?>",
            data:datas,
            type:'POST',
            success:function(data){
                
                    if(data.result=="error"){
                    clearAllBlogError(currentAdviceId)
                  
                   
                    if(data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0]!=''){
                        $("#advice-title-val-"+ currentAdviceId).after('<div class="error-message">'+data.error_msg.advice_title[0]+'</div>');
                    }
                    if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                        $("#category-type-val-"+ currentAdviceId).after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                    }
                    if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                        $("#descision-type-val-"+ currentAdviceId).after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                    }
                    if(data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0]!=''){
                        $("#datepicker-advice-val-"+ currentAdviceId).after('<div class="error-message">'+data.error_msg.advice_decision_date[0]+'</div>');
                    }
                    if(data.error_msg.feature_blog !== undefined && data.error_msg.feature_blog[0]!=''){
                        $("#feature_blog-"+ currentAdviceId).after('<div class="error-message">'+data.error_msg.feature_blog[0]+'</div>');
                    }
                    $('.modal-body').scrollTop(0); 
                }
                  else{
                       $('ul.tabs li').removeClass('active');
              
                        $('#'+data.decision_data.name+'-tab').closest('li').addClass('active'); 
                        formwrap.get(0).reset();


                    $("#edit-blog-"+currentAdviceId).modal('hide');
                    getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);

                     // jQuery("#thanks-wisdom-add").data('tabname',data.decision_data.name);
                     // jQuery("#thanks-wisdom-add").data('tabid',data.decision_data.id);
                    
                       clearAllBlogError(currentAdviceId)
                  }
                }
            
    
        });
       
    });






	/*save sa ad draft*/
	
	$('body').on('click','.editAdviceDraft', function(e){
		var $this = $(this),
		currentAdviceId = $this.data('id'),
		formWrapper = $('#new-advice-'+currentAdviceId);
		var decision_data =  formWrapper.find("#decision_type_id option:selected").text();
	    e.preventDefault();
		
		var executive_summary = formWrapper.find('#executive_summary').val();
       
		var challenge_addressing = formWrapper.find('#challenge_addressing').val();
		var key_advice_point = formWrapper.find('#key_advice_points').val();
		var source_url = formWrapper.find("#source_url").val();
		var decision_type_id = formWrapper.find('.decision_types').val(),
		 category_id  = formWrapper.find('.addcategory_'+currentAdviceId).val(),
		 advice_title = formWrapper.find('.sage-title-inp-'+currentAdviceId).val(),
		published_date = $('#datepicker-'+currentAdviceId).val();
   
   if(advice_title == ''){
       var wrap = formWrapper.find('.sage-title-inp-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please enter title.');
   }
   else{
       var wrap = formWrapper.find('.sage-title-inp-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(decision_type_id == ''){
       var wrap = formWrapper.find('.decision_types').closest('.form-group');
       wrap.find('.error-message').html('Please select category.');
   }
   else{
       var wrap = formWrapper.find('.decision_types').closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(category_id == ''){
       var wrap = formWrapper.find('.addcategory_'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select sub-category.');
   }
   else{
       var wrap = formWrapper.find('.addcategory_'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   if(published_date == ''){
       var wrap = formWrapper.find('#datepicker-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select date.');
   }
   else{
       var wrap = formWrapper.find('#datepicker-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(executive_summary.trim() == ''){
 
       var wrap = formWrapper.find('#executive_summary').closest('.form-group');
       wrap.find('.error-message').html('Please enter snapshot.');
   }
   else{

       var wrap = formWrapper.find('#executive_summary').closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(advice_title == '' || decision_type_id == '' || category_id == '' || executive_summary == '' || published_date == ''){
        //$('.page-loading-ajax').hide();
		
       return false;
   }

		var datas = {'obj_id':currentAdviceId, 'executive_summary':executive_summary, 'challenge_addressing':challenge_addressing, 
       'key_advice_point':key_advice_point, 'advice_title':advice_title, 'decision_type_id':decision_type_id, 'category_id':category_id,
       'published_date':published_date,'source_url':source_url};
	   
        $.ajax({
            url:"<?php echo Router::url(array('controller' => 'Advices', 'action' => 'updateAdviceDraftLibrary')) ?>",
            data:datas,
            type:'POST',
            success:function(data){
                
					 if(data.result!="error"){
					 
                       $('ul.tabs li').removeClass('active');
              
                        $('#'+data.decision_data.name+'-tab').closest('li').addClass('active'); 
                       


                            $("#new-advice-"+currentAdviceId).modal('hide');
                            getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
					
				  }
				  else{
					  bootbox.alert('Sorry! record did not update.');
				  }
                }
            
    
        });
	   
	});
	
	/*end code here*/

		$('.modal').scroll(function() {  
             $('.ui-datepicker').fadeOut('fast'); 
              
           });
	function clearAll(){
        $("#advice_title").nextAll().remove();
        $("#category_id").nextAll().remove();
        $("#decision_type_id").nextAll().remove();
        $("#datepicker").nextAll().remove();
        $("#cke_executive_summary").nextAll().remove();
    }

//code for blog section

function clearAllBlogError(advice_id){
        $("#advice-title-val-"+advice_id).nextAll().remove();
         $("#category-type-val-"+advice_id).nextAll().remove();
         $("#descision-type-val-"+advice_id).nextAll().remove();
         $("#datepicker-advice-val-"+advice_id).nextAll().remove();
         $("#feature_blog-"+advice_id).nextAll().remove();
    }


    /*save blog as draft*/
    
    $('body').on('click','.editBlogDraft', function(e){
        var $this = $(this),
        currentAdviceId = $this.data('id'),
        formWrapper = $('#Featureblogform-'+currentAdviceId);         
       
        
        var source_url = $("#source-url-val").val();
        var decision_type_id = $('#descision-type-val-'+currentAdviceId).val();
        var category_id  = $('.category-type-val-'+currentAdviceId).val();
        var advice_title = $("#advice-title-val-"+ currentAdviceId).val();
        var published_date = $('#datepicker-advice-val-'+currentAdviceId).val();
        var feature_blog = $('#feature_blog-'+currentAdviceId).val();
       
   if(advice_title == ''){
       var wrap = $('#advice-title-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please enter title.');
   }
   else{
       var wrap = $('#advice-title-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(decision_type_id == ''){
       var wrap = $('#descision-type-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select category.');
   }
   else{
       var wrap = $('#descision-type-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(category_id == ''){
       var wrap = $('.category-type-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select sub-category.');
   }
   else{
       var wrap = $('.category-type-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   if(published_date == ''){
       var wrap = $('#datepicker-advice-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please select date.');
   }
   else{
       var wrap = $('#datepicker-advice-val-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(feature_blog.trim() == ''){
       var wrap = $('#feature_blog-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('Please enter snapshot .');
   }
   else{
       var wrap = $('#feature_blog-'+currentAdviceId).closest('.form-group');
       wrap.find('.error-message').html('');
   }
   
   if(advice_title == '' || decision_type_id == '' || category_id == '' || feature_blog == '' || published_date == ''){
        //$('.page-loading-ajax').hide();
        
       return false;
   }

        var datas = {'obj_id':currentAdviceId, 'feature_blog':feature_blog,'advice_title':advice_title, 'decision_type_id':decision_type_id, 'category_id':category_id,
       'published_date':published_date,'source_url':source_url};
       
        $.ajax({
            url:"<?php echo Router::url(array('controller' => 'Advices', 'action' => 'saveBlogDraft')) ?>",
            data:datas,
            type:'POST',
            success:function(data){
                
                     if(data.result!="error"){
                     
                       $('ul.tabs li').removeClass('active');
              
                        $('#'+data.decision_data.name+'-tab').closest('li').addClass('active'); 
                       


                            $("#new-advice-"+currentAdviceId).modal('hide');
                            getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
                    
                  }
                  else{
                      bootbox.alert('Sorry! record did not update.');
                  }
                }
            
    
        });
       
    });
    
    /*end code here*/



</script>   





<?php echo $this->element('blog_js_element');?>  

