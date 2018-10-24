<?php 
    //pr($advicedetail);
    //echo $advicedetail['Advice']['advice_title'];
    //die;
    if(!empty($user_data))
    {
    ?>
<div class="top-heading margin-bottom ">
    <div class="container">
        <div class="title"><h1><?php echo ucfirst($user_data['Eluminati']['title']);?></h1></div>             
        <div class="bredcumb-menu right">
            <ul>
                <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'index'));?>">Home</a></li>
                <li>/</li>
                    <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'eluminati'));?>">E|LUMINATI</a></li>
             
                
            </ul>
        </div>        
    </div>
</div>
<div class="prfle-home container">
    <div class="">
        <div class="eluminati-profile">
           
            <div class="eluminati-profile-detail">                
                <div class="">
                    <div class="profile-img left img-thumbnail">
                        <?php if( $user_data['Eluminati']['image_url'] != ''){ ?>
                        <img src="<?php echo $this->Html->url('/').$this->Image->resize($user_data['Eluminati']['image_url'] . '', 200, 200, true);?>"> 
                        <?php }else{?>
                        <img src="<?php echo $this->Html->url('/').$this->Image->resize('upload/avatar-male-1.png' . '', 200, 200, true);?>" class="img-thumbnail user-avatar-select"> 
                        <?php } ?> 
                        <?php //echo $this->Html->image('avatar-male-1.png',array('alt'=>""));?>
                    </div>
                    <h4 class="short-bio"><i class="fa fa-user"></i><span>Short Bio</span>   <span class="prfle-badge right">
                                    <?php 
                                        if($user_data['Eluminati']['eluminati_badge'] != '')
                                        {?>
                                    <img  class="img-thumbnail"  src="<?php echo $this->Html->url('/').$this->Image->resize($user_data['Eluminati']['eluminati_badge'] . '', 128, 128, true);?>"> 
                                    <?php }?>
                                </span>  </h4>
                    <p class="short-bio-para">
                     <?php echo nl2br($user_data['Eluminati']['short_description']);?> </p>
                     <p align= "justify"><?php echo nl2br($user_data['Eluminati']['short_description']);?></p>
                </div>
                <div class="margin-top left">
                    <h4><i class="fa fa-comments-o"></i> Testimonial</h4>
                    <p align= "justify">"<?php echo nl2br($user_data['Eluminati']['testimonial']);?>"
                    </p>
                </div>                
            </div>                       
        </div>
    </div>
</div>
<?php } else{

   // echo 'No records found.';
} ?>