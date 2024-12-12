<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AkamaiTokenVerifier {
    private $Akamai_token_key;

    public function __construct() {
        $this->Akamai_token_key = AKAMAI_VERIFICATION_KEY;
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

        // First verify the URL is accessible
        $urlCheck = $this->checkUrlAccess($url_with_token);
        if ($urlCheck['status'] === 'error') {
            return $urlCheck;
        }

        // Then verify the video content
        $videoCheck = $this->verifyVideoContent($url_with_token);
        if ($videoCheck['status'] === 'error') {
            return $videoCheck;
        }

        return array(
            'status' => 'success', 
            'message' => 'URL and video content verified successfully',
            'url_with_token' => $url_with_token,
            'video_info' => $videoCheck['video_info']
        );
    }

    private function checkUrlAccess($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($result === false) {
            return array('status' => 'error', 'message' => 'Failed to connect: ' . $error);
        } elseif ($httpCode >= 200 && $httpCode < 300) {
            return array('status' => 'success');
        } else {
            return array('status' => 'error', 'message' => 'Invalid URL. HTTP status code: ' . $httpCode);
        }
    }

    private function verifyVideoContent($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RANGE, '0-2000000'); // Get first 2MB to check headers
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $header) use (&$headers) {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
                return $len;

            $headers[strtolower(trim($header[0]))][] = trim($header[1]);
            return $len;
        });

        $data = curl_exec($ch);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check content type
        if (!preg_match('/video|application\/x-mpegURL|application\/vnd\.apple\.mpegURL/i', $contentType)) {
            return array(
                'status' => 'error', 
                'message' => 'Invalid content type. Expected video content, got: ' . $contentType
            );
        }

        // Check file size
        if ($fileSize !== -1 && $fileSize < 1024) { // If size is known and less than 1KB
            return array(
                'status' => 'error',
                'message' => 'Video file appears to be empty or too small'
            );
        }

        // Basic video format validation
        $isValid = false;
        $videoInfo = array(
            'content_type' => $contentType,
            'file_size' => $fileSize,
            'format' => 'unknown'
        );

        // Check for common video signatures
        $signatures = array(
            'mp4' => array('66747970', '667479706D703432'), // MP4 signatures
            'ts' => array('47400010'), // MPEG-TS signature
            'm3u8' => array('2345585453', '234558545350') // HLS playlist signatures
        );

        $hexData = bin2hex(substr($data, 0, 1000));
        foreach ($signatures as $format => $sigs) {
            foreach ($sigs as $sig) {
                if (stripos($hexData, $sig) !== false) {
                    $isValid = true;
                    $videoInfo['format'] = $format;
                    break 2;
                }
            }
        }

        // For M3U8 playlists, check content
        if (preg_match('/application\/x-mpegURL|application\/vnd\.apple\.mpegURL/i', $contentType)) {
            if (preg_match('/#EXTM3U/i', $data)) {
                $isValid = true;
                $videoInfo['format'] = 'm3u8';
            }
        }

        if (!$isValid) {
            return array(
                'status' => 'error',
                'message' => 'Could not verify video content format'
            );
        }

        return array(
            'status' => 'success',
            'video_info' => $videoInfo
        );
    }

    // Existing token generation methods remain the same
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