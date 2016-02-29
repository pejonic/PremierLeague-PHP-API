<?php

namespace Vlowe\PremierLeague;

class Transport 
{
    /**
     * Enabled or disable debugging
     */
    const DEBUG = false;

    /**
     * Default user agent
     */
    const USER_AGENT = 'User-Agent: PhpPremierLeague1.0';

    /**
     * HTTP status code success
     */
    const CODE_SUCCESS = 200;
    
    /**
     * cURL default timeout
     */
    const TIMEOUT = 5;
    
    /**
     * HTTP end of line
     */
    const EOL = "\r\n";

    /**
     * Protected cURL instance
     * @var curl protected cURL instance
     */
    protected $_curl;

    /**
     * Protected url
     * @var string protected url of the request
     */
    protected $_url;

    /**
     * Constructor - prepare transportation layer, and init cURL instance
     * @param string $url request
     * @see init()
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Destructor - close cURL instance
     */
    public function __destruct()
    {
        curl_close($this->_curl);
    }

    /**
     * Init cURL extension
     */
    public function init()
    {
        // create cURL instance
        $this->_curl = curl_init();

        // setting cURL's option to return the webpage data
        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, true); 
        
        // setting cURL to follow 'location' HTTP headers
        curl_setopt($this->_curl, CURLOPT_FOLLOWLOCATION, true);

        // automatically set the referer where following 'location' HTTP headers
        curl_setopt($this->_curl, CURLOPT_AUTOREFERER, true);

        // automatically set the referer where following 'location' HTTP headers
        curl_setopt($this->_curl, CURLOPT_USERAGENT, self::USER_AGENT);

        // set curl timeouts
        curl_setopt($this->_curl, CURLOPT_CONNECTTIMEOUT, self::TIMEOUT);
        curl_setopt($this->_curl, CURLOPT_DNS_CACHE_TIMEOUT, self::TIMEOUT);
        curl_setopt($this->_curl, CURLOPT_TIMEOUT, self::TIMEOUT);
    }

    /**
     * Send $request
     * @param string $request body of the request
     * @return string body of the response
     * @throws Exception exception if http status code is not success, or empty body
     */
    public function request($url)
    {
        // create url and prepare empty exception
        $this->_url = $url;
        $exception = false;

        // set url
        curl_setopt($this->_curl, CURLOPT_URL, $this->_url);

        // get result (headers, body), and additional information
        $result = curl_exec($this->_curl);
        $status = curl_getinfo($this->_curl);

        // check http status code
        if ($status['http_code'] <> self::CODE_SUCCESS) {
            $exception = 'Transport::request() failed with http error code: ' . $status['http_code'] . '.';
        }

        // check response content
        if (empty($result)) {
            $exception = 'Transport::request() failed and returned empty body.';
        }

        // if exception message, throw it
        if ($exception) {
            throw new \Exception($exception);
        }

        // return response body
        return $result;
    }

    /**
     * Get cURL instance
     * @return curl
     */
    public function getCurl()
    {
        return $this->_curl;
    }

    /**
     * Set cURL instance
     * @param curl $curl
     */
    public function setCurl($curl)
    {
        $this->_curl = $curl;
    }
}