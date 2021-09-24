<?php

namespace App\Http\Repositories;
use App\Exceptions\ErrorException;
use App\Http\Transformers\Responses\ApiResponder;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
abstract class HttpHandler
{
    use ApiResponder;

    /**
     * @var
     */
    protected $client ;
    /**
     * @var
     */
    protected $config;
    /**
     * header for all request
     * @var string[]
     */
    protected $headers = [
        'Content-Type'    => 'application/json',
        'Accept'          => 'application/json'
    ];

    /**
     * Network constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Concatenate network's domain with endpoint.
     *
     * @param $endpoint
     * @return string
     */

    public function buildUrl($endpoint): string
    {
        if(substr($endpoint,0,4) == 'http') {
            return $endpoint;
        }
        return trim($this->config['baseUrl'],'/') . '/' . trim($endpoint, '/');
    }

    /**
     * @param $endpoint
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws ErrorException
     */
    public function call($endpoint, $method = 'GET', $parameters = [])
    {
        $this->validateConfig();
        $params['form_params'] = $parameters;
        $params['headers']['Authorization'] = "Bearer {$this->config['accessToken']}";
        $params['headers']['Accept'] = 'application/json';
        $params['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
        $params['http_errors'] = true;
        try {
            $response = $this->client->request($method, $this->buildUrl($endpoint), $params);
        } catch (GuzzleException $e) {
            throw new ErrorException('exception.invalid_payment_details');
        }
        $body = $response->getBody()->getContents();
        return $this->responseDecoder($body);
    }

    /**
     * This function helps us to decode the response data received through API
     * @param $response
     * @return mixed
     */
    public function responseDecoder($response)
    {
        return json_decode($response,true);
    }

    abstract function validateConfig();
}
