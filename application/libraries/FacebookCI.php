<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/Facebook/autoload.php';

class FacebookCI {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function getLoginLink($rerequest = false) {
        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.9',
            'auth_type' => 'rerequest',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_friends'];
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
            $response = $fb->get('/me?fields=first_name,last_name,email,id,gender,name,cover,picture,about,birthday', $accesstoken);
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

    public function getFBCallback($redir) {

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
            $this->CI->redirect("/");
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
//            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            $this->setMessage('Warning', $e->getMessage(), 'danger');
            $this->CI->redirect("/");
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

                if(!empty($_SESSION['fb_access_token'])){
                    $_SESSION['fb_access_token'] = (string) $accessToken;
                }

                
//                var_dump($_GET);
//                var_dump($fb->getOAuth2Client()->getAccessTokenFromCode($_GET['code'], 'http://localhost/websocial/social/facebook', array('email', 'user_friends')));


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
        redirect($redir);
    }

    public function getPermissions() {
        $request = new FacebookRequest(
                $session, 'GET', '/{user-id}/permissions'
        );
        $response = $request->execute();
        $graphObject = $response->getGraphObject();
        return $graphObject;
    }

    public function getAccessTokenFromCode($code) {

        $fb = new \Facebook\Facebook([
            'app_id' => FACEBOOK_APP,
            'app_secret' => FACEBOOK_SECRET,
            'code' => $code,
            'default_graph_version' => 'v2.9',
        ]);
        $accessToken = $fb->getRedirectLoginHelper()->getAccessToken();

//        var_dump($fb->getRedirectLoginHelper()->getAccessToken());
        $_SESSION['fb_access_token'] = (string) $accessToken;
        var_dump($_SESSION);

//        https://graph.facebook.com/v2.10/oauth/access_token?
//   client_id={app-id}
//   &redirect_uri={redirect-uri}
//   &client_secret={app-secret}
//   &code={code-parameter}
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

    protected function setMessage($title, $text, $type) {
        $this->CI->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
