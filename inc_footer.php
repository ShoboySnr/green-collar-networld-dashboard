<?php 
require_once("admin/inc_dbfunctions.php");
require_once("admin/config.php");

?>

<!-- FOOTER 
	============================================= -->
	<div class="footer">
		<!-- Widget Area -->
		<div class="b-widgets">
			<div class="layout">
				<div class="row">
					<!-- Links -->
					<div class="row-item col-1_4">
						<h3>Quick Navigations</h3>
						<ul class="b-list just-links m-dark">
							<li><a href="index.php">Home</a></li>
							<li><a href="faq.php">FAQs</a></li>
							<li><a href="testimony.php">Testimonies</a></li>
							<li><a href="howitworks.php">How It Works</a></li>
							<li><a href="about-us.php">About Us</a></li>
							<li><a href="contact.php">Contact Us</a></li>
						</ul>
					</div>
					<!-- End Links -->
					<!-- Latest Tweets -->
					<div class="row-item col-1_4">
						<h3>Latest Testimonies</h3>
						<div class="b-twitter m-footer">
							
						</div>
					</div>
					<!-- End Latest Tweets -->
					<!-- Tag Cloud -->
					<div class="row-item col-1_4">
						<h3>About WFG</h3>
						<p>Wealth Fund Global is a global community of people. We are located at Texas, United States, and we have global representatives in some 
							countries. Our major aim is to alleviate and bridge the gap between the poor and the rich, and we do this by setting up this platform. 
							Wealth should belong to everyone, every individuals should have access to this wealth but we have studied and seen over the years that 
							certain individuals known as the government officials, bankers, money lenders ...<a href="about-us.php">read more</a></p>
						
					</div>
					<!-- End Tag Cloud -->
					<!-- Contact Form -->
					<div class="row-item col-1_4">
						<h3>Send Us a Message</h3>
						<p>Do you need more information? Or you have issues, please send us a message</p>
						<!-- Success Message -->
						<div class="form-message"></div>
						<!-- Form -->
						<form class="b-form b-contact-form" action="admin/actionmanager.php" method="post" target="actionframe" role="form" enctype="multipart/form-data">
							<div class="input-wrap m-full-width">
								<i class="icon-user"></i>
								<input class="field-name" type="text" name="name" placeholder="Name (required)">
							</div>
							<div class="input-wrap m-full-width">
								<i class="icon-envelope"></i>
								<input class="field-email" type="text" name="email" placeholder="E-mail (required)">
							</div>
							<div class="textarea-wrap">
								<i class="icon-pencil"></i>
								<textarea class="field-comments" name="message" placeholder="Message"></textarea>
							</div>
							<input name="command" type="hidden" value="contact_us" >
							<button type="submit" class="btn btn-success">Send Message</button>
						</form>
						<!-- End Form -->
					</div>
					<!-- End Contact Form -->
				</div>
			</div>
		</div>
		<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/594c0cc450fd5105d0c8245e/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
		<!-- End Widget Area -->
		<!-- Copyright Area -->
		<div class="b-copyright">
			<div class="layout">
				<!-- Copyright Text -->
				<span class="copy">Copyright © <?php echo date("Y") ?> <a href="index.php">Wealth Fund Global</a>. All Right Reserved.</span>
				<!-- Social Icons -->
				<ul class="b-social bot">
					<li>Follow Us:</li>
					<li><a class="fb" href="#"><i class="icon-facebook"></i></a></li>
					<li><a class="tw" href="#"><i class="icon-twitter"></i></a></li>
					<li><a class="lin" href="#"><i class="icon-linkedin"></i></a></li>
					<!-- 
					<li><a class="yt" href="#"><i class="icon-youtube"></i></a></li>
					<li><a class="tl" href="#"><i class="icon-tumblr"></i></a></li>
					<li><a class="is" href="#"><i class="icon-instagram"></i></a></li>
					<li><a class="pt" href="#"><i class="icon-pinterest"></i></a></li>
					<li><a class="vk" href="#"><i class="icon-vk"></i></a></li>
					<li><a class="dx" href="#"><i class="icon-dropbox"></i></a></li>
					<li><a class="fs" href="#"><i class="icon-foursquare"></i></a></li>
					<li><a class="gh" href="#"><i class="icon-github-alt"></i></a></li>
					<li><a class="mx" href="#"><i class="icon-maxcdn"></i></a></li>-->
				</ul>
			</div>
		</div>
	</div>
	<!-- END FOOTER  -->
	<!--Start of Tawk.to Script-->

<!--End of Tawk.to Script-->