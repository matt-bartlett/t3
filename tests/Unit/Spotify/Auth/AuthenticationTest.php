<?php

namespace Tests\Unit\Spotify\Auth;

use stdClass;
use Tests\TestCase;
use GuzzleHttp\Client;
use App\T3\Spotify\Http\Request;
use App\T3\Spotify\Http\Response;
use App\T3\Spotify\Auth\Authenticator;
use Illuminate\Session\SessionManager;

class AuthenticationTest extends TestCase
{

    public $requestMock;
    public $sessionMock;
    public $responseMock;
    public $guzzleClientMock;
    public $clientId = 'bLXHYJKtHgkrW5bQ8pGet4LD';
    public $clientSecret = 'hL3cpZzRBaEuHeXFUfn3924rNfxPcg3V4RjYV';

    /**
     * @return void
     */
    public function setUp() : void
    {
        // Response Mock
        $this->responseMock = $this->createMock(Response::class);

        // Guzzle Client Mock
        $this->guzzleClientMock = $this->createMock(Client::class);

        // Request Mock
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->setConstructorArgs(array(
                $this->responseMock,
                $this->guzzleClientMock
            ))
            ->setMethods(array('send'))
            ->getMock();

        // Session Manager Mock
        $this->sessionMock = $this->getMockBuilder(SessionManager::class)
            ->disableOriginalConstructor()
            ->setMethods(array('driver', 'get', 'put'))
            ->getMock();

        // Set the session driver to file for the purpose of the tests
        $this->sessionMock->expects($this->any())
            ->method('driver')
            ->willReturn('file');

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_client_id_getter_setter()
    {
        // Instantiate Auth class
        $auth = new Authenticator($this->requestMock, $this->sessionMock);
        $auth->setClientId($this->clientId);

        $this->assertEquals($this->clientId, $auth->getClientId());
    }

    /**
     * @return void
     */
    public function test_client_secret_getter_setter()
    {
        // Instantiate Auth class
        $auth = new Authenticator($this->requestMock, $this->sessionMock);
        $auth->setClientSecret($this->clientSecret);

        $this->assertEquals($this->clientSecret, $auth->getClientSecret());
    }

    /**
     * @return void
     */
    public function test_retrieving_access_token_after_authentication()
    {
        $authenticationResponse = $this->authenticationResponse();

        $this->requestMock->expects($this->once())
            ->method('send')
            ->willReturn($authenticationResponse);

        $this->sessionMock->expects($this->exactly(2))
            ->method('get')
            ->will($this->onConsecutiveCalls(false, false));

        // Instantiate Auth class
        $auth = new Authenticator($this->requestMock, $this->sessionMock);

        $this->assertEquals('nui24BhaUI4anHA', $auth->getAccessToken());
    }

    /**
     * @return void
     */
    public function test_retrieving_access_token_from_session()
    {
        $this->sessionMock->expects($this->exactly(3))
            ->method('get')
            ->will($this->onConsecutiveCalls(
                time() + 3600,
                'nui24BhaUI4anHA',
                'nui24BhaUI4anHA'
            ));

        // Instantiate Auth class
        $auth = new Authenticator($this->requestMock, $this->sessionMock);

        $this->assertEquals('nui24BhaUI4anHA', $auth->getAccessToken());
    }

    /**
     * @return void
     */
    public function test_retrieving_expired_access_token()
    {
        $authenticationResponse = $this->authenticationResponse();

        $this->requestMock->expects($this->once())
            ->method('send')
            ->willReturn($authenticationResponse);

        $this->sessionMock->expects($this->exactly(2))
            ->method('get')
            ->will($this->onConsecutiveCalls((time() - 3600), 'SomeRandomToken'));

        // Instantiate Auth class
        $auth = new Authenticator($this->requestMock, $this->sessionMock);

        $this->assertEquals('nui24BhaUI4anHA', $auth->getAccessToken());
    }

    /**
     * Return an object containing authentication data
     *
     * @return stdClass
     */
    private function authenticationResponse()
    {
        $authenticationResponse = new stdClass;
        $authenticationResponse->expires_in = 3600;
        $authenticationResponse->access_token = 'nui24BhaUI4anHA';

        return $authenticationResponse;
    }
}
