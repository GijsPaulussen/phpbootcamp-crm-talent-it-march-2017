<?php

namespace Auth\Service;


use Application\Module;
use Auth\Entity\MemberInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService;

class LinkedIn
{
    const LINKEDIN_AUTH_URL = 'https://www.linkedin.com/oauth/v2/authorization';
    const LINKEDIN_ACCESS_URL = 'https://www.linkedin.com/oauth/v2/accessToken';
    const LINKEDIN_BASE_URL = 'https://api.linkedin.com/v1';

    /**
     * @var Client
     */
    protected $guzzleClient;

    /**
     * @var MemberInterface
     */
    protected $memberEntity;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var AdapterInterface
     */
    protected $authAdapter;

    /**
     * LinkedIn constructor.
     *
     * @param Client $guzzleClient
     * @param MemberInterface $member
     * @param AdapterInterface $authAdapter
     * @param array $config
     */
    public function __construct(
        Client $guzzleClient,
        MemberInterface $member,
        AdapterInterface $authAdapter,
        $config
    )
    {
        $this->guzzleClient = $guzzleClient;
        $this->memberEntity = $member;
        $this->authAdapter = $authAdapter;
        $this->config = $config;
    }

    /**
     * @inheritdoc
     */
    public function authenticateMember(AuthenticationService $authService, MemberInterface $member)
    {
        $this->authAdapter->setMember($member);

        $authService->setAdapter($this->authAdapter);

        return $authService->authenticate();
    }
    /**
     * Create a unique authorization url
     *
     * @param string $csrf
     * @return string
     */
    public function getAuthenticationUrl($csrf)
    {
        $url = sprintf('%s?%s', self::LINKEDIN_AUTH_URL, implode('&', [
            'response_type=' . 'code',
            'client_id=' . $this->config['client_key'],
            'redirect_uri=' . urlencode($this->config['callback_uri']),
            'state=' . $csrf,
            'scope=' . urlencode('r_basicprofile r_emailaddress rw_company_admin w_share')
        ]));
        return $url;
    }

    public function requestAccessCode($code)
    {
        try {
            $response = $this->guzzleClient->request('POST', self::LINKEDIN_ACCESS_URL, [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $this->config['callback_uri'],
                    'client_id' => $this->config['client_key'],
                    'client_secret' => $this->config['client_key_secret'],
                ],
                'verify' => false,
            ]);
        } catch (ClientException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException('Something went wrong');
        }
        $result = $response->getBody();

        return \GuzzleHttp\json_decode($result, true);
    }

    /**
     * Retrieve the basic profile details from the logged-in user
     *
     * @param string $accessToken
     * @param string $format
     * @return array
     */
    public function getBasicProfileDetails($accessToken, $format = 'json')
    {
        try {
            $response = $this->guzzleClient->request('GET', self::LINKEDIN_BASE_URL . '/people/~', [
                'query' => [
                    'oauth2_access_token' => $accessToken,
                    'format' => $format,
                ],
                'verify' => false
            ]);
        } catch (ClientException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException('Something went wrong');
        }
        $result = $response->getBody();

        return \GuzzleHttp\json_decode($result, true);
    }

    /**
     * Retrieve the additional profile details from the logged-in user
     *
     * @param string $accessToken
     * @param array $options
     * @param string $format
     * @return array
     */
    public function getAdditionalProfileDetails($accessToken, $options = [], $format = 'json')
    {
        if ([] === $options) {
            $options = [
                'id',
                'first-name',
                'last-name',
                'headline',
                'num-connections',
                'main-address',
                'email-address',
                'picture-url',
                'location',
            ];
        }
        try {
            $response = $this->guzzleClient->request('GET', self::LINKEDIN_BASE_URL . '/people/~:(' . implode(',', $options) . ')', [
                'query' => [
                    'oauth2_access_token' => $accessToken,
                    'format' => $format,
                ],
                'verify' => false
            ]);
        } catch (ClientException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException('Something went wrong');
        }
        $result = $response->getBody();

        return \GuzzleHttp\json_decode($result, true);
    }

    /**
     * Retrieve the company details from the logged-in user
     *
     * @param string $accessToken
     * @param string $format
     * @return array
     */
    public function getCompanyDetails($accessToken, $format = 'json')
    {
        try {
            $response = $this->guzzleClient->request('GET', self::LINKEDIN_BASE_URL . '/companies/~', [
                'query' => [
                    'oauth2_access_token' => $accessToken,
                    'format' => $format,
                ],
                'verify' => false
            ]);
        } catch (ClientException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException('Something went wrong');
        }
        $result = $response->getBody();

        return \GuzzleHttp\json_decode($result, true);
    }
}