<?php
namespace Artesaos\Zenvia;

use Artesaos\Zenvia\Contracts\AuthenticatorInterface;

class Authenticator implements AuthenticatorInterface
{
    /**
     * @var string contains base64 access code
     * */
    protected $access_code;


    /**
     * @var string contains account name
     * */
    private $account;

    /**
     * @var string contains password
     * */
    private $password;

    /**
     * Authenticator constructor.
     * @param $account
     * @param $password
     */
    public function __construct($account= null, $password = null)
    {
        $this->setAccount($account);
        $this->setPassword($password);
        $this->setAccessCode();
    }


    /**
     * @param $account
     * @return $this
     */
    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     * @internal param $password
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * @return $this
     * @internal param $password
     * @internal param $access_code
     */
    public function setAccessCode()
    {
        $this->access_code = base64_encode($this->getAccount().':'.$this->getPassword());
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccessCode()
    {
        return $this->access_code;
    }
}