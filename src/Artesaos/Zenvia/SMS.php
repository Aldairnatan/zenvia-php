<?php
namespace Artesaos\Zenvia;

use Artesaos\Zenvia\Contracts\AuthenticatorInterface;
use Artesaos\Zenvia\Contracts\RequestManagerInterface;
use Artesaos\Zenvia\Contracts\ResponseHandlerInterface;
use Artesaos\Zenvia\Contracts\SMSInterface;
use Artesaos\Zenvia\Exceptions\ZenviaContractException;
use Artesaos\Zenvia\Http\RequestManager;
use Artesaos\Zenvia\Http\ResponseHandler;

class SMS implements SMSInterface {


    /**
     * @var RequestManagerInterface
     */
    private $requestManager;
    /**
     * @var AuthenticatorInterface
     */
    private $authenticator;

    /**
     * SMS constructor.
     *
     * @param string $account
     * @param string $password
     */
    public function __construct($account, $password)
    {
        $this->requestManager = new RequestManager();
        $this->authenticator = new Authenticator($account, $password);
    }
    
    /**
     * {@inheritdoc}
     */
    public function send(array $body, $responseFormat = 'array')
    {
        $data['sendSmsRequest'] = $body;
        $response = $this->getRequestManager()
                           ->sendRequest('POST','services/send-sms',$data, $this->authenticator->getAccessCode(),'1.1');

        return ResponseHandler::convert($response,$responseFormat);

    }

    /**
     * @return RequestManagerInterface
     */
    public function getRequestManager()
    {
        return $this->requestManager;
    }

    /**
     * @param RequestManagerInterface $requestManager
     */
    public function setRequestManager(RequestManagerInterface $requestManager)
    {
        $this->requestManager = $requestManager;
    }

    /**
     * @param AuthenticatorInterface $authenticator
     * @return $this
     */
    public function setAuthenticator(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
        return $this;
    }

    /**
     * @return AuthenticatorInterface
     */
    public function getAuthenticator()
    {
       return $this->authenticator;
    }
}