<div class="top-heading margin-bottom  ">
        <div class="container">
            <div class="title">
                <h1>CONNECT, COLLABORATE, HANGOUT</h1>
            </div>
            <div class="bredcumb-menu right">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li>/</li>
                    <li><a href="#">E|SCENE</a></li>
                </ul>
            </div>
        </div>
    </div>
  <script type="text/javascript">
   $(window).load(function() {
      $('.modal-backdrop.in').css({'opacity':0});
      $('.escene-mask').show();
      $('.escene-mask').height( $('.escene-height').outerHeight()+10);
       $('.escene-mask').width( $('.escene-height').outerWidth()+10);

    });
   </script>
    <div id="escene" class="container">
        <div class="content-wrap">
            <p class="font-large">This is your place to share your thoughts with the citizens of TrepiCity. Start up or join a conversation. Invite peers and experts to ideate or collaborate. Or just hang with your TrepiCity friends from all corners of the globe.</p>
            <div class="escene-mask"></div>
            <div class="escene margin-bottom escene-height">
                    <div class="">
                        <ul class="nav nav-tabs tabs">
                            <li class="active"><a href="#community" data-toggle="tab">COMMUNITY</a></li>
                            <li class=""><a href="#myposts" data-toggle="tab">MY POSTS</a></li>
                        </ul>
                    </div>
                    <div class="row ">
                        <div class="col-md-8 ">                        
                            <div class="tab-content">
                                <div class="tab-pane active" id="community">
                                    <div class="add-post">
                                        <div class="add-post-header">
                                            <div class="add-post-items"> <i><?php echo  $this->Html->image('edit.png') ;?></i><span class="add-post-text">Add Post</span> 
                                                <span class="pull-right post-nav">
                                                <a href="#" class="escene-action-right"><input type="file" value="Browse" class="post-nav-input"><i class="escene-action-fa"><?php echo $this->Html->image('camra.png') ;?></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <textarea rows="3" placeholder="Say something about your post"></textarea>
                                        <div class="add-post-content background-white">
                                            <span class="upload-images hide">
                                                <span> <?php echo $this->Html->image('post-image-small.png') ;?><a href="#"><i class="fa fa-times"></i></a> </span> 
                                                <span>
                                                    <div class="file-uploader">
                                                        <div>Upload File</div>
                                                        <input type="file" value="Browse" data-index="0" class="file-upload magic-placeholder" name="attached_file[]" placeholder="" data-original-title="" title="">
                                                        <span class="magic-placeholder-text" style="display: block;"></span> 
                                                    </div>
                                                </span>
                                                <hr class="hr1">
                                            </span>
                                            <div> <a href="#" class="btn btn-orange1">ADD POST</a> </div>
                                        </div>
                                    </div>
                                    <div class="">
 <?php  echo $this->element('add_post_element');?>   
                                       <!--  <div class="post-comment-detail  background-white">
                                            <div class="post">
                                                <div class="post-header">
                                                    <div class="avatar"><img src="images/dummy-icon.png" class="circle-image" alt=""></div>
                                                    <div class="user-post-deatils ">
                                                        <a href="#" class="anchor-heading">Mr Universe</a>
                                                        <span class="post-date">August 18 at 18:25</span>
                                                    </div>
                                                </div>
                                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi.</p>
                                                <div class="post-bottom">
                                                    <div class="add-post-items"><i><img src="images/like.png" alt=""></i><span class="add-post-text">Like</span></div>
                                                    <div class="add-post-items"> <i><img src="images/view.png" alt=""></i><span class="add-post-text">View</span></div>
                                                </div>
                                            </div>
                                            <div class="post-comment">
                                                <div class="post-count"><a href="#">anjalisharma</a><i><img src="images/like.png" alt=""></i>this</div>
                                                <p class="comment-loader view-comment-list"><acronym title="Comment"><i class="fa fa-comment">&nbsp;&nbsp;</i></acronym><a href="javascript:void(0);" class="load-more-comments">View 51 more</a> comments.</p>
                                                <div class="row coment-detail">
                                                    <div class="col-md-1">
                                                        <div class="avatar"><img src="images/dummy-icon.png" class="circle-image" alt=""></div>
                                                    </div>
                                                    <div class="col-md-11">
                                                        <p>
                                                            <a href="#">Marc Ragsdale</a>
                                                            <span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam adipiscing rutrum justo, ac imperdiet  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam adipiscing rutrum justo, ac imperdiet... </span>
                                                            <a href="#" class="right">Read more...</a>
                                                        </p>
                                                        <p><span class="post-date">13 days 21 hours 52 mins</span><a href="#"  class=""> Like</a></p>
                                                    </div>
                                                </div>
                                                <div class="row coment-detail">
                                                    <div class="col-md-1">
                                                        <div class="avatar"><img src="images/dummy-icon.png" class="circle-image" alt=""></div>
                                                    </div>
                                                    <div class="col-md-11">
                                                        <p>
                                                            <a href="#">Marc Ragsdale</a>
                                                            <span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam adipiscing rutrum justo, ac imperdiet  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam adipiscing rutrum justo, ac imperdiet... </span>
                                                            <a href="#" class="right">Read more...</a>
                                                        </p>
                                                        <p><span class="post-date">13 days 21 hours 52 mins</span><a href="#"  class=""> Like</a></p>
                                                    </div>
                                                </div>
                                                <div class="row coment-detail">
                                                    <div class="col-md-1">
                                                        <div class="avatar"><img src="images/dummy-icon.png" class="circle-image" alt=""></div>
                                                    </div>
                                                    <div class="col-md-11">
                                                        <p>
                                                            <a href="#">Marc Ragsdale</a>
                                                            <span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam adipiscing rutrum justo, ac imperdiet  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam adipiscing rutrum justo, ac imperdiet... </span>
                                                            <a href="#" class="right">Read more...</a>
                                                        </p>
                                                        <p><span class="post-date">13 days 21 hours 52 mins</span><a href="#"  class=""> Like</a></p>
                                                    </div>
                                                </div>
                                                <div class="row coment-detail">
                                                    <div class="col-md-1">
                                                        <div class="avatar"><img src="images/dummy-icon.png" class="circle-image" alt=""></div>
                                                    </div>
                                                    <div class="col-md-11">
                                                        <p>
                                                            <a href="#">Marc Ragsdale</a>
                                                            <span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam adipiscing rutrum justo, ac imperdiet  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam adipiscing rutrum justo, ac imperdiet... </span>
                                                            <a href="#" class="right">Read more...</a>
                                                        </p>
                                                        <p><span class="post-date">13 days 21 hours 52 mins</span><a href="#"  class=""> Like</a></p>
                                                    </div>
                                                </div>



                                                <div class="avatar"><img src="images/dummy-icon.png" class="circle-image" alt=""></div>
                                                <div class="user-post-deatils ">
                                                    <textarea  rows="2" placeholder="Enter comment here"></textarea>
                                                </div>
                                            </div>
                                        </div> -->
                                        
                                        
                                    </div>                               
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4 escene-wrap-height">
                            <div class="escene-sidebar">
                                <div class="add-post-header">
                                    <div class="add-post-items"><span class="add-post-text">TrepiCity Offical Post</span> 
                                    </div>
                                </div>
                                <div class="escene-sidebar-detail e-scene-bar-one">
                                    <!-- <div class="post-header">
                                        <div class="avatar"><img src="images/dummy-icon.png" class="circle-image" alt=""></div>
                                        <div class="user-post-deatils ">
                                            <a href="#" class="anchor-heading  text-orange">Mr Universe</a>
                                            <span class="post-date">August 18 at 18:25</span>
                                        </div>
                                    </div>
                                    <p class="escene-para">Welcome to TrepiCity!</p>
                                    <div class="row">
                                        <div class="col-md-6"><img src="images/dummy-img.png" alt=""></div>
                                        <div class="col-md-6"><img src="images/dummy-img.png" alt=""></div>
                                    </div>
                                    <div class="post-bottom">
                                        <div class="add-post-items"><i><img src="images/like.png" alt=""></i><span class="add-post-text">Unike</span></div>
                                        <div class="add-post-items"> <i><img src="images/view.png" alt=""></i><span class="add-post-text">View</span></div>
                                    </div> -->

                                    <?php echo $this->element('official_post_element');?>         
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

 <?php    $_SESSION['post_id'] = 0;
    //$this->Session->write('post_id','0');
    if( @$this->Session->read('userid')==''){ ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        //lert("fsdf");
    jQuery("#escene-data").modal('show');
    });
    
    
</script>
<?php }?>
<div class="modal fade escene-wrap" id="escene-data" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button> 
                <h4 class="modal-title" id="myModalLabel">OOPS we noticed you haven't logged in to hang out in the e|scene.</h4>
            </div>
            <div class="modal-body ">
                <div class="row auto">
                    <div class="col-md-4">
                        <div class="popup-btn"><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'login'))?>" class="btn btn-black linkedin-div full dark-grey">LOGIN</a></div>
                    </div>
                    <div class="col-md-4">                        
                        <div class="popup-btn"><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'register'))?>" class="btn btn-orange linkedin-div full">REGISTER | EMAIL</a></div>
                    </div>
                    <div class="col-md-4">
                         <div class="popup-btn"><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'index'))?>" class="btn btn-blue linkedin-div full blue">REGISTER | LINKEDIN</a></div>
                    </div>
                    
                   
                </div>
            </div>
            <div class="bottom-image"></div>
           <!--  <div class="modal-footer">
               <button class="btn btn-black" data-dismiss="modal" aria-hidden="true">Close</button>
           </div> -->
        </div>
    </div>
</div>
<script>
$(window).load(function(){
    $('#myModal').hide();
});
</script>