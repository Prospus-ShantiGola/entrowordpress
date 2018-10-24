<?php

/**
 * --- LinkedIn Component ---
 * Github: https://github.com/inlet/CakePHP-LinkedIn
 * Makes using the LinkedIn API easier
 * Written on top of OAuth vendor component (http://code.42dh.com/oauth/)
 *
 * @author Patrick Brouwer <patrick@inlet.nl>
 */
App::import('Vendor', 'Linkedin.OAuth', array(
    'file' => 'OAuth' . DS . 'OAuthClient.php'
        )
);

class LinkedinComponent extends Component {

    // PATH DECLARATIONS
    private $authPath = 'https://www.linkedin.com/';
    private $apiPath = 'http://api.linkedin.com/v1/';
    private $requestToken = 'uas/oauth/requestToken';
    private $accessToken = 'uas/oauth/accessToken';
    private $authorizeToken = 'uas/oauth/authorize?oauth_token=';
    //
    private $sessionRequest = 'linkedin_request_token';
    private $sessionAccess = 'linkedin_access_token';
    //
    private $key;
    private $secret;
    private $controller;
    private $scope = 'r_emailaddress';
    var $components = array('Session');

    /**
     * construct plugin with supplied key and secret
     *
     * @param $controller
     * @param array $settings
     */
    public function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
        $this->key = $settings['key'];
        $this->secret = $settings['secret'];
    }

    /**
     * Initialize plugin with supplied key and secret
     *
     * @param $controller
     * @param array $settings
     */
    function initialize(Controller $Controller) {
        $this->controller = $Controller;
    }

    /**
     * Connect api and waiting for request..
     *
     * @param $redirectUrl (optionally) if not set the default callback 'linkedin_authorize' will be triggered
     */
    public function connect($redirectUrl = null) {
        
        if (!isset($redirectUrl)) {
            $redirectUrl = array('controller' => strtolower($this->controller->name), 'action' => 'linkedin_connect_callback');
        }

        $consumer = $this->_createConsumer();
   
        $requestToken = $consumer->getRequestToken($this->authPath . $this->requestToken, Router::url($redirectUrl, true), 'POST', array('scope' => $this->scope));
      
    
      
        $this->Session->write($this->sessionRequest, $requestToken);
        

        $this->controller->redirect($this->authPath . $this->authorizeToken . $requestToken->key);
       
    
 
        
    }

    /**
     * Do authorization..
     *
     * @param null $redirectUrl (optionally) if not set the default callback 'linkedin_connected' will be triggered
     */
    public function authorize($redirectUrl = null) {
        if (!isset($redirectUrl)) {
            $redirectUrl = array('controller' => strtolower($this->controller->name), 'action' => 'linkedin_authorize_callback');
        }

        $requestToken = $this->Session->read($this->sessionRequest);
        $consumer = $this->_createConsumer();
        $accessToken = $consumer->getAccessToken($this->authPath . $this->accessToken, $requestToken);

        $this->Session->write($this->sessionAccess, $accessToken);
        $this->controller->redirect($redirectUrl);
    }

    /**
     * API call to GET linkedin data.
     *
     * @param $path
     * @param $args
     * @return response
     */
    public function call($path, $args=null, $params=null) {
        $accessToken = $this->Session->read($this->sessionAccess);
        if ($accessToken === null) {
            trigger_error('Linkedin: accesToken is empty', E_USER_NOTICE);
        }
        $path .= $this->_fieldSelectors($args);
        $path .= $this->_generateParams($params);
        $consumer = $this->_createConsumer();
        $result = $consumer->get($accessToken->key, $accessToken->secret, $this->apiPath . $path);
        $response1 = simplexml_load_string($result);
        //$responseHeaders = $consumer->getResponseHeader();
        $response = $this->_decode($response1);
        if (isset($response['error'])) {
            throw new Exception('Linkedin: ' . $response['error']['message']);
        }
        return $response;
    }

    /**
     * API call to POST data
     *
     * @param $path
     * @param $data  array/object for json or an string for xml/json
     * @param string $type  "json" or "xml"
     * @return array|null response
     */
    public function send($path, $data, $type = 'json') {
        switch ($type) {

            case 'json':
                $contentType = 'application/json';
                if (!is_string($data)) {
                    $data = json_encode($data);
                }
                break;

            case 'xml':
                $contentType = 'text/xml';
                break;

            default:
                throw new Exception('Type: "' . $type . '" not supported');
        }
        $accessToken = $this->Session->read($this->sessionAccess);
        $consumer = $this->_createConsumer();
        $responseText = $consumer->post($accessToken->key, $accessToken->secret, $this->apiPath . $path, $data, $contentType);
        $response = $this->_decode($responseText);
        if (isset($response['error'])) {
            throw new Exception('Linkedin: ' . $response['error']['message']);
        }
        return $response;
    }

    /**
     * Check if is connected with linkedin
     *
     * @return bool
     */
    public function isConnected() {
        $accessToken = $this->Session->read($this->sessionAccess);
        return ($accessToken && is_object($accessToken));
    }

    /**
     * Create a valid consumer which provides an API
     *
     * @return OAuth_Consumer
     */
    private function _createConsumer() {
        return new OAuthClient($this->key, $this->secret);
    }

    /**
     * Decodes the response based on the content type
     *
     * @param string $response
     * @return void
     * @author Dean Sofer
     */
    private function _decode($response, $contentType = 'application/xml') {
        // Extract content type from content type header
        if (preg_match('/^([a-z0-9\/\+]+);\s*charset=([a-z0-9\-]+)/i', $contentType, $matches)) {
            $contentType = $matches[1];
            $charset = $matches[2];
        }

        // Decode response according to content type
        switch ($contentType) {
            case 'application/xml':
            case 'application/atom+xml':
            case 'application/rss+xml':
                App::uses('Xml', 'Utility');
                $Xml = new Xml($response);
                $response = $Xml->toArray($response); // Send false to get separate elements
                //$Xml->__destruct();
                $Xml = null;
                unset($Xml);
                //  $response = $this->xml_to_array($response);
                break;
            case 'application/json':
            case 'text/javascript':
                $response = json_decode($response, true);
                break;
        }
        return $response;
    }

    /**
     * Formats an array of fields into the url-friendly nested format
     *
     * @param array $fields
     * @return string $fields
     * @link http://developer.linkedin.com/docs/DOC-1014
     */
    private function _fieldSelectors($fields = array()) {
        $result = '';
        if (!empty($fields)) {
            if (is_array($fields)) {
                foreach ($fields as $group => $field) {
                    if (is_string($group)) {
                        $fields[$group] = $group . $this->_fieldSelectors($field);
                    }
                }
                $fields = implode(',', $fields);
            }
            $result .= ':(' . $fields . ')';
        }
        return $result;
    }

    //change response to xml
    public static function xml_to_array($xml) {
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        if (!xml_parse_into_struct($parser, $xml, $tags)) {
            throw new LinkedInException('Could not parse the passed XML.');
        }
        xml_parser_free($parser);

        $elements = array();
        $stack = array();
        foreach ($tags as $tag) {
            $index = count($elements);
            if ($tag['type'] == 'complete' || $tag['type'] == 'open') {
                $elements[$tag['tag']] = array();
                $elements[$tag['tag']]['attributes'] = (array_key_exists('attributes', $tag)) ? $tag['attributes'] : NULL;
                $elements[$tag['tag']]['content'] = (array_key_exists('value', $tag)) ? $tag['value'] : NULL;
                if ($tag['type'] == 'open') {
                    $elements[$tag['tag']]['children'] = array();
                    $stack[count($stack)] = &$elements;
                    $elements = &$elements[$tag['tag']]['children'];
                }
            }
            if ($tag['type'] == 'close') {
                $elements = &$stack[count($stack) - 1];
                unset($stack[count($stack) - 1]);
            }
        }
        return $elements;
    }

    private function _generateParams($params = array()) {
        $result = '?';
        $fields = '';
        $get = array();

        if (!empty($params)) {
            if (is_array($params)) {
                foreach ($params as $name => $value) {
                    $get[] = "$name=$value";
                }
                $fields = implode('&', $get);
            }
        }
        $result .= $fields;
        return $result;
    }

    public function getCompanySearchResult($searchTerm, $start) {
        return $this->call(
            'company-search', 
            array(
                'companies' => array(
                    'id',
                    'website-url',
                    'locations:(address)',
                )
            ), 
            array(
                'keywords' => $searchTerm,
                'count' => 20,
                'start' => $start
            )
        );
    }
    
    public function getToken() {
        return $this->sessionAccess;
    }

}
