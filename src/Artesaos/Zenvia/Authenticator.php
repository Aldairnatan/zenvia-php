<?php
namespace Artesaos\Zenvia;

use Artesaos\Zenvia\Contracts\AuthenticatorInterface;

class Authenticator implements AuthenticatorInterface
{
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
     * @return mixed
     */
    public function getAccessCode()
    {
        return base64_encode($this->account.':'.$this->password);
    }
}