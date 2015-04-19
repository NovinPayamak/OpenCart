<?php

/* SMS WebService Pro v3.9 */

require_once(DIR_SYSTEM . 'library/nuSoap/nusoap.php');

class ModelModuleWsPayamak extends Model {
	private $data = array();
	private $errors = array();
	private $WebService = array();
	private $Connected = null;
	
	public function testConnect() {
		if (is_null($this->Connected)) {
			$siteGet  = array('Provider-10', 'Provider-11');
			$siteURLs = array(
				'Provider-1'  => 'http://{SiteURL}/Post/Send.asmx?wsdl',
				'Provider-2'  => 'http://{SiteURL}/API/Send.asmx?wsdl',
				'Provider-3'  => 'http://{SiteURL}/post/send.asmx?wsdl',
				'Provider-4'  => 'http://{SiteURL}/class/sms/webservice/server.php?wsdl',
				'Provider-5'  => 'http://{SiteURL}/post/send.asmx?wsdl',
				'Provider-6'  => 'http://{SiteURL}/post/send.asmx?wsdl',
				'Provider-7'  => 'http://{SiteURL}/API/Send.asmx?wsdl',
				'Provider-8'  => 'http://{SiteURL}/webservice/?WSDL',
				'Provider-9'  => 'http://{SiteURL}/webservice/smsService.php?wsdl',
				'Provider-10' => 'http://{SiteURL}/APISend.aspx',
				'Provider-11' => 'http://{SiteURL}/WS/httpsend/'
			);
			
			$ch = curl_init();
			$url = str_replace('{SiteURL}', $this->config->get('ws_payamak_site_url'), $siteURLs['Provider-' . $this->config->get('ws_payamak_site_group')]);
			$url = 'http://www.novinpayamak.com/services/SMSBox/wsdl';
			
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ($ch, CURLOPT_VERBOSE, true);
			curl_setopt ($ch, CURLINFO_HEADER_OUT, true);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11");
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			$content = curl_exec($ch);
			$info	 = curl_getinfo($ch);
			
			if (!in_array('Provider-' . $this->config->get('ws_payamak_site_group'), $siteGet)) {
				$return = $info['http_code'] == 200 && strpos($info['content_type'], 'text/xml') !== false && curl_errno($ch) == 0;
			} else {
				$return = $info['http_code'] == 200 && curl_errno($ch) == 0;
			}
				curl_close($ch);
			$this->Connected = true;
				return true;
			/*if ($return) {
				$this->Connected = true;
				return true;
			} else {
				$this->Connected = false;
				return false;
			}*/
		} else {
			return $this->Connected;
		}
	}
	
	public function Connect() {
		list($site_group, $site_url) = explode("||", $this->config->get('ws_payamak_provider'));
		
		$this->config->set('ws_payamak_site_group', trim($site_group));
		$this->config->set('ws_payamak_site_url', trim($site_url));
		
		$method = 'SmsLink_' . $this->config->get('ws_payamak_site_group');
		
		$this->load->library('Ws-ShortMessage-Classes/sms_link_' . $this->config->get('ws_payamak_site_group'));
		$this->WebService = new $method();
		
		/* Config PHP.ini */
		ini_set("soap.wsdl_cache_enabled", "0");
		
		/* Config System */
		$this->data['WebService']['UserName'] = $this->config->get('ws_payamak_username');
		$this->data['WebService']['UserPassword'] = $this->config->get('ws_payamak_password');
		$this->data['WebService']['NumberSend'] = $this->config->get('ws_payamak_numberSend');
		$this->data['WebService']['NumberReceve'] = $this->config->get('ws_payamak_numberReceve');
		$this->data['WebService']['Flash'] = $this->config->get('ws_payamak_flash');
		$this->data['WebService']['SiteUrl'] = $this->config->get('ws_payamak_site_url');
		$this->data['WebService']['Options'] = unserialize(base64_decode($this->config->get('ws_payamak_options')));
		
		/* Config WebService */		
		$this->WebService->data['Config']['UserName'] = $this->data['WebService']['UserName'];
		$this->WebService->data['Config']['UserPassword'] = $this->data['WebService']['UserPassword'];
		$this->WebService->data['Config']['NumberSend'] = $this->data['WebService']['NumberSend'];
		$this->WebService->data['Config']['NumberReceve'] = $this->data['WebService']['NumberReceve'];
		$this->WebService->data['Config']['Flash'] = $this->data['WebService']['Flash'];
		$this->WebService->data['Config']['SiteUrl'] = $this->data['WebService']['SiteUrl'];
		$this->WebService->data['Resource']['Parameters'] = $this->data['WebService']['Options'];
	}
	
	public function GetCredit($error_log = true) {
		$this->Connect();
		$ger_credit = $this->WebService->GetCredit();
		
		if ($this->WebService->errors) {
			if ($error_log) {
				$this->log->write('خطای دریافت اعتبار پنل (' . $this->data['WebService']['SiteUrl'] . '): ' . implode(' - ', $this->WebService->errors));
			}
		}
		
		return $ger_credit;
	}
	
	public function SendSMS($to, $message = "", $data = array(), $error_log = true) {
		$phone_numbers = array();
		
		// Rebuild (To)
		foreach ($to as $phone_number) {
			$check_number = preg_match('/^(?:(?:(?:\+|00)98)|0)?9[123]\d{8}$/', $phone_number);
						
			if ($check_number) {
				$phone_numbers[] = preg_replace('/.*?(9[123]\d{8})$/', '0$1', $phone_number);
			}
		}
		
		// Rebuild (To)
		$phone_numbers = array_flip($phone_numbers);
		if (isset($phone_numbers[''])) { unset($phone_numbers['']); }
		
		$phone_numbers = array_flip($phone_numbers);
		
		$params = array();
		$params['message'] = trim($message, "\r\n ");
		$params['numbers'] = $phone_numbers;
		$params['provider'] = $this->config->get('ws_payamak_provider');
		
		// Check Vars
		$send_sms = true;
		$send_sms = empty($params['message'])  ? false : $send_sms;
		$send_sms = empty($params['numbers'])  ? false : $send_sms;
		$send_sms = empty($params['provider']) ? false : $send_sms;
		
		if ($send_sms) {
			if (isset($data['products'])) {
			
				$products = array();
				foreach ($data['products'] as $product) {
					
					$options = array();
					foreach ($product['option'] as $option) { 
						$options[] = $option['name'] . " :: " . $option['value']; 
					}
					
					$products[] = (string)$product['name'] . " (" . $product['quantity'] . ")" . (count($options) > 0 ? "(" . implode(' - ', $options) . ")" : "") . " :: " . $product['total'];
				}
			}
			
			if (isset($data['total'])) {				
				if ($this->config->get('ws_payamak_currency')) {
					$data['total'] = $this->currency->format($data['total'], $data['currency_code'], false, false);
					$data['total'] = $this->currency->convert($data['total'], $data['currency_code'], $this->config->get('ws_payamak_currency'));
					$data['total'] = $this->currency->format($data['total'], $this->config->get('ws_payamak_currency'), 1, true);
				} else {
					$data['total'] = $this->currency->format($data['total'], $data['currency_code'], false, true);
				}
			}
		
			if ($this->config->get('config_secure')) {
				$data['Shop_URL'] = $this->config->get('config_ssl') ? $this->config->get('config_ssl') : (defined('HTTPS_CATALOG') ? HTTPS_CATALOG : "");
			} else {
				$data['Shop_URL'] = $this->config->get('config_url') ? $this->config->get('config_url') : (defined('HTTP_CATALOG') ? HTTP_CATALOG : "");
			}
		
			$info = array(
				/* Data-Shop */
				'Shop_Url' 	     => $data['Shop_URL'],
				'Shop_Name'      => $this->config->get('config_name'),
				'Shop_Owner'     => $this->config->get('config_owner'),
				'Shop_Email'     => $this->config->get('config_email'),
				'Shop_Address'   => $this->config->get('config_address'),
				'Shop_Telephone' => $this->config->get('config_telephone'),
				
				/* Data-Order */
				'Order_Id' 	     => isset($data['order_id']) ? $data['order_id'] : "",
				'Order_Total'    => isset($data['total']) ? $data['total'] : "",
				'Order_Status'   => isset($data['order_status']) ? $data['order_status'] : "",
				'Order_Shipping' => isset($data['shipping_method']) ? $data['shipping_method'] : "",
				'Order_Payment'  => isset($data['payment_method']) ? $data['payment_method'] : "",
				'Order_PayData'  => isset($data['order_comment']) ? $data['order_comment'] : "",
				'Order_Commnet'  => isset($data['comment']) ? $data['comment'] : "",
				'Order_Products' => isset($products) ? implode("\r\n", $products) : "",
				
				/* Data-Admin */
				'Admin_FirstName' => isset($data['admin_firstname']) ? $data['admin_firstname'] : "",
				'Admin_LastName'  => isset($data['admin_lastname']) ? $data['admin_lastname'] : "",
				'Admin_UserName'  => isset($data['admin_username']) ? $data['admin_username'] : "",
				'Admin_Email'  	  => isset($data['admin_email']) ? $data['admin_email'] : "",
				'Admin_IPAddress' => isset($data['admin_ipaddress']) ? $data['admin_ipaddress'] : "",
				
				/* Data-Customer */
				'Customer_Email'  	 => isset($data['email']) ? $data['email'] : "",
				'Customer_FaxNumber' => isset($data['fax']) ? $data['fax'] : "",
				'Customer_Telephone' => isset($data['telephone']) ? $data['telephone'] : "",
				'Customer_Password'  => isset($data['password']) ? $data['password'] : "",
				'Customer_FirstName' => isset($data['firstname']) ? $data['firstname'] : "",
				'Customer_LastName'  => isset($data['lastname']) ? $data['lastname'] : "",
				'Customer_Address_1' => isset($data['address_1']) ? $data['address_1'] : (isset($data['shipping_address_1']) ? $data['shipping_address_1'] : ""),
				'Customer_Address_2' => isset($data['address_2']) ? $data['address_2'] : (isset($data['shipping_address_2']) ? $data['shipping_address_2'] : ""),
				'Customer_PostCode'  => isset($data['postcode']) ? $data['postcode'] : (isset($data['shipping_postcode']) ? $data['shipping_postcode'] : ""),
				'Customer_PostCity'  => isset($data['city']) ? $data['city'] : (isset($data['shipping_city']) ? $data['shipping_city'] : "")
			);
			
			$Replace = array(
				/* Replacement-Shop */
				'{ShopUrl}' 	  => trim($info['Shop_Url']) ? $info['Shop_Url'] : $this->config->get('ws_payamak_variable_char'),
				'{ShopName}' 	  => trim($info['Shop_Name']) ? $info['Shop_Name'] : $this->config->get('ws_payamak_variable_char'),
				'{ShopOwner}' 	  => trim($info['Shop_Owner']) ? $info['Shop_Owner'] : $this->config->get('ws_payamak_variable_char'),
				'{ShopEmail}'  	  => trim($info['Shop_Email']) ? $info['Shop_Email'] : $this->config->get('ws_payamak_variable_char'),
				'{ShopAddress}'   => trim($info['Shop_Address']) ? $info['Shop_Address'] : $this->config->get('ws_payamak_variable_char'),
				'{ShopTelephone}' => trim($info['Shop_Telephone']) ? $info['Shop_Telephone'] : $this->config->get('ws_payamak_variable_char'),
				
				/* Replacement-Order */
				'{OrderId}'    	  => trim($info['Order_Id']) ? $info['Order_Id'] : $this->config->get('ws_payamak_variable_char'),
				'{OrderTotal}' 	  => trim($info['Order_Total']) ? $info['Order_Total'] : $this->config->get('ws_payamak_variable_char'),
				'{OrderStatus}'   => trim($info['Order_Status']) ? $info['Order_Status'] : $this->config->get('ws_payamak_variable_char'),
				'{OrderShipping}' => trim($info['Order_Shipping']) ? $info['Order_Shipping'] : $this->config->get('ws_payamak_variable_char'),
				'{OrderPayment}'  => trim($info['Order_Payment']) ? $info['Order_Payment'] : $this->config->get('ws_payamak_variable_char'),
				'{OrderPayData}'  => trim($info['Order_PayData']) ? $info['Order_PayData'] : $this->config->get('ws_payamak_variable_char'),
				'{OrderComment}'  => trim($info['Order_Commnet']) ? $info['Order_Commnet'] : $this->config->get('ws_payamak_variable_char'),
				'{OrderProducts}' => trim($info['Order_Products']) ? $info['Order_Products'] : $this->config->get('ws_payamak_variable_char'),
				
				/* Replacement-Admin */
				'{ModeratorFirstName}' => trim($info['Admin_FirstName']) ? $info['Admin_FirstName'] : $this->config->get('ws_payamak_variable_char'),
				'{ModeratorLastName}'  => trim($info['Admin_LastName']) ? $info['Admin_LastName'] : $this->config->get('ws_payamak_variable_char'),
				'{ModeratorUserName}'  => trim($info['Admin_UserName']) ? $info['Admin_UserName'] : $this->config->get('ws_payamak_variable_char'),
				'{ModeratorEmail}'	   => trim($info['Admin_Email']) ? $info['Admin_Email'] : $this->config->get('ws_payamak_variable_char'),
				'{ModeratorIPAddress}' => trim($info['Admin_IPAddress']) ? $info['Admin_IPAddress'] : $this->config->get('ws_payamak_variable_char'),
				
				/* Replacement-Customer */
				'{CustomerEmail}'  	   => trim($info['Customer_Email']) ? $info['Customer_Email'] : $this->config->get('ws_payamak_variable_char'),
				'{CustomerFaxNumber}'  => trim($info['Customer_FaxNumber']) ? $info['Customer_FaxNumber'] : $this->config->get('ws_payamak_variable_char'),
				'{CustomerTelephone}'  => trim($info['Customer_Telephone']) ? $info['Customer_Telephone'] : $this->config->get('ws_payamak_variable_char'),
				'{CustomerPassword}'   => trim($info['Customer_Password']) ? $info['Customer_Password'] : $this->config->get('ws_payamak_variable_char'),
				'{CustomerFirstname}'  => trim($info['Customer_FirstName']) ? $info['Customer_FirstName'] : $this->config->get('ws_payamak_variable_char'),
				'{CustomerLastname}'   => trim($info['Customer_LastName']) ? $info['Customer_LastName'] : $this->config->get('ws_payamak_variable_char'),
				'{CustomerAddressOne}' => trim($info['Customer_Address_1']) ? $info['Customer_Address_1'] : $this->config->get('ws_payamak_variable_char'),
				'{CustomerAddressTwo}' => trim($info['Customer_Address_2']) ? $info['Customer_Address_2'] : $this->config->get('ws_payamak_variable_char'),
				'{CustomerPostCode}'   => trim($info['Customer_PostCode']) ? $info['Customer_PostCode'] : $this->config->get('ws_payamak_variable_char'),
				'{CustomerPostCity}'   => trim($info['Customer_PostCity']) ? $info['Customer_PostCity'] : $this->config->get('ws_payamak_variable_char')
			);
			
			/* Replace Variables */
			$message = str_replace(array_keys($Replace), $Replace, $message);
			
			$this->Connect();
			
			/* Config WebService */
			if (strpos($message, '{FlashSend}') !== false) {
				$this->WebService->data['Config']['Flash'] = /* Enable Flash Send */ true;
				
				$message = str_replace('{FlashSend}', '', $message);
			}
			
			if ($this->testConnect()) {
				$this->WebService->SendSMS($phone_numbers, trim($message, "\r\n "));
				
				if ($this->WebService->errors) {
					$error_string = ('خطای ارسال پیامک (' . $this->data['WebService']['SiteUrl'] . '): ' . implode(' - ', $this->WebService->errors));
					
					if ($error_log) {
						$this->log->write($error_string);
					}
					
					return $error_string;
				}
			} else {
				$error_string = ('خطای ارسال پیامک (' . $this->data['WebService']['SiteUrl'] . '): اتصال به وبسرویس ناموفق بود.');
			
				if ($error_log) {
					$this->log->write($error_string);
				}
				
				return $error_string;
			}
			
			
		}
		
		return true;
	}
}
?>