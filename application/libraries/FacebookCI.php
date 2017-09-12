<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/Facebook/autoload.php';

class FacebookCI
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function getLoginLink()
    {
        $callbackurl = '';
        if (ENVIRONMENT === 'development') {
            $callbackurl = 'http://localhost/websocial/social/facebook';
        } else {
            $callbackurl = 'http://websocial.theshiftleft.com/social/facebook';
        }

        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_posts', 'user_status', 'publish_actions'];

        $loginUrl = $helper->getLoginUrl($callbackurl, $permissions);
        return htmlspecialchars($loginUrl);
    }

    public function getReAuthLink()
    {
        $callbackurl = '';
        if (ENVIRONMENT === 'development') {
            $callbackurl = 'http://localhost/websocial/social/facebook';
        } else {
            $callbackurl = 'http://websocial.theshiftleft.com/social/facebook';
        }

        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_posts', 'user_status', 'publish_actions'];

        $loginUrl = $helper->getReRequestUrl($callbackurl, $permissions);
        return htmlspecialchars($loginUrl);
    }

    public function getFacebookProfile($accesstoken, $id = 'NONE')
    {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);

        try {
            //first_name,last_name,email,id,gender,name,cover,picture,about,birthday

            $response = $fb->get('/' . ($id === 'NONE' ? 'me' : $id) . '?fields=first_name,last_name,email,id,gender,name,cover,picture', $accesstoken);
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

    public function getFBCallback()
    {

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


        $_SESSION['fb_access_token'] = (string)$accessToken;
    }

    public function createPost($msg, $id, $accesstoken)
    {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);
        $linkData = [
            'message' => $msg,
        ];

        try {
            $response = $fb->post('/' . $id . '/feed', $linkData, $accesstoken);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $graphNode = $response->getGraphNode();

        return $graphNode;
    }

    public function createImagePost($msg, $photofile, $fbid, $accesstoken)
    {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);
        $linkData = [
            'message' => $msg,
            'source' => $fb->fileToUpload($photofile),
        ];

        try {
            $response = $fb->post('/' . $fbid . '/photos', $linkData, $accesstoken);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $graphNode = $response->getGraphNode();

        return $graphNode;
    }

    public function getLogoutLink($accesstoken = null)
    {
        $callbackurl = '';
        if (ENVIRONMENT === 'development') {
            $callbackurl = 'http://localhost/websocial/social/facebook';
        } else {
            $callbackurl = 'http://websocial.theshiftleft.com/social/facebook';
        }
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_posts', 'user_status', 'publish_actions'];

        $logouturl = $helper->getLogoutUrl($accesstoken, $callbackurl);
        return htmlspecialchars($logouturl);
    }

    public function revokeFB($accesstoken = null)
    {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);
        $fb->setDefaultAccessToken($accesstoken == null ? $_SESSION['fb_access_token'] : $accesstoken);
        $fb->delete('me/permissions');
    }

    public function getDebugToken($accesstoken)
    {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
        ]);
        $oAuth2Client = $fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accesstoken);
        return $tokenMetadata;
    }

    protected function setMessage($title, $text, $type)
    {
        $this->CI->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
