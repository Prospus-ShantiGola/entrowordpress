<div class="col-md-10 content-wraaper">
    <div class="title dashboard-title">
        <h1 style="text-transform:uppercase">Advice| Upload</h1>
        <div class="title-sep-container">
            <div class="title-sep"></div>		
        </div>
    </div>

    <div class="home-display">
           
        <div class="col-md-12">
            
            <div class="search-bar clearfix">
                <div class="row">
                    <div class="col-md-8">
						 <?php echo $this->Session->flash('format-error');?> 
    <?php if(isset($result)){ ?>
    <div><?php echo $result;?> </div>
    <?php } ?>
                        <form class="form-inline" role="form" method="post" action="" enctype="multipart/form-data">

                            <div class="form-group">                               
                                <?php echo $this->Form->input('user_id', array('options' => $users, 'class' => 'form-control', 'id' => 'user_id', 'style' => 'width:34%', 'label' => false, 'div' => false)); ?>                             
                            </div>
                            <div class="form-group"> </div>
                            <div class="form-group"> 
                            	<input type="file" name="file">
                                <span style="color:#ff0000; font-size:12px;">[choose only .xls file to upload ] </span><span><a href="<?php echo $this->webroot.$fileName; ?>">Click here </a> to download formate </span>
                                <br><br>
                                
                            </div>
                            
                            
                            <br>
                            <button type="submit" class="btn search-bar-button1">Upload</button>
                        </form>
                    </div>
                    
                </div>
            </div>
           
        </div>
        <div class="col-md-12 hindsight-tab ">
            <div id="tabs" class="tabCls">              
                <div id="container-scroll" class="container-scroll">
                    <div id="parent"> 
                        
                    </div>
                </div>             
            </div>

        </div>
    </div>
    

   