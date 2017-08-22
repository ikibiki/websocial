<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/Facebook/autoload.php';

class FacebookCI {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function getLoginLink() {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_posts', 'user_status', 'publish_actions'];
        $loginUrl = $helper->getLoginUrl('http://localhost/websocial/social/facebook', $permissions);
        return htmlspecialchars($loginUrl);
    }

    public function getFacebookProfile($accesstoken) {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);

        try {
            //first_name,last_name,email,id,gender,name,cover,picture,about,birthday
            $response = $fb->get('/me?fields=first_name,last_name,email,id,gender,name,cover,picture', $accesstoken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $me = $response->getGraphUser();
        return $me->all();
    }

    public function getFBCallback() {

        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
//            echo 'Graph returned an error: ' . $e->getMessage();
            $this->setMessage('Warning', $e->getMessage(), 'danger');
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
//            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            $this->setMessage('Warning', $e->getMessage(), 'danger');
            exit;
        }
        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $oAuth2Client = $fb->getOAuth2Client();

        if (!$accessToken->isLongLived()) {
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }
            echo '<h3>Long-lived</h3>';
        }


        $_SESSION['fb_access_token'] = (string) $accessToken;
    }

    public function createPost($msg, $accesstoken) {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);
        $linkData = [
            'message' => $msg,
        ];

        try {
            $response = $fb->post('/me/feed', $linkData, $accesstoken);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $graphNode = $response->getGraphNode();

        echo 'Posted with id: ' . $graphNode['id'];
    }

    public function revokeFB() {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);
        $fb->setDefaultAccessToken($_SESSION['fb_access_token']);
        $fb->delete('me/permissions');
    }

    public function getDebugToken($accesstoken) {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);
        $oAuth2Client = $fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        return $tokenMetadata;
    }

    protected function setMessage($title, $text, $type) {
        $this->CI->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
