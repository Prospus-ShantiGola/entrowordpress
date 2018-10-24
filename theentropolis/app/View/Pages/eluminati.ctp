  <div class="top-heading margin-bottom ">
    <div class="container">
        <div class="title"><h1>E|LUMINATI</h1></div>             
        <div class="bredcumb-menu right">
            <ul>
                 <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'index'));?>">Home</a></li>
                <li>/</li>
                  <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'eluminati'));?>">E|LUMINATI</a></li>
                
                
            </ul>
        </div>        
    </div>
</div>
<div id="meet-citizen" class="container">    
    <div class="content margin-bottom">
                    <div class="">                       
                        <div class="row eluminati-top">
                            <div class="col-md-2">
                               <div class="eluminate-icon">
                                    <i><?php echo $this->Html->image('eluminate.png')?></i>
                                </div> 
                            </div>
                            <div class="col-md-10">
                                <p>Invited as patrons of TrepiCity, the eLuminati are the rock stars of the entrepreneurial global stage. Don’t expect them to drop a note asking to be your mentor! But you can learn from these great men and women from every corner of the globe. </p>
                                <p>Dive into their stories to be amazed and inspired. Many of these characters you will know. Some prefer to operate underground and could be new to you. Regardless, all have forged their own bold path and they are sharing their experiences here in TrepiCity to help you build your personal success.</p>
                            </div>                            
                        </div>
                        <div class="eluminati-wrapper">
                            <?php 
                             $count = $this->Eluminati->getEluminatiCount();
                            $eluminati = $this->Eluminati->getAllEluminati($start= null,$end_limit=null,'Creel');
                           // pr($eluminati);
                           // die;
                                foreach ( $eluminati  as $key=>$data)
                                {
                                    if($data['Eluminati']['image_url']!='')
                                    {
                                       $imgPath = $this->Html->url('/').$this->Image->resize($data['Eluminati']['image_url'], 122, 137, false) ;
                                    }
                                    else
                                    {
                                       $imgPath = $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png', 122, 137, false);  
                                    }
                                    if($key%2)
                                    {
                                        $add_class="light-purpel";
                                    }
                                    else
                                    {
                                        $add_class="light-orange";
                                    }
                                    ?>
                            <div class="eluminate-div">
                                <div class="eluminate-top">
                                    <i><a href= "eluminatiProfile/<?php echo $data['Eluminati']['id'];?>" target= "_Blank"><img src="<?php echo $imgPath;?>"></a></i>
                                    <div class="align-center">
                                       <?php echo $this->Html->image('eluminate-icon.png');?> 
                                          <h5>
                                                <a href= "eluminatiProfile/<?php echo $data['Eluminati']['id'];?>" target= "_Blank">
                                                    <?php echo $data['Eluminati']['first_name']." ".$data['Eluminati']['last_name'];?>
                                            </h5>
                                        <p><a href= "eluminatiProfile/<?php echo $data['Eluminati']['id'];?>" target= "_Blank"><?php echo ucwords($this->Eluminati->text_cut($data['Eluminati']['title'], $length = 20, $dots = true));?></a></p>
                                    </div>
                                </div>
                                <div class="eluminate-detail">
                                    <p class="font-small"><?php //echo strlen($this->Eluminati->text_cut($data['Eluminati']['testimonial'], $length = 150, $dots = true)); 
                                    echo  str_replace('<b>','',nl2br($this->Eluminati->text_cut($data['Eluminati']['short_description'], $length = 270, $dots = true))); ?></p>
                                </div>                              
                            </div>  
                            <div class="left eluminate-img">
                                <?php echo $this->Html->image('wicked-wisdom.png');?>
                            </div>
                            <div class="left eluminate-img">
                                <?php echo $this->Html->image('every-one.png');?>
                            </div>
                            

                            <?php } ?>
                                                    
                        </div>
                         
                    </div>
    </div>
</div>

<div class="modal fade elumanati-popup" id="elumanati-wisdom" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>