<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Hash;

/**
 * Api component
 */
class ApiComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * HTTP client
     *
     * @var \Cake\Http\Client
     */
    public $http;

    /**
     * Constructor hook method.
     *
     * @param array $config The configuration settings provided to this component.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->http = new Client();
    }

    public function get($url, $data = [], array $options = [])
    {
        return $this->execute('get', $url, $data, $options);
    }

    public function post($url, $data = [], array $options = [])
    {
        return $this->execute('post', $url, $data, $options);
    }

    public function put($url, $data = [], array $options = [])
    {
        return $this->execute('put', $url, $data, $options);
    }

    public function delete($url, $data = [], array $options = [])
    {
        return $this->execute('delete', $url, $data, $options);
    }

    public function execute($method, $url, $data = [], array $options = [])
    {
        $url = $this->_getUrl($url);
        $options += $this->_getDefaultOptions();

        $response = $this->http->{$method}($url, $data, $options);

        if (strtolower(Hash::get($response->json, 'status.message')) != 'success') {
            $this->getController()->redirect($this->getController()->Auth->logout());

            return [];
        }

        return $response->json;
    }

    protected function _getUrl($url)
    {
        return Configure::read('Api.url') . $url . '?v=1';
    }

    protected function _getDefaultOptions()
    {
        return [
            'type' => 'json',
            'headers' => $this->_getAuthHeaders()
        ];
    }

    protected function _getAuthHeaders()
    {
        return [
            'x-nab-key' => Configure::read('Api.key'),
            'Authorization' => $this->getController()->Auth->user('tokens.0.value'),
        ];
    }
}
