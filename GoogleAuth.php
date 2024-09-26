<?php

class GoogleAuth {

    private $config;

    public function __construct() {
        $filePath = 'OAuth 2.0 Client IDs.json'; // Path to your JSON file

        if (!file_exists($filePath)) {
            throw new Exception("Configuration file not found: " . $filePath);
        }

        $jsonString = file_get_contents($filePath);
        $this->config = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Error decoding JSON configuration file: " . json_last_error_msg());
        }

        //Verify necessary keys exist
        $requiredKeys = ['web' => ['client_id', 'client_secret', 'redirect_uris']];
        $this->validateConfig($requiredKeys);


    }


    private function validateConfig($requiredKeys) {
        foreach($requiredKeys as $section => $keys){
            if(!isset($this->config[$section])){
                throw new Exception("Missing section: $section in config");
            }
            foreach($keys as $key){
                if(!isset($this->config[$section][$key])){
                    throw new Exception("Missing Key: $key in section: $section");
                }
            }
        }
    }

    public function getGoogleAuthUrl() {
        return GOOGLE_AUTH_URL . '?response_type=code&client_id=' . $this->config['web']['client_id'] . '&redirect_uri=' . urlencode($this->config['web']['redirect_uris'][0]) . '&scope=' . urlencode(implode(' ', $GLOBALS['GOOGLE_SCOPES']));
    }

    public function exchangeCodeForToken($code) {
        $data = [
            'code' => $code,
            'client_id' => $this->config['web']['client_id'],
            'client_secret' => $this->config['web']['client_secret'],
            'redirect_uri' => $this->config['web']['redirect_uris'][0],
            'grant_type' => 'authorization_code'
        ];
        $response = $this->post_request(GOOGLE_TOKEN_URL, $data);
        if ($response === false) {
            return ['error' => 'cURL error'];
        }
        $responseData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'JSON decoding error'];
        }
        return $responseData;
    }

    public function getGoogleUserInfo($token) {
        $response = $this->get_request(GOOGLE_USERINFO_URL . '?access_token=' . $token);
        if ($response === false) {
            return ['error' => 'cURL error'];
        }
        $responseData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'JSON decoding error'];
        }
        return $responseData;
    }


    // ... (get_request and post_request methods remain the same as before)
}

// Define GOOGLE_SCOPES globally.
$GOOGLE_SCOPES = [
    'https://www.googleapis.com/auth/userinfo.profile',
    'https://www.googleapis.com/auth/userinfo.email'
];


// Example of creating an instance (Outside any other classes, typically in a file where it is to be used.)
try{
    $googleAuth = new GoogleAuth();
    // Use $googleAuth->getGoogleAuthUrl(), etc.
} catch (Exception $e){
    echo "Error creating GoogleAuth instance: " . $e->getMessage();
    exit;
}

?>