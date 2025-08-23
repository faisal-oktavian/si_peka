	<div class="footer">
		<div class="visible-xs">
			<div class="container-footer-xs">
				<a href="<?php echo app_url(); ?>status_order">Status Order</a> &nbsp;|&nbsp; <a href="<?php echo app_url(); ?>page/cara-pemesanan-di-jadeprintid">Cara Pemesanan</a> &nbsp;|&nbsp; <a href="<?php echo app_url(); ?>a/ingin-membuat-promosi-bisnis-mu-tambah-keren-kenali-dulu-jenis-jenis-sticker-yang-satu-ini">Blog</a>
			</div>
			<div class="container-sosmed-xs">
				<ul class="sosmed-footer">
					<?php 
						$sosmed = azcms_get_sosmed();
						foreach ($sosmed->result() as $key => $value) {
							$sosmed_name = str_replace(' ', '-', strtolower($value->name));
							if ($sosmed_name == 'twitter') {
								$sosmed_name = 'twitter-square';
							}
					?>
					<li>
						<a href="<?php echo $value->url;?>" target="_blank"><i class="fab fa-<?php echo $sosmed_name;?>"></i></a>
					</li>
					<?php
						}
					?>
				</ul>
			</div>
		</div>
		<div class="container hidden-xs">
			<div class="row">
				<div class="col-md-3">
					<div class="box-footer">
						<div class="box-footer-title"><?php echo az_get_config('app_name');?></div>
						<div class="box-footer-caret"></div>
						<div class="box-footer-content">
							<ul>
							<?php 
								$menu = az_get_menu(0, 'footer_menu');
								foreach ($menu as $key => $value) {
							?>
								<li><a href="<?php echo $value['url'];?>"><?php echo $value['title'];?></a></li>
							<?php
								}
							?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="box-footer">
						<div class="box-footer-title">Kontak</div>
						<div class="box-footer-caret"></div>
						<div class="box-footer-content">
							<?php echo str_replace("\n", "<br>", az_get_config('kontak'));?>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="box-footer">
						<div class="box-footer-title">Metode Pembayaran</div>
						<div class="box-footer-caret"></div>
						<div class="box-footer-content">
							<div class="box-footer-payment">
								<div class="row">
										<?php 
											$payment = azcms_get_product_payment();
											foreach ($payment->result() as $key => $value) {
										?>
										<div class="col-xs-6">
											<img class="img-responsive" src="<?php echo base_url().AZAPP.'assets/product_payment/'.$value->image;?>">
										</div>
										<?php
											}
										?>										
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="box-footer">
						<div class="box-footer-title">Social Media</div>
						<div class="box-footer-caret"></div>
						<div class="box-footer-content">
							<ul class="sosmed-footer">
								<?php 
									$sosmed = azcms_get_sosmed();
									foreach ($sosmed->result() as $key => $value) {
										$sosmed_name = str_replace(' ', '-', strtolower($value->name));
										if ($sosmed_name == 'twitter') {
											$sosmed_name = 'twitter-square';
										}
								?>
								<li>
									<a href="<?php echo $value->url;?>" target="_blank"><i class="fab fa-<?php echo $sosmed_name;?>"></i></a>
								</li>
								<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
		© <?php echo Date('Y').' '.az_get_config('website');?> by <a href="http://www.printsoft.co.id">Printsoft</a>
	</div>
</body>
</html>
<?php
	echo az_js();
?>

<!--Start of Tawk.to Script-->
<script type="text/javascript" id="tawk_api">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5ebe26eb8ee2956d73a14cef/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
var cpath = window.location.pathname;
var winWidth = window.innerWidth;
if (winWidth <= 768) {
	Tawk_API.onLoad = function(){
		if (cpath != "/cart") {
			setTimeout(function() {
		    	$('iframe[src="about:blank"]')[0].style.bottom = '55px';
				$('iframe[src="about:blank"]')[3].style.bottom = '95px';
		    },1000);

		    setTimeout(function() {
		    	$('iframe[src="about:blank"]')[0].style.bottom = '55px';
				$('iframe[src="about:blank"]')[3].style.bottom = '95px';
		    },4000);		
		}
		else{
			setTimeout(function() {
		    	$('iframe[src="about:blank"]')[0].style.bottom = '93px';
				$('iframe[src="about:blank"]')[3].style.bottom = '133px';
		    },1000);

		    setTimeout(function() {
		    	$('iframe[src="about:blank"]')[0].style.bottom = '93px';
				$('iframe[src="about:blank"]')[3].style.bottom = '133px';
		    },4000);		

		}
	};
	Tawk_API.onChatMinimized = function(){
		if (cpath != '/cart') {
			setTimeout(function() {
		    	$('iframe[src="about:blank"]')[0].style.bottom = '55px';
				$('iframe[src="about:blank"]')[3].style.bottom = '95px';
		    },1000);
			setTimeout(function() {
		    	$('iframe[src="about:blank"]')[0].style.bottom = '55px';
				$('iframe[src="about:blank"]')[3].style.bottom = '95px';
		    },2000);		
		}
		else{
			setTimeout(function() {
		    	$('iframe[src="about:blank"]')[0].style.bottom = '93px';
				$('iframe[src="about:blank"]')[3].style.bottom = '133px';
		    },1000);
			setTimeout(function() {
		    	$('iframe[src="about:blank"]')[0].style.bottom = '93px';
				$('iframe[src="about:blank"]')[3].style.bottom = '133px';
		    },2000);		
		}
	};
}
</script>
<!--End of Tawk.to Script-->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1217075061792748');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1217075061792748&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
