<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script>
<div class="col-md-10 content-wraaper">
	<div class="title dashboard-title">
		<h1 style="text-transform:uppercase">Share Advice</h1>
		<div class="title-sep-container">
			<div class="title-sep"></div>
		</div>
	</div>
	
	<div class="home-display">
		<div class="col-md-12">
			<script>
			function goBack() {
			window.history.back()
			}
			</script>
			<a href="javascript:void(0);" onclick="goBack()" class="btn btn-orange-small right share-hindsight-a ">Back</a>
			<div class="share-hindsight">
				<button class="btn btn-black margin-top-small large" data-toggle="modal" data-target="#add-share">Share Your Message</button>
				<p id="shareMessageBox"><?php echo $adviceListInfo['AdviceShare']['message']?></p>
				<?php echo $this->element('add_share_elements', array('adviceListInfo'=>$adviceListInfo,'type'=>'Advice')); ?>
				<button class="btn btn-black margin-top-small large" data-toggle="modal" data-target="#share-hindsight">Share Your Advice on E|Scene</button>
				<div class="social-div">
					<div class="addthis_sharing_toolbox"></div>
				</div>
			</div>
			<div class="modal fade" id="share-hindsight" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
							<h4 class="modal-title" id="myModalLabel">Thank You For Your Sharing</h4>
						</div>
						<div class="modal-body">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu consequat lorem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; </p>
						</div>
						<div class="modal-footer align-center">
							<button type="button" class="btn btn-black" data-dismiss="modal">Discard</button>
							<button type="button" class="btn btn-black" data-dismiss="modal">Ok</button>
							<p>By clicking the OK above you agree to the Advice|Market and Trepicity Pty Ltd <a>Terms of Service</a> and <a>Privacy Policy</a> </p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>