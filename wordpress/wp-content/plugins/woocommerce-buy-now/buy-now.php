<?php
/**
 * Plugin Name: 우커머스 바로 구매하기
 * Plugin URI: http://wordpressn.com
 * Description: 우커머스에서 바로 구매하기 버튼을 활성화 시키기 위한 플러그인 입니다
 * Version: 1.0.1
 * Author: Hypnos
 * Author URI: http://wordpressn.com
 * Text Domain: WordpressN
 * License: A short license name. Example: GPL2
 */



function nom_buy_now_after_add_to_cart_button(){ ?>
	<script type="text/javascript">
		jQuery(document).ready(function($){ 
			$('.buy-now').on('click',function(e){
				$('#buy-now-field').val('1');
			});
		});
	</script>
	<input type="hidden" name="nom_buy_now_field" id="buy-now-field" value="">
<?php
	echo '<button type="submit" data-product-id="'.get_the_ID().'" class="button buy-now" style="margin-left:4px;">'. apply_filters('nom_woocommerce_buy_now_button_text', '구매하기') .'</button>';
}
add_action('woocommerce_after_add_to_cart_button','nom_buy_now_after_add_to_cart_button');

function nom_buy_now_after_add_to_cart_redirect_to_checkout() {
	global $woocommerce;

	$checkout_url = $woocommerce->cart->get_checkout_url();    
	if( !empty($_REQUEST['nom_buy_now_field']) && ($_REQUEST['nom_buy_now_field'] == 1) ){
		return $checkout_url;
		
	}
}
add_filter ('add_to_cart_redirect', 'nom_buy_now_after_add_to_cart_redirect_to_checkout');

?>