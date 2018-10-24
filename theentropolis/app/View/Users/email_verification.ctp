<div class="top-grey-strip-bg margin-bottom">
    <div class="container">
        <div class="page-title">
            Account Confirmation
        </div>
    </div>
</div>


<div class="container" style="min-height:260px;">
  
        
        <?php echo $this->Session->flash();?>	
         <?php if(isset($login)){
            if($login==1) {?>
       
        <?php echo $this->element('account_verification_elements'); ?>
        <?php }}?>
        
        
   
</div>
