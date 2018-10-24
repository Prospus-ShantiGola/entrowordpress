<div class="title dashboard-title">
    <h1>Dashboard</h1>
    <div class="title-sep-container">
        <div class="title-sep"></div>		
    </div>
</div
<div class="dashboard-div-wrap clearfix">

    <div class="dashboard-div ">
        <a href="#"> <i class="fa fa-user fa-icon1 "></i><div>E|Scene</div>	</a>

    </div>
    <div class="dashboard-div">
    <?php echo $this->Html->link('<i class="fa fa-cog fa-icon1"></i><div>Setting</div>', array('controller'=>'users', 'action'=>'settings'), array('escape'=>false));?>
       
    </div>


</div>