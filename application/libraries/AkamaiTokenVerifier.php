<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AkamaiTokenVerifier {
    private $Akamai_token_key;

    public function __construct() {
        // Load the CI instance
        //$CI =& get_instance();
        
        // Load the settings model if not already loaded
        //$CI->load->model('settings_m');
        
        // Get the Akamai Token Secret from the database
        //$this->Akamai_token_key = $CI->settings_m->get_by(array('key' => 'Akamai_Token_Secret'))->value;
        
        // If the key is not set in the database, use a default value (not recommended for production)
        //if (!$this->Akamai_token_key) {
            $this->Akamai_token_key = AKAMAI_VERIFICATION_KEY; // Default value, replace with your actual key
        //}
    }

    public function verifyUrl($url) {

        // Check if URL is empty
        if (empty($url)) {
            return array('status' => 'error', 'message' => 'URL cannot be empty');
        }

        // Generate a token
        $token = $this->generateToken(strtotime('+1 day'));

        // Append the token to the URL
        $url_with_token = $url . (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . 'hdnts=' . $token;

        // Initialize cURL
        $ch = curl_init($url_with_token);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout of 10 seconds

        // Execute the request
        $result = curl_exec($ch);

        // Check for errors and get the HTTP status code
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close the cURL handle
        curl_close($ch);

        if ($result === false) {
            return array('status' => 'error', 'message' => 'Failed to connect: ' . $error);
        } elseif ($httpCode >= 200 && $httpCode < 300) {
            return array('status' => 'success', 'message' => 'URL verified successfully', 'url_with_token' => $url_with_token);
        } else {
            return array('status' => 'error', 'message' => 'Invalid URL. HTTP status code: ' . $httpCode);
        }
    }

    private function generateToken($expire) {
        $m_token = 'st=' . time() . '~';
        $m_token .= 'exp=' . $expire . '~';
        $m_token .= 'acl=*~';
        $m_token .= 'data=WEBIMS~';

        $signature = hash_hmac('sha256', rtrim($m_token, "~"), $this->h2b($this->Akamai_token_key));
        return $m_token . 'hmac=' . $signature;
    }

    private function h2b($str) {
        $bin = "";
        $i = 0;
        do {
            $bin .= chr(hexdec($str[$i].$str[($i + 1)]));
            $i += 2;
        } while ($i < strlen($str));
        return $bin;
    }
}