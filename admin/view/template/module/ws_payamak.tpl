<?php echo $header; ?>
<style type="text/css">
	.text_add { color: blue; font-family: tahoma; font-weight: normal; font-size: 15px; text-decoration: none; cursor: pointer; }
	.text_remove { color: gray; font-family: tahoma; font-weight: normal; font-size: 11px; text-decoration: none; cursor: pointer; }
	select.status { width: 100px; }
	textarea { margin-right: 0px; }
</style>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<div class="box">    
		<div class="heading">
			<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
		</div>
		<div class="content">
			<div id="tabs" class="htabs">
				<a href="#tab-general"><?php echo $tab_general; ?></a>
				<a href="#tab-send-sms"><?php echo $tab_send_sms; ?></a>
				<a href="#tab-variables"><?php echo $tab_variables; ?></a>
			</div>
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">     
				<div id="tab-general" class="page">
					<h2><?php echo $fields_configuration_1; ?></h2>
					<table class="form">
						<tr>
							<td><span class="required">*</span> <?php echo $entry_provider; ?></td>
							<td>
								<select id="provider" name="ws_payamak_provider">
									<option value=""><?php echo $text_select; ?></option>
									<?php
										## Links 1 (SMSOnline)
										## Links 2 (Post-Chi)
										## Links 3 (Sinet)
										## Links 4 (Ponishasms - SMSSoft)
										## Links 5 (SabaPayamak)
										## Links 6 (2000SMS)
										## Links 7 (IrPayamak)
										## Links 8 (HostIran)
										
										## Links 1 (SmsOnline) :: 91.98.101.219
										## Links 2 (SmsOnline) :: 79.175.169.232
										## Links 3 (SmsOnline) :: 79.175.169.235
										## Links 4 (Post-Chi) :: 79.175.161.2
										## Links 5 (Sinet) :: 87.107.121.51
										## Links 6 (Sinet) :: 87.107.121.52
										## Links 7 (Sinet) :: 87.107.121.53
										## Links 8 (Sinet) :: 87.107.121.54
										## Links 9 (Sinet) :: 87.107.121.165
										## Links 10 (2000SMS) :: 78.46.198.206
										## Links 11 (NaslJavan) :: 158.58.184.43 (Apache is functioning normally)
										## Links 12 (NovinPayamak) :: 94.232.169.230 (Apache is functioning normally)
										## Links 13 (IrPayamak) :: 130.185.75.9
										## Links 14 (SabaPayamak) :: 79.175.161.3
										## Links 15 (Ponishasms) :: 185.4.28.180
										## Links 16 (SMSSoft) :: 185.4.28.100
										## Links 16 (HostIran) :: 5.144.130.240
										## Links 17 (PopakSMS) :: 87.107.68.162
										
										## Hamavaran :: http://www.hamavaran.com/
										## MagFa :: http://www.magfa.com/
										## Rahyab :: http://sms.rahyab.ir/
										## Soroush :: http://sinet.ir/farsi/ (87.107.121.51 - 87.107.121.52 - 87.107.121.53 - 87.107.121.54 - 87.107.121.165) 
										## SmsOnline :: http://smsonline.ir/ (91.98.101.219 - 79.175.169.232 - 79.175.169.235)
										## IrPayamak :: http://www.ir-payamak.com/ 
										
										if ($providers) {
											foreach ($providers as $file => $provider) {
												echo '<optgroup label="Group-' . $file . '">'; 
												
												foreach ($provider as $link) { 
													echo '<option value="' . $file . ' || ' . $link . '" ' . ($ws_payamak_provider == ($file . " || " . $link) ? 'selected="selected"' : '') . '>' . $link . '</option>'; 
												}; 
												
												echo '</optgroup>';
											}
										}
									?>
								</select>
								<?php if ($error_provider) { ?>
									<span class="error"><?php echo $error_provider; ?></span>
								<?php } ?>
							</td>
						</tr>
						<?php if ($ws_payamak_credit) { ?>
						<tr>
							<td><?php echo $text_credit; ?></td>
							<td><b><?php echo $ws_payamak_credit_value; ?> <?php echo $ws_payamak_credit_type == 'Amount' ? $text_rial : $text_smservice; ?></b></td>
						</tr>
						<?php } ?>
						<tr>
							<td><span class="required">*</span> <?php echo $entry_username; ?></td>
							<td>
								<input type="text" name="ws_payamak_username" value="<?php echo $ws_payamak_username; ?>" size="25" />
								<?php if ($error_username) { ?>
									<span class="error"><?php echo $error_username; ?></span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td><span class="required">*</span> <?php echo $entry_password; ?></td>
							<td>
								<input type="text" name="ws_payamak_password" value="<?php echo $ws_payamak_password; ?>" size="25" />
								<?php if ($error_password) { ?>
									<span class="error"><?php echo $error_password; ?></span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td><span class="required">*</span> <?php echo $entry_numberSend; ?></td>
							<td>
								<input type="text" name="ws_payamak_numberSend" value="<?php echo $ws_payamak_numberSend; ?>" size="25" />
								<?php if ($error_numberSend) { ?>
									<span class="error"><?php echo $error_numberSend; ?></span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_numberReceve; ?></td>
							<td><input type="text" name="ws_payamak_numberReceve" value="<?php echo $ws_payamak_numberReceve; ?>" size="25" /></td>
						</tr>
						<tr>
							<td><?php echo $entry_options; ?></td>
							<td><input type="text" name="ws_payamak_options" value="<?php echo $ws_payamak_options; ?>" size="25" /></td>
						</tr>
						<tr>
							<td><?php echo $entry_flash; ?></td>
							<td>
								<select class="status" name="ws_payamak_flash">
									<option value="1" <?php echo $ws_payamak_flash ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$ws_payamak_flash  ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_currency; ?></td>
							<td>
								<select name="ws_payamak_currency">
									<option value=""><?php echo $text_default; ?></option>
									
									<?php foreach ($currencies as $currency) { ?>
										<option value="<?php echo $currency['code']; ?>" <?php echo $ws_payamak_currency == $currency['code'] ? 'selected="selected"' : ""; ?>><?php echo $currency['title']; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_variable_char; ?></td>
							<td><input type="text" name="ws_payamak_variable_char" value="<?php echo $ws_payamak_variable_char; ?>" size="25" /></td>
						</tr>
					</table>
					
					<h2><?php echo $fields_configuration_3; ?></h2>
					<table class="form">
						<!-- Send to Administrator -->
						<tr>
							<td><?php echo $entry_sms_admin_customer_register; ?></td>
							<td>
								<select class="status" name="sms_admin_customer_register_status">
									<option value="1" <?php echo $sms_admin_customer_register_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_admin_customer_register_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_admin_customer_register" cols="40" rows="4"><?php echo $sms_admin_customer_register; ?></textarea>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_sms_admin_customer_checkout; ?></td>
							<td>
								<select class="status" name="sms_admin_customer_checkout_status">
									<option value="1" <?php echo $sms_admin_customer_checkout_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_admin_customer_checkout_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_admin_customer_checkout" cols="40" rows="4"><?php echo $sms_admin_customer_checkout; ?></textarea>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_sms_admin_admin_login; ?></td>
							<td>
								<select class="status" name="sms_admin_admin_login_status">
									<option value="1" <?php echo $sms_admin_admin_login_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_admin_admin_login_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_admin_admin_login" cols="40" rows="4"><?php echo $sms_admin_admin_login; ?></textarea>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_sms_admin_affiliate_register; ?></td>
							<td>
								<select class="status" name="sms_admin_affiliate_register_status">
									<option value="1" <?php echo $sms_admin_affiliate_register_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_admin_affiliate_register_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_admin_affiliate_register" cols="40" rows="4"><?php echo $sms_admin_affiliate_register; ?></textarea>
							</td>
						</tr>
					</table>
					
					<h2><?php echo $fields_configuration_4; ?></h2>
					<table class="form">
						<!-- Send to Customer -->
						<tr>
							<td><?php echo $entry_sms_customer_register; ?></td>
							<td>
								<select class="status" name="sms_customer_register_status">
									<option value="1" <?php echo $sms_customer_register_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_customer_register_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_customer_register" cols="40" rows="4"><?php echo $sms_customer_register; ?></textarea>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_sms_customer_login; ?></td>
							<td>
								<select class="status" name="sms_customer_login_status">
									<option value="1" <?php echo $sms_customer_login_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_customer_login_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_customer_login" cols="40" rows="4"><?php echo $sms_customer_login; ?></textarea>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_sms_customer_checkout; ?></td>
							<td>
								<select class="status" name="sms_customer_checkout_status">
									<option value="1" <?php echo $sms_customer_checkout_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_customer_checkout_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_customer_checkout" cols="40" rows="4"><?php echo $sms_customer_checkout; ?></textarea>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_sms_customer_orderStatus; ?></td>
							<td>
								<select class="status" name="sms_customer_orderStatus_status">
									<option value="1" <?php echo $sms_customer_orderStatus_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_customer_orderStatus_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_customer_orderStatus" cols="40" rows="4"><?php echo $sms_customer_orderStatus; ?></textarea>
							</td>
						</tr>
					</table>
					
					<h2><?php echo $fields_configuration_5; ?></h2>
					<table class="form">
						<!-- Send to Affiliate -->
						<tr>
							<td><?php echo $entry_sms_affiliate_register; ?></td>
							<td>
								<select class="status" name="sms_affiliate_register_status">
									<option value="1" <?php echo $sms_affiliate_register_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_affiliate_register_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_affiliate_register" cols="40" rows="4"><?php echo $sms_affiliate_register; ?></textarea>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_sms_affiliate_login; ?></td>
							<td>
								<select class="status" name="sms_affiliate_login_status">
									<option value="1" <?php echo $sms_affiliate_login_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
									<option value="0" <?php echo !$sms_affiliate_login_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
								</select>
								<br /><textarea name="sms_affiliate_login" cols="40" rows="4"><?php echo $sms_affiliate_login; ?></textarea>
							</td>
						</tr>
					</table>
				</div>
				
				<div id="tab-send-sms" class="page">
					<h2><?php echo $fields_configuration_6; ?></h2>
					<table class="form">
						<tr>
							<td><?php echo $entry_testSM_to; ?></td>
							<td><input type="text" id="ws_payamak_test_sms_to" size="25" /></td>
						</tr>
						<tr>
							<td><?php echo $entry_testSM_text; ?></td>
							<td><textarea id="ws_payamak_test_sms_message" cols="40" rows="4">متن پیامک تست</textarea></td>
						</tr>
					</table>
					<div class="buttons">
						<a id="button-send" class="button"><span><?php echo $button_send; ?></span></a>
					</div>
				</div>
				
				<div id="tab-variables" class="page">
					<h2>متغیر های متنی (فروشگاه)</h2>
					<p>{ShopUrl} :: آدرس دامنه</p>
					<p>{ShopName} :: نام فروشگاه</p>
					<p>{ShopOwner} :: صاحب فروشگاه</p>
					<p>{ShopEmail} :: ایمیل</p>
					<p>{ShopAddress} :: آدرس</p>
					<p>{ShopTelephone} :: تلفن</p>
					
					<h2>متغیر های متنی (سفارش)</h2>
					<p>{OrderId} :: شماره سفارش</p>
					<p>{OrderTotal} :: مبلغ سفارش به ریال</p>
					<p>{OrderStatus} :: وضعیت فعلی سفارش</p>
					<p>{OrderShipping} :: نحوه حمل و نقل</p>
					<p>{OrderPayment} :: نحوه پرداخت</p>
					<p>{OrderPayData} :: توضیحات سفارش (اطلاعات بازگشتی از بانک یا شرکت پست)</p>
					<p>{OrderComment} :: کامنت وارد شده توسط کاربر</p>
					<p>{OrderProducts} :: محصولات موجود در سفارش</p>
					
					<h2>متغیر های متنی (مدیریت)</h2>
					<p>{ModeratorFirstName} :: نام مدیریت</p>
					<p>{ModeratorLastName} :: نام خانوادگی</p>
					<p>{ModeratorUserName} :: نام کاربری</p>
					<p>{ModeratorEmail} :: آدرس ایمیل</p>
					<p>{ModeratorIPAddress} :: آدرس آی پی</p>

					<h2>متغیر های متنی (مشتری و بازاریاب)</h2>
					<p>{CustomerEmail} :: ایمیل مشتری جدید</p>
					<p>{CustomerPassword} :: رمز عبور مشتری جدید</p>
					<p>{CustomerFirstname} :: نام مشتری</p>
					<p>{CustomerLastname} :: نام خانوادگی مشتری</p>
					<p>{CustomerTelephone} :: شماره تلفن</p>
					<p>{CustomerFaxNumber} :: شماره فکس</p>
					<p>{CustomerAddressOne} :: آدرس یک</p>
					<p>{CustomerAddressTwo} :: آدرس دو</p>
					<p>{CustomerPostCode} :: کد پستی</p>
					<p>{CustomerPostCity} :: شهر مشتری</p>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		$('#tabs a').tabs(); 
		
		$('#button-send').bind('click', function() {
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: 'index.php?route=module/ws_payamak/testSMS&token=<?php echo $token; ?>',
				data: 'to=' + encodeURIComponent($('input[id=\'ws_payamak_test_sms_to\']').val()) + '&message=' + encodeURIComponent($('textarea[id=\'ws_payamak_test_sms_message\']').val()),
				beforeSend: function() {
					$('.success, .warning, .attention').remove();
				
					$('#button-send').attr('disabled', true);
					$('.box').before('<div class="attention"><?php echo $text_wait; ?></div>');
				},
						
				success: function(json) {
					$('#button-send').attr('disabled', false);					
					$('.attention, .error').remove();
					
					if (json['error']) {
						if (json['error']['to']) {
							$('#ws_payamak_test_sms_to').after('<span class="error">' + json['error']['to'] + '</span>');
						}
				
						if (json['error']['message']) {
							$('#ws_payamak_test_sms_message').after('<span class="error">' + json['error']['message'] + '</span>');
						}
					}
					
					if (json['error_warning']) { 
						$('.box').before('<div class="warning">' + json['error_warning'] + '</div>');
					}
					
					if (json['success']) {
						$('.box').before('<div class="success">' + json['success'] + '</div>');
					}
					
					$('.success, .warning, .attention').click(function() { 
						$(this).fadeOut(); 
					});
				}, 
				
				error: function(data) {
					alert("Ajax-Error: " + data);
					
					$(".wait").fadeOut();
				}
			});
		});
		
		$('select[id=provider]').change(function() {
			current_provider = $(this).val();
			
			if (current_provider) {
				$.ajax({
					type: "GET",
					dataType: 'json',
					url: "index.php?route=module/ws_payamak/testConnect&token=<?php echo $token; ?>",
					data: {provider: current_provider},

					beforeSend: function() {
						$('.success, .warning, .attention').remove();
						
						$("#provider").attr("disabled", true);
						$('.box').before('<div class="attention"><?php echo $text_wait; ?></div>');
					},
					
					success: function(json) {
						$("#provider").attr("disabled", false);
						$('.attention').remove();
						
						if (json['success']) {
							$('.box').before('<div class="success">' + json['success'] + '</div>');
						}
						
						if (json['error']) {
							$('.box').before('<div class="warning">' + json['error'] + '</div>');
						}
						
						$('.success, .warning, .attention').click(function() { 
							$(this).fadeOut(); 
						});
					},
					
					error: function(data) {
						alert("Ajax-Error: " + data);
						
						$(".wait").fadeOut();
					}
				});
			}
		});
	});
//-->
</script>

<?php echo $footer; ?> 