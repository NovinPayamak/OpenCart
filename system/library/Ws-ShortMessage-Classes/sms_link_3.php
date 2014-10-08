<?php
final class SmsLink_3 { /* Sinet ... */
	public $data = array();
	public $errors = array();
		
	public function __destruct() {
		$this->data = array();
		$this->errors = array();
	}
	
	public function Connect() {
		$this->data['Proxy'] = new SoapClient("http://" . $this->data['Config']['SiteUrl'] . "/post/send.asmx?wsdl");
	}
	
	public function GetCredit() {
		$params = array();
		$params['username'] = $this->data['Config']['UserName'];
		$params['password'] = $this->data['Config']['UserPassword'];
		
		$this->Connect();
		$this->data['Calls']['GetCredit'] = $this->data['Proxy']->GetCredit($params);
		$this->data['Calls']['GetCredit'] = isset($this->data['Calls']['GetCredit']->GetCreditResult) ? round($this->data['Calls']['GetCredit']->GetCreditResult) : 'Not Available';
		
		## Return
		return array(
			'credit' => $this->data['Calls']['GetCredit'], 
			'type' => 'SMS-Count'
		);
	}
	
	public function SendSMS($to = array(), $message = '') {
		$params = array();
		$params['text'] = $message;
		$params['to'] = $to;
		$params['username'] = $this->data['Config']['UserName'];
		$params['password'] = $this->data['Config']['UserPassword'];
		$params['from']  = $this->data['Config']['NumberSend'];
		$params['isflash'] = $this->data['Config']['Flash'];
		$params['udh'] = "";
    	$params['recId'] = array(0);
    	$params['status'] = 0x0;	
		$client = new SoapClient('http://www.novinpayamak.com/services/SMSBox/wsdl', array('encoding' => 'UTF-8'));
		$flash = false;
		$res = $client->Send(
			array(
				'Auth' 	=> array('number' => $this->data['Config']['UserName'],'pass' => $this->data['Config']['UserPassword']),
				'Recipients' => $to,
				'Message' => array($message),
				'Flash' => $flash
				)
			);
		
		$this->Connect();
		$this->data['Calls']['SendSms'] = $this->data['Proxy']->Send($params);
		
		switch($this->data['Calls']['SendSms']->Status) {
			case '-11' : $this->errors[] = 'اطلاعات ارسال شده ناقص است و يا فرمت ورودي صحيح نيست.'; break;
			case '-22' : $this->errors[] = 'اطلاعات احراز هويت نا معتبر مي باشد.'; break;
			case '-33' : $this->errors[] = 'اعتبار مجازي وب سرويس كافي نمي باشد.'; break;
			case '-44' : $this->errors[] = 'اعتبار حقيقي پنل كاربري كافي نمي باشد.'; break;
			case '-55' : $this->errors[] = 'امكان دسترسي به داده مورد نظر وجود ندارد.'; break;
			case '-66' : $this->errors[] = 'تعداد درخواست ها بيش از حد مجاز مي باشد.'; break;
			
		}
		
		
		## Return
		return $this->data['Calls']['SendSms']->Status;
	}
}
?>