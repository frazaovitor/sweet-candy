<?php

/**
 * Client for working with Instagram API.
 */
class GridGallery_Insta_Client
{

    /** Authorization URL */
    const AUTH_URL = 'https://api.instagram.com/oauth';

    /** Base API URL */
    const API_URL = 'https://api.instagram.com/v1';

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $state;

    /**
     * @var array
     */
    private $user;

    /**
     * @var string
     */

    /**
     * Constructor.
     *
     * @param string $accessToken OAuth2 Access token.
     */
    public function __construct($accessToken = null)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Returns authorization URL.
     *
     * @see http://instagram.com/developer/authentication/
     * @return string Authorization URL.
     * @throws Exception If client id or redirect uri is not specified.
     */
    public function getAuthorizationUrl()
    {
        if (!$this->clientId) {
            throw new Exception('Client ID is not specified.');
        }

        if (!$this->redirectUri) {
            throw new Exception('Redirect URI is not specified.');
        }

        return self::AUTH_URL . '/authorize/?' . http_build_query(
            array(
                'client_id' => $this->getClientId(),
                'redirect_uri' => $this->getRedirectUri(),
                'state' => $this->getState(),
                'response_type' => 'code',
            )
        );
    }

    /**
     * Sends request to generate access token.
     *
     * @param string $code Authorization code.
     * @throws Exception If client secret or redirect uri is not specified.
     * @throws RuntimeException If failed to get access token.
     * @return string
     */
    public function requestAccessToken($code)
    {
        if (!$this->getClientSecret()) {
            throw new Exception('Client secret is not specified.');
        }

        if (!$this->getRedirectUri()) {
            throw new Exception('Redirect URI is not specified.');
        }

        $code = trim($code);

        $response = wp_remote_post(
            self::AUTH_URL . '/access_token',
            array(
                'body' => array(
                    'client_id' => $this->getClientId(),
                    'client_secret' => $this->getClientSecret(),
                    'redirect_uri' => $this->getRedirectUri(),
                    'code' => $code,
                    'grant_type' => 'authorization_code'
                )
            )
        );

        if (is_wp_error($response)) {
            throw new RuntimeException($response->get_error_message());
        }

        if (200 !== $this->getResponseCode($response)) {
            throw new RuntimeException($this->getResponseMessage($response));
        }

        $data = $this->getResponseBody($response);

        if (!isset($data['access_token'])) {
            throw new RuntimeException('Failed to get access token.');
        }

        return $data;
    }

    //added to get images from any user
    public function getUserData()
    {
        if ($this->accessToken && $this->userName) {
            $response = wp_remote_get(
                self::API_URL . "/users/search?q={$this->userName}&access_token={$this->accessToken}"
            );
            $data = $this->getResponseBody($response);
            $this->user = $data;
            $this->userId = $data['data'][0]['id'];
        } else {
            //error mesage
        }
        return false;
    }

    public function getUserThumbnails()
    {
        if (!$this->accessToken && !$this->user) {
            $this->accessToken = get_option('insta_token');
            $this->user = get_option('insta_user');
        }

        return $this->getAllInstagramImages(self::API_URL . "/users/{$this->user['id']}/media/recent/?access_token={$this->accessToken}");
    }

    public function getAllInstagramImages($url) {
        $imagesUrls = array();
        $response = wp_remote_get($url);
        $result = $this->getResponseBody($response);
        foreach ($result['data'] as $post) {
            $imagesUrls[] = $post['images']['standard_resolution']['url'];
        }
        if ($result['pagination']) {
            array_splice($imagesUrls, -1, 0, 
                $this->getAllInstagramImages($result['pagination']['next_url']));
        }
        return $imagesUrls;
    }

    public function getUserImages()
    {
        $user = get_option('insta_user');
        $token = get_option('insta_token');
        $response = wp_remote_get(
            self::API_URL . "/users/{$user['id']}/media/recent/?access_token={$token}"
        );
        $result = $this->getResponseBody($response);
        $imagesUrls = array();
        foreach ($result['data'] as $post) {
            $imagesUrls[] = $post['images'];
        }
        return $imagesUrls;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param array $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getUser()
    {
        return $this->user;
    }

    protected function getResponseCode($response)
    {
        return (int)wp_remote_retrieve_response_code($response);
    }

    protected function getResponseMessage($response)
    {
        return wp_remote_retrieve_response_message($response);
    }

    protected function getResponseBody($response)
    {
        return json_decode(wp_remote_retrieve_body($response), true);
    }
} 