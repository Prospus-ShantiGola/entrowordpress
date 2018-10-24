<?php
/**
	* Component for common function of ZOHO in CakePHP 2.x
	* PHP versions 5.2.8
	* @author     Shanti prakash gola
	* @link       http://deliciouscakephp.com/
	* @version 0.0.2
	* @license   GPL (www.gnu.org/licenses/gpl.html)
	*   - Initial release
	*/
App::uses('Component', 'Controller');

class ZohoComponent extends Component{

    public $components = array('Zoho');

   
   /**
     * Function to save the user into zoho crm contacts section
     */
      function saveUserZohoCrm($user_info){
        $xml_data = "<?xml version='1.0' encoding='UTF-8'?><Contacts>"
                . "<row no='1'>"
                . "<FL val='First Name'>".$user_info['first_name']."</FL>"
                . "<FL val='Last Name'>".$user_info['last_name']."</FL>"
                . "<FL val='Email'>".$user_info['email_address']."</FL>"
                . "<FL val='Lead Source'>".$user_info['lead_source']."</FL>"
                . "</row>"
                . "</Contacts>";

            $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($xml_data),
            "Connection: close",
        );            
    
        $url = "https://crm.zoho.com/crm/private/xml/Contacts/insertRecords";
              $param= "authtoken=42e9474ddfe57b22c19c4ffa8c2e81e5&scope=crmapi&newFormat=1&xmlData=".$xml_data;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);   
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
   
        $data = curl_exec($ch);
        $xml = simplexml_load_string($data);
      //  pr($xml);
        //echo $xml[result][recorddetail][FL][0].'yyyyyyyyyyyyy';
     //   pr($xml->result->recorddetail->FL);
       return  $xml->result->recorddetail->FL;
        exit;
    }
    
    /**
     * Function to add the user to zoho's database 
     */
    function addCitizenToZoho($display_name, $first_name, $last_name, $email_address) {
        //create a customer in zoho's database 
        $data = array('display_name' => $display_name, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email_address);
        $json_encoded_data = json_encode($data);
        $api = 'https://subscriptions.zoho.com/api/v1/customers';
        $hdrarray = array('X-com-zoho-subscriptions-organizationid: '.ORGANIZATIONID.'', 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62');
        $url = $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_encoded_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        $customer = curl_exec($ch);
        curl_close($ch);
        $customer_info = json_decode($customer, true);
        return $customer_id = $customer_info['customer']['customer_id'];
    }
    
    /**
     * Create coupon by subscription id.
     * @param type $display_name
     * @param type $first_name
     * @param type $last_name
     * @param type $email_address
     * @return type
     * Eg. Call to create coupon id
     * $ curl https://subscriptions.zoho.com/api/v1/coupons
-H "Authorization: Zoho-authtoken ba4604e8e433g9c892e360d53463oec5"
-H "X-com-zoho-subscriptions-organizationid: 10234695"
-H "Content-Type: application/json;charset=UTF-8"
-d '{
    "coupon_code": "THANKSGIVING20",
    "name": "Thanksgiving 20 percent offer",
    "description": "Twenty percent offer for thanks giving.",
    "type": "one_time",
    "discount_by": "percentage",
    "discount_value": 20,
    "product_id": "903000000045027",
    "max_redemption": 50,
    "expiry_at": "2016-08-28",
    "apply_to_plans": "select",
    "plans": [
        {
            "plan_code": "basic-monthly"
        }
    ],
    "apply_to_addons": "select",
    "addons": [
        {
            "addon_code": "Email-basic"
        }
    ]
}
     */
    function createCouponBySubIdZoho() {
        $plancode['plan_code']="TE500";
        $object = json_decode(json_encode($plancode), FALSE);
        $plan=json_encode($plancode);
        $data = array(
            "coupon_code"=> "KCGT".  rand(1,100),
    "name"=> "Thanksgiving 20 percent offer",
    "description"=> "Twenty percent offer for thanks giving.",
    "type"=> "one_time",
    "discount_by"=> "percentage",
    "discount_value"=> 10,
    "product_id"=> "135051000000040017",
    "max_redemption"=> 1,
    "expiry_at"=> "2018-08-28",
    "apply_to_plans"=> "select",
    "plans"=> [
        array('plan_code'=>"TE500")
        
    ]
            
    
    );
        
        $json_encoded_data = json_encode($data);
        echo "<pre>";
        pr($json_encoded_data);
        $api = 'https://subscriptions.zoho.com/api/v1/coupons';
        $hdrarray = array('X-com-zoho-subscriptions-organizationid: '.ORGANIZATIONID.'', 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62');
        $url = $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_encoded_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        $customer = curl_exec($ch);
        if (!curl_errno($ch)) {
  $info = curl_getinfo($ch);
  pr($info);
  echo 'Took ', $info['total_time'], ' seconds to send a request to ', $info['url'], "\n";
}
        curl_close($ch);
        $customer_info = json_decode($customer, true);
        return $customer_id = $customer_info['customer']['customer_id'];
    }
    
     function getCouponByIdZoho() {
        
        $api = 'https://subscriptions.zoho.com/api/v1/coupons/KCGT32';
        $hdrarray = array('X-com-zoho-subscriptions-organizationid: '.ORGANIZATIONID.'', 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62');
        $url = $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        $customer = curl_exec($ch);
        pr($customer);
        if (!curl_errno($ch)) {
  $info = curl_getinfo($ch);
  pr($info);
  echo 'Took ', $info['total_time'], ' seconds to send a request to ', $info['url'], "\n";
}
        curl_close($ch);
        $customer_info = json_decode($customer, true);
        return $customer_id = $customer_info['customer']['customer_id'];
    }
}