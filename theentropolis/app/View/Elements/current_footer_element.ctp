<footer class="footer">
	<div class="container">
		<a href="" class="right entrop"><?php echo $this->Html->image('entrop-icon1.png',array('width'=>'50px'));?></a>
		<ul class="footer-menu align-center">			
			<li><?php echo $this->Html->link('PRIVACY AND SECURITY',array('controller'=>'pages','action'=>'privacy')) ?></li>	
			<li>|</li>		
			<li><a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>">TERMS OF USE</a></li>

			<li>|</li>
			<li><a href="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'index')) ?>">EMERGENCY SERVICES</a></li>			
		</ul>
	</div>	
</footer>