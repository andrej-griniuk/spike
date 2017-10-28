<?php

namespace App\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * An authentication adapter for AuthComponent. Provides the ability to authenticate using POST
 * data. Can be used by configuring AuthComponent to use it via the AuthComponent::$authenticate config.

 * @see \Cake\Controller\Component\AuthComponent::$authenticate
 */
class ApiAuthenticate extends BaseAuthenticate
{

    /**
     * Checks the fields to ensure they are supplied.
     *
     * @param \Cake\Http\ServerRequest $request The request that contains login information.
     * @param array $fields The fields to be checked.
     * @return bool False if the fields have not been supplied. True if they exist.
     */
    protected function _checkFields(ServerRequest $request, array $fields)
    {
        foreach ([$fields['username'], $fields['password']] as $field) {
            $value = $request->getData($field);
            if (empty($value) || !is_string($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Authenticates the identity contained in a request. Will use the `config.userModel`, and `config.fields`
     * to find POST data that is used to find a matching record in the `config.userModel`. Will return false if
     * there is no post data, either username or password is missing, or if the scope conditions have not been met.
     *
     * @param \Cake\Http\ServerRequest $request The request that contains login information.
     * @param \Cake\Http\Response $response Unused response object.
     * @return mixed False on login failure. An array of User data on success.
     */
    public function authenticate(ServerRequest $request, Response $response)
    {
        $fields = $this->_config['fields'];
        if (!$this->_checkFields($request, $fields)) {
            return false;
        }

        $username = $request->getData($fields['username']);
        $password = $request->getData($fields['password']);

        $http = new Client();
        $response = $http->post(Configure::read('Api.url') . 'auth?v=1', json_encode([
            'loginRequest' => [
                'brand' => 'nab',
                'lob' => 'nab',
                'credentials' => [
                    'apiStructType' => 'usernamePassword',
                    'usernamePassword' => compact('username', 'password'),
                ]
            ]
        ]), [
            'type' => 'json',
            'headers' => [
                'x-nab-key' => Configure::read('Api.key'),
            ]
        ]);

        if (!Hash::get($response->json, 'status.message') == 'Success') {
            return false;
        }

        $loginResponse = Hash::get($response->json, 'loginResponse');

        $response = $http->get(Configure::read('Api.url') . 'customer/profile?v=1', [], [
                'type' => 'json',
                'headers' => [
                    'x-nab-key' => Configure::read('Api.key'),
                    'Authorization' => Hash::get($loginResponse, 'tokens.0.value')
                ]
            ]
        );

        $data = Hash::get($response->json, 'customerDetailsResponse');

        $Users = TableRegistry::get($this->getConfig('userModel'));
        /** @var \App\Model\Entity\User $user */
        $user = $Users->findOrCreate([$this->getConfig('fields.username') => $username]);
        $user->first_name = (string)Hash::get($data, 'person.firstName');
        $user->last_name = (string)Hash::get($data, 'person.lastName');
        $user->email = (string)Hash::get($data, 'email.id');
        $Users->saveOrFail($user);
        $user = $user->toArray();

        /*
        $user = [
            'first_name' => (string)Hash::get($data, 'person.firstName'),
            'last_name' => (string)Hash::get($data, 'person.lastName'),
            'full_name' => Hash::get($data, 'person.firstName') . ' ' . Hash::get($data, 'person.lastName'),
            'email' => (string)Hash::get($data, 'email.id'),
        ];*/

        $user['tokens'] = Hash::get($loginResponse, 'tokens');

        return $user;
    }
}
