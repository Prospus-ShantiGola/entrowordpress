<?php 
	  $userName = $userData['User']['first_name']. ' '.$userData['User']['last_name'];
	 ?>
<body>
	<table width="750" cellpadding="0" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;">
		<thead>
			<tr>
				<td><img src="img/email-header.png" alt="" style="width:100%"></td>
			</tr>			
		</thead>
		<tbody>
			<tr>
				<td>
					<table style="margin:20px 50px; font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;" cellpadding="0" cellspacing="0">
						<tr>
							<td style="padding-bottom:15px;">Dear <?php echo $userName;?>,</td>							
						</tr>
						<tr>
							<td style="padding-bottom:15px;">Your Citizen | account has been successfully deleted</td>
						</tr>
						<tr>
							<td style="padding-bottom:15px;"><b>Citizen:</b><?php echo $userName;?></td>
						</tr>
						<tr>
							<td style="padding-bottom:15px;">We are sorry to see you go and hope that you will be back soon</td>
						</tr>
						<tr>
							<td style="padding-bottom:15px;"><b>Note:</b> All the content you shared with Entropolis remains in our database and will be accessible to our Citizens via the Wisdom|Search function.</td>
						</tr>
						<tr>
							<td style="padding-bottom:15px;">Citizens will be able to rate and comment on your content however will no longer be able to view your profile or ask you to join their network.<br/><br/>If for any reason you would like your personal content to be removed from our wisdom database please contact us at citizens@theentropolis.com and we will take care of that for you. </td>
						</tr>
						<tr>
							<td style="padding-bottom:15px;">Best of luck on your entrepreneurial adventure.</td>
						</tr>
						
						<tr>
							<td style="padding-bottom:5px;"><b>E|HQ Team</b></td>
						</tr>
						<tr>
							<td style="padding-bottom:15px;"><b><a href="#" style="color:#000; text-decoration:none;">www.TheEntropolis.com</a> |  #PlacetobeforEntrepreneurs</b></td>
						</tr>
						<tr>
							<td>
								<table  cellpadding="0" cellspacing="0" style="color:#b2b2b2; font-size:11px; font-family: Arial, Helvetica, sans-serif; line-height:13px">
									<tr>
										<td>**** IMPORTANT INFORMATION *****</td>
									</tr>
									<tr>
										<td style="padding-bottom:15px;">This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at hello@TheEntropolis.com. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited.
										</td>
									</tr>
									<tr>
										<td>Entropolis Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
									</tr>
								</table>
							</td>
						</tr>	
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table  cellpadding="0" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#f2f2f2; width:100%; padding:20px 50px; ">
						<tr>
							<td>LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | T:1800 XXX XXX | E: <a href="#" style="color:#428bca">citizens@TheEntropolis.com</a> | www.TheEntropolis.com</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>		
	</table>
</body>