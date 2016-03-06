<?php
namespace Artesaos\Zenvia\Tests;

class AuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    private $account = 'test';
    private $password = 'password';

    private $authenticator;

    public function setUp()
    {
        $this->authenticator = new \Artesaos\Zenvia\Authenticator($this->account, $this->password);
    }

    public function test_constructor_and_getters_setters()
    {
        $this->assertEquals($this->account, $this->authenticator->getAccount());
        $this->assertEquals($this->password, $this->authenticator->getPassword());
    }

    public function test_if_access_code_is_valid()
    {
        $this->assertEquals(base64_encode($this->account.':'.$this->password), $this->authenticator->getAccessCode());
    }

    public function test_if_can_change_credentials_on_runtime(){
        $newName = 'test_test';
        $newPassword = 'password_password';

        $this->authenticator->setPassword($newPassword);
        $this->authenticator->setAccount($newName);

        $this->assertEquals(base64_encode($newName.':'.$newPassword), $this->authenticator->getAccessCode());
    }
}