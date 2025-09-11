<?php 
	$wa = az_get_config('whatsapp');
	$wa_str = substr($wa, 1);
	$wa_str = str_replace('-', '', $wa_str);
	$wa_str = '+62'.$wa_str;

	$phone_cf = az_get_config('phone');
	$phone_str = str_replace('(', '', $phone_cf);
	$phone_str = str_replace(')','', $phone_str);
	$phone_str = str_replace('-','', $phone_str);
	$phone_str = str_replace(' ','', $phone_str);


	// $product_category = azcms_get_product_category();
	$idmember = $this->session->userdata('idmember');

	$meta_desc = azarr($data_header, 'meta_description', '');
	if (strlen($meta_desc) == 0) {
		$meta_desc = az_get_config('keuntungan');
	}
	$meta_image = azarr($data_header, 'meta_image', '');

	if (strlen($meta_image) == 0) {
		$meta_image = base_url().AZAPP.'assets/logo/share_fb.png';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo azarr($data_header, 'title');?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="facebook-domain-verification" content="otcpkphgogsfmn093trkuxn6oot94a" />
	<meta property="og:image" content="<?php echo $meta_image;?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image:width" content="200" />
	<meta property="og:url" content="<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>" />
	<meta property="og:title" content="<?php echo azarr($data_header, 'title');?>" />
	<meta property="og:description" content="<?php echo $meta_desc;?>" />

	<meta name="google-site-verification" content="yNJ3dBoeF3IqcaSJ2mNW9WiSq7TK1y-lV-TpunKtoQI" />

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-K85DRN6');</script>
	<!-- End Google Tag Manager -->

	<script data-ad-client="ca-pub-9708409925394948" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <link rel="shortcut icon" href="<?php echo base_url().AZAPP.'assets/logo/favicon.png?'.Date('YmdHis');?>" />
    <?php
    	echo az_css();
    ?>
    <script type="text/javascript">
        var base_url = "<?php echo base_url();?>"; 
        var app_url = "<?php echo app_url();?>";
    </script> 
</head>
<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K85DRN6"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	
	<div class="container-menu-xs">
		<div class="cmx-wrap">
			<div class="cmx-head">
				MENU
				<span class="cmx-close"><i class="fa fa-times"></i></span>
			</div>
			<div class="cmx-content">
				<ul class="xs-menu">
					<li>
						<a href="<?php echo app_url();?>">
							<div class="xs-menu-list">
								<div class="xs-menu-ico"><i class="fa fa-home"></i></div>
								<div class="xs-menu-txt">HOME</div>
							</div>
						</a>
					</li>
					
					<li>
						<a href="#">
							<div class="xs-menu-list xs-menu-list-category">
								<div class="xs-menu-ico"><i class="fa fa-list"></i></div>
								<div class="xs-menu-txt">KATEGORI <i class="fa fa-chevron-right caret-category"></i> </div>
							</div>
						</a>
						<ul class="xs-menu-category">
							<?php
								// foreach ($product_category->result() as $key => $value) {
							?>
							<!-- <li>
								<a href="<?php echo app_url().'k/'.$value->url_key;?>">
									<div class="xs-menu-txt"><?php echo $value->product_category_name;?></div>
								</a>
							</li> -->
							<?php
								// }
							?>
						</ul>
					</li>
					<?php 
						if (strlen($idmember) > 0) {
					?>
					<li>
						<a href="<?php echo app_url();?>akun">
							<div class="xs-menu-list">
								<div class="xs-menu-ico"><i class="fa fa-user"></i></div>
								<div class="xs-menu-txt">AKUN</div>
							</div>
						</a>
					</li>
					<li>
						<a href="<?php echo app_url();?>auth/logout">
							<div class="xs-menu-list">
								<div class="xs-menu-ico"><i class="fa fa-sign-out-alt"></i></div>
								<div class="xs-menu-txt">LOGOUT</div>
							</div>
						</a>
					</li>
					<?php
						}
						else {
					?>
					<li>
						<a href="<?php echo app_url();?>login">
							<div class="xs-menu-list">
								<div class="xs-menu-ico"><i class="fa fa-sign-in-alt"></i></div>
								<div class="xs-menu-txt">LOGIN</div>
							</div>
						</a>
					</li>
					<li>
						<a href="<?php echo app_url();?>daftar">
							<div class="xs-menu-list">
								<div class="xs-menu-ico"><i class="fa fa-user-plus"></i></div>
								<div class="xs-menu-txt">DAFTAR</div>
							</div>
						</a>
					</li>
					<?php
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	