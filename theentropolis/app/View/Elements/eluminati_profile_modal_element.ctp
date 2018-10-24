<!--  <div class="page-loading page-loading-ajax" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div> -->
<?php  $res  = $this->User->getDataById($eluminati['Eluminati']['id'],'Eluminati');

if(!empty($res)){
  //  pr($res);
   $data = 'exist';
}
else
{
    $data = 'notexist';
}

$stage =  $this->User->getStageById($eluminati['Eluminati']['stage_id']);

$decision =  $this->User->getDecisionById($eluminati['Eluminati']['decision_type_id']);
?>

<div id="eluminti-signup" class="eluminati-profile-wrap remove-other-tab" data-present= "<?php echo $data; ?>" data-advice = "<?php echo @$res['EluminatiDetail']['id']; ?>">
    <div class="content">
        <div class="row  elumiat-panel">
            <div class="col-md-12">
                <div class="profile_detail relative">
                    <div class="profile-img-blck profile_img">
                          <?php 
                              if($eluminati['Eluminati']['image_url'])
                              {
                              
                                $user_image = $eluminati['Eluminati']['image_url'];?>
                        <img   src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 227,254, false);?>" alt=""/>
                          <?php   }else {
                              echo $this->Html->image('dummy-pic.png');
                                        ?>
                        <!--   <img   src="<?php echo $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png' , 227, 254, false);?>" alt=""/>     -->
                          <?php  }
                              ?>
                    </div>
                    <div class="profile_detail_view advice_edit">
                    <div class="teacher-first">
                        <div class="eluminti-signup-top ">
                            <!--  <div class="eluminti-signup-top-icon"><?php echo $this->Html->image('entrop-icon1.png') ;?></div> -->
                            <div class="eluminti-signup-top-detail profile_detail_view">
                                <span><?php echo $eluminati['Eluminati']['first_name']." ".$eluminati['Eluminati']['last_name'];?></span>
                                <span><b><?php echo $this->Eluminati->text_cut($eluminati['Eluminati']['title'], $length =20, $dots = true);?></b></span>
                                <span><strong>Category:</strong> <?php  echo @$decision['DecisionType']['decision_type'];  ?></span>
                                <span><strong>Identity:</strong> <?php  echo @$stage['Stage']['stage_title'];  ?></span>
                            </div>
                        </div>
                          <?php
                              if(strlen($eluminati['Eluminati']['short_description']) > 265)
                              {?>
                          <div class="person-content short-data show-link roboto_light"><?php 
                              // echo substr($post['Escene']['post_description'], $remaining-1 );  
                              $actual_lenth = strlen(trim($eluminati['Eluminati']['short_description'])); 
                              echo nl2br($this->Eluminati->text_cut($eluminati['Eluminati']['short_description'], $length = 165, $dots = true)); 
                              $later_length =  strlen(trim($this->Eluminati->text_cut($eluminati['Eluminati']['short_description'], $length = 165, $dots = true)));?></div>
                          <div class="person-content show-link full-data hide"  data-to="1"> <?php echo  nl2br($eluminati['Eluminati']['short_description']);  ?></div>
                          <?php if( $actual_lenth != $later_length ){?>
                          <a href="#1" class="right btn-readmorestuff">Read more</a>
                          <?php } ?><?php
                              }
                              else{?>
                          <p class="person-content  show-link short-data"><?php 
                              echo nl2br($this->Eluminati->text_cut($eluminati['Eluminati']['short_description'], $length = 275, $dots = true));?>
                          </p>
                          <?php }?> 
                        <!-- <p><?php echo $eluminati['Eluminati']['short_description'];?></p> -->                                                   
                    </div>
                </div>
                </div>
                
            </div>
        </div>
        <div class="eluminati-profile-detail containerHeight custom_scroll">

                    <?php if($eluminati['Eluminati']['testimonial']){?>    <div class="wisdom"> <h4>WORDS OF WISDOM</h4>

                <div class="row eluminati-top-wrap">
                    <div class="col-md-12">
                        <p class="italic"><?php if($eluminati['Eluminati']['testimonial']){?> "<?php echo $eluminati['Eluminati']['testimonial'];?>" <?php }?></p>
                    </div>
                </div>
            </div>
                    <?php } ?>

                <?php if(!empty($eluminati_deatil)){?>
            <div class="relative sage-table-wrap table-striped eluminati-color">
                <table class="table  eluminti-table">
                    <thead
                        <tr>
                            <th>category</th>
                            <th>Date</th>
                            <th>title</th>
                            <th>Rate</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                          <?php if(!empty($eluminati_deatil)){?>
                    <tbody class="">
                          <?php  
                              foreach($eluminati_deatil as $eluminatideatil){
                              
                                  ?>
                        <tr>

                            <td title= "<?php echo $eluminatideatil['Category']['category_name'];?>"><?php echo $eluminatideatil['Category']['category_name'];?></td>
                            <td><?php echo date('M j, Y',strtotime($eluminatideatil['EluminatiDetail']['date_published']));?></td>
                            <td><?php echo $this->Eluminati->text_cut($eluminatideatil['EluminatiDetail']['source_name'], $length = 80, $dots = true);?></td>
                            <td><?php echo $this->Rating->eluminatiRatingCount($eluminatideatil['EluminatiDetail']['id']); ?> / 10 </td>

                            <td><?php echo $this->Rating->eluminatiCommentCount($eluminatideatil['EluminatiDetail']['id']); ?></td>
                        </tr>
                          <?php } ?>
                    </tbody>
                      <?php } else { ?>
                    <tr><td colspan= '5' style = "background-color:#dddddd; text-align:center;">No records found.</td></tr>
                                  <?php } ?>
                </table>
            </div>
                <?php } ?>
        </div>
    </div>
</div>