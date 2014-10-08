<?php
class ControllerModuleWsPayamak extends Controller {
	private $error = array();
	
	public function index() {
		
		/* Language */
		$this->load->language('module/ws_payamak');
		$this->document->setTitle($this->language->get('heading_title'));
		
		/* Model */
		$this->load->model('setting/setting');
		$this->load->model('design/layout');

		/* (Update) */
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ws_payamak', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_credit'] = $this->language->get('text_credit');
		$this->data['text_smservice'] = $this->language->get('text_smservice');
		$this->data['text_rial'] = $this->language->get('text_rial');
		$this->data['text_toman'] = $this->language->get('text_toman');
		
		$this->data['button_send'] = $this->language->get('button_send');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_send_sms'] = $this->language->get('tab_send_sms');
		$this->data['tab_variables'] = $this->language->get('tab_variables');
		
		$this->data['fields_configuration_1'] = $this->language->get('fields_configuration_1');
		$this->data['fields_configuration_2'] = $this->language->get('fields_configuration_2');
		$this->data['fields_configuration_3'] = $this->language->get('fields_configuration_3');
		$this->data['fields_configuration_4'] = $this->language->get('fields_configuration_4');
		$this->data['fields_configuration_5'] = $this->language->get('fields_configuration_5');
		$this->data['fields_configuration_6'] = $this->language->get('fields_configuration_6');
		
		$this->data['entry_provider'] = $this->language->get('entry_provider');
		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_numberSend'] = $this->language->get('entry_numberSend');
		$this->data['entry_numberReceve'] = $this->language->get('entry_numberReceve');
		$this->data['entry_options'] = $this->language->get('entry_options');
		$this->data['entry_flash'] = $this->language->get('entry_flash');
		$this->data['entry_currency'] = $this->language->get('entry_currency');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_variable_char'] = $this->language->get('entry_variable_char');
		$this->data['entry_testSM_to'] = $this->language->get('entry_testSM_to');
		$this->data['entry_testSM_text'] = $this->language->get('entry_testSM_text');
		
		$this->data['entry_sms_admin_customer_register'] = $this->language->get('entry_sms_admin_customer_register');
		$this->data['entry_sms_admin_customer_checkout'] = $this->language->get('entry_sms_admin_customer_checkout');
		$this->data['entry_sms_admin_admin_login'] = $this->language->get('entry_sms_admin_admin_login');
		$this->data['entry_sms_admin_affiliate_register'] = $this->language->get('entry_sms_admin_affiliate_register');
		
		$this->data['entry_sms_customer_register'] = $this->language->get('entry_sms_customer_register');
		$this->data['entry_sms_customer_login'] = $this->language->get('entry_sms_customer_login');
		$this->data['entry_sms_customer_checkout'] = $this->language->get('entry_sms_customer_checkout');
		$this->data['entry_sms_customer_orderStatus'] = $this->language->get('entry_sms_customer_orderStatus');
		
		$this->data['entry_sms_affiliate_register'] = $this->language->get('entry_sms_affiliate_register');
		$this->data['entry_sms_affiliate_login'] = $this->language->get('entry_sms_affiliate_login');
		
		/* Errors */
		if (isset($this->error['provider'])) { 
			$this->data['error_provider'] = $this->error['provider'];
		} else {
			$this->data['error_provider'] = '';
		}
		
		if (isset($this->error['username'])) { 
			$this->data['error_username'] = $this->error['username'];
		} else {
			$this->data['error_username'] = '';
		}
		
		if (isset($this->error['password'])) { 
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
		if (isset($this->error['numberSend'])) { 
			$this->data['error_numberSend'] = $this->error['numberSend'];
		} else {
			$this->data['error_numberSend'] = '';
		}
		
		/* Warnings */
		$this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : "";
		
		if (!extension_loaded('soap')) {
			$this->data['error_warning'] = $this->language->get('error_extension_soap');
		}
		
		/* Breadcrumbs */
		$this->data['breadcrumbs'] = array();
   		$this->data['breadcrumbs'][] = array('text' => $this->language->get('text_home'), 'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'), 'separator' => false);
   		$this->data['breadcrumbs'][] = array('text' => $this->language->get('text_module'), 'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'), 'separator' => ' :: ');
   		$this->data['breadcrumbs'][] = array('text' => $this->language->get('heading_title'), 'href' => $this->url->link('module/ws_payamak', 'token=' . $this->session->data['token'], 'SSL'), 'separator' => ' :: ');
		
		/* Actions */
		$this->data['action'] = $this->url->link('module/ws_payamak', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		/* (Fields)->Module */
		$this->data['ws_payamak_provider'] = isset($this->request->post['ws_payamak_provider']) ? $this->request->post['ws_payamak_provider'] : $this->config->get('ws_payamak_provider');
		$this->data['ws_payamak_username'] = isset($this->request->post['ws_payamak_username']) ? $this->request->post['ws_payamak_username'] : $this->config->get('ws_payamak_username');
		$this->data['ws_payamak_password'] = isset($this->request->post['ws_payamak_password']) ? $this->request->post['ws_payamak_password'] : $this->config->get('ws_payamak_password');
		$this->data['ws_payamak_numberSend'] = isset($this->request->post['ws_payamak_numberSend']) ? $this->request->post['ws_payamak_numberSend'] : $this->config->get('ws_payamak_numberSend');
		$this->data['ws_payamak_numberReceve'] = isset($this->request->post['ws_payamak_numberReceve']) ? $this->request->post['ws_payamak_numberReceve'] : $this->config->get('ws_payamak_numberReceve');
		$this->data['ws_payamak_options'] = isset($this->request->post['ws_payamak_options']) ? $this->request->post['ws_payamak_options'] : $this->config->get('ws_payamak_options');
		$this->data['ws_payamak_flash'] = isset($this->request->post['ws_payamak_flash']) ? $this->request->post['ws_payamak_flash'] : $this->config->get('ws_payamak_flash');
		$this->data['ws_payamak_currency'] = isset($this->request->post['ws_payamak_currency']) ? $this->request->post['ws_payamak_currency'] : $this->config->get('ws_payamak_currency');
		$this->data['ws_payamak_variable_char'] = isset($this->request->post['ws_payamak_variable_char']) ? $this->request->post['ws_payamak_variable_char'] : $this->config->get('ws_payamak_variable_char');
		//$this->data['ws_payamak_status'] = isset($this->request->post['ws_payamak_status']) ? $this->request->post['ws_payamak_status'] : $this->config->get('ws_payamak_status');
		
		$this->data['sms_admin_customer_register_status'] = isset($this->request->post['sms_admin_customer_register_status']) ? $this->request->post['sms_admin_customer_register_status'] : $this->config->get('sms_admin_customer_register_status');
		$this->data['sms_admin_customer_checkout_status'] = isset($this->request->post['sms_admin_customer_checkout_status']) ? $this->request->post['sms_admin_customer_checkout_status'] : $this->config->get('sms_admin_customer_checkout_status');
		$this->data['sms_admin_admin_login_status'] = isset($this->request->post['sms_admin_admin_login_status']) ? $this->request->post['sms_admin_admin_login_status'] : $this->config->get('sms_admin_admin_login_status');
		$this->data['sms_admin_affiliate_register_status'] = isset($this->request->post['sms_admin_affiliate_register_status']) ? $this->request->post['sms_admin_affiliate_register_status'] : $this->config->get('sms_admin_affiliate_register_status');
		$this->data['sms_customer_register_status'] = isset($this->request->post['sms_customer_register_status']) ? $this->request->post['sms_customer_register_status'] : $this->config->get('sms_customer_register_status');
		$this->data['sms_customer_login_status'] = isset($this->request->post['sms_customer_login_status']) ? $this->request->post['sms_customer_login_status'] : $this->config->get('sms_customer_login_status');
		$this->data['sms_customer_checkout_status'] = isset($this->request->post['sms_customer_checkout_status']) ? $this->request->post['sms_customer_checkout_status'] : $this->config->get('sms_customer_checkout_status');
		$this->data['sms_customer_orderStatus_status'] = isset($this->request->post['sms_customer_orderStatus_status']) ? $this->request->post['sms_customer_orderStatus_status'] : $this->config->get('sms_customer_orderStatus_status');
		$this->data['sms_affiliate_register_status'] = isset($this->request->post['sms_affiliate_register_status']) ? $this->request->post['sms_affiliate_register_status'] : $this->config->get('sms_affiliate_register_status');
		$this->data['sms_affiliate_login_status'] = isset($this->request->post['sms_affiliate_login_status']) ? $this->request->post['sms_affiliate_login_status'] : $this->config->get('sms_affiliate_login_status');
		
		$this->data['sms_admin_customer_register'] = isset($this->request->post['sms_admin_customer_register']) ? $this->request->post['sms_admin_customer_register'] : $this->config->get('sms_admin_customer_register');
		$this->data['sms_admin_customer_checkout'] = isset($this->request->post['sms_admin_customer_checkout']) ? $this->request->post['sms_admin_customer_checkout'] : $this->config->get('sms_admin_customer_checkout');
		$this->data['sms_admin_admin_login'] = isset($this->request->post['sms_admin_admin_login']) ? $this->request->post['sms_admin_admin_login'] : $this->config->get('sms_admin_admin_login');
		$this->data['sms_admin_affiliate_register'] = isset($this->request->post['sms_admin_affiliate_register']) ? $this->request->post['sms_admin_affiliate_register'] : $this->config->get('sms_admin_affiliate_register');
		$this->data['sms_customer_register'] = isset($this->request->post['sms_customer_register']) ? $this->request->post['sms_customer_register'] : $this->config->get('sms_customer_register');
		$this->data['sms_customer_login'] = isset($this->request->post['sms_customer_login']) ? $this->request->post['sms_customer_login'] : $this->config->get('sms_customer_login');
		$this->data['sms_customer_checkout'] = isset($this->request->post['sms_customer_checkout']) ? $this->request->post['sms_customer_checkout'] : $this->config->get('sms_customer_checkout');
		$this->data['sms_customer_orderStatus'] = isset($this->request->post['sms_customer_orderStatus']) ? $this->request->post['sms_customer_orderStatus'] : $this->config->get('sms_customer_orderStatus');
		$this->data['sms_affiliate_register'] = isset($this->request->post['sms_affiliate_register']) ? $this->request->post['sms_affiliate_register'] : $this->config->get('sms_affiliate_register');
		$this->data['sms_affiliate_login'] = isset($this->request->post['sms_affiliate_login']) ? $this->request->post['sms_affiliate_login'] : $this->config->get('sms_affiliate_login');
		
		/* DataRows */
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['providers'] = array();
		$this->data['link_files'] = scandir(DIR_SYSTEM . '/library/Ws-ShortMessage-Links/');
		
		$this->data['link_files'] = array_flip($this->data['link_files']);
			
		if (isset($this->data['link_files'][''])) { unset($this->data['link_files']['']); }
		if (isset($this->data['link_files']['.'])) { unset($this->data['link_files']['.']); }
		if (isset($this->data['link_files']['..'])) { unset($this->data['link_files']['..']); }
			
		$this->data['link_files'] = array_flip($this->data['link_files']);
		
		// Sort-Groups
		natsort($this->data['link_files']);
		
		foreach ($this->data['link_files'] as $file) {
			$content = trim(file_get_contents(DIR_SYSTEM . '/library/Ws-ShortMessage-Links/' . $file));
			
			if (!empty($content)) {
				$this->data['providers'][str_replace(array('links-', '.txt'), '', $file)] = explode("\n", str_replace("\r", "", $content));
			}
		}
		
		$this->load->model('localisation/currency');
		$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();
		
		$this->data['ws_payamak_credit'] = false;
		
		/*$this->load->model('module/ws_payamak');
		$this->data['ws_payamak_credit'] = $this->model_module_ws_payamak->GetCredit();
		$this->data['ws_payamak_credit_value'] = $this->data['ws_payamak_credit']['credit'];
		$this->data['ws_payamak_credit_type'] = $this->data['ws_payamak_credit']['type'];
		
		if ($this->data['ws_payamak_credit_value'] != 'Not Available') {
			if ($this->data['ws_payamak_credit_type'] == 'Amount') {
				$this->data['ws_payamak_credit_value'] = number_format($this->data['ws_payamak_credit_value'], 0, ',', ',');
			}
		}*/
		
		/* Template */
		$this->template = 'module/ws_payamak.tpl';
		$this->children = array('common/header', 'common/footer');
		
		$this->response->setOutput($this->render());
	}
	
	public function testConnect() {
		$this->load->language('module/ws_payamak');
	
		$json = array();
		
		$siteGet  = array('Provider-10', 'Provider-11');
		$siteURLs = array(
			'Provider-1'  => 'http://{SiteURL}/Post/Send.asmx?wsdl',
			'Provider-2'  => 'http://{SiteURL}/API/Send.asmx?wsdl',
			'Provider-3'  => 'http://87.107.121.52/post/send.asmx?wsdl',
			'Provider-4'  => 'http://{SiteURL}/class/sms/webservice/server.php?wsdl',
			'Provider-5'  => 'http://{SiteURL}/post/send.asmx?wsdl',
			'Provider-6'  => 'http://{SiteURL}/post/send.asmx?wsdl',
			'Provider-7'  => 'http://{SiteURL}/API/Send.asmx?wsdl',
			'Provider-8'  => 'http://{SiteURL}/webservice/?WSDL',
			'Provider-9'  => 'http://{SiteURL}/webservice/smsService.php?wsdl',
			'Provider-10' => 'http://{SiteURL}/APISend.aspx',
			'Provider-11' => 'http://{SiteURL}/WS/httpsend/'
		);
		
		if (isset($this->request->get['provider'])) {
			if (!empty($this->request->get['provider'])) {
				list($site_group, $site_url) = explode("||", $this->request->get['provider']);
		
				$site_group = trim($site_group);
				$site_url = trim($site_url);
				
				$ch = curl_init();
				$url = str_replace('{SiteURL}', $site_url, $siteURLs['Provider-' . $site_group]);
				
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
				
				if (!in_array('Provider-' . $site_group, $siteGet)) {
					$return = $info['http_code'] == 200 && strpos($info['content_type'], 'text/xml') !== false && curl_errno($ch) == 0;
				} else {
					$return = $info['http_code'] == 200 && curl_errno($ch) == 0;
				}
				
				curl_close($ch);
				
				if ($return) {
					$json['success'] = $this->language->get('text_ok_connect');
				} else {
					$json['error'] = sprintf($this->language->get('error_content_type'), $url, $url);
				}
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function testSMS() {
		$this->load->language('module/ws_payamak');
	
		$json = array();
		
		if (!$this->request->post['to']) {
			$json['error']['to'] = $this->language->get('error_testSM_to');
		}
		
		if (!$this->request->post['message']) {
			$json['error']['message'] = $this->language->get('error_testSM_message');
		}
		
		if (!$json) {
			/* WsPayamak */
			$this->load->model('module/ws_payamak');
			$SendSMS = $this->model_module_ws_payamak->SendSMS(array(trim($this->request->post['to'])), $this->request->post['message'], array());
		
			if ($SendSMS === true) {
				$json['success'] = $this->language->get('text_ok_sendsms');
			} else {
				$json['error_warning'] = $SendSMS;
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	private function validate() {
		if (!$this->request->post['ws_payamak_provider']) {
			$this->error['provider'] = $this->language->get('error_provider');
		}
		
		if (!$this->request->post['ws_payamak_username']) {
			$this->error['username'] = $this->language->get('error_username');
		}
		
		if (!$this->request->post['ws_payamak_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}
		
		if (!$this->request->post['ws_payamak_numberSend']) {
			$this->error['numberSend'] = $this->language->get('error_numberSend');
		}
	
		if (!$this->user->hasPermission('modify', 'module/ws_payamak')) { $this->error['warning'] = $this->language->get('error_permission'); }
		return !$this->error ? true : false;
	}
}
?>