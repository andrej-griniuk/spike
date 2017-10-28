<?php
namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow('login');
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|void
     */
    public function login()
    {
        if ($this->request->is('post')) {
            if ($user = $this->Auth->identify()) {
                $this->Auth->setUser($user);

                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__d('users', 'Invalid username or password, try again'));
            }
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Profile method
     *
     * @return \Cake\Http\Response
     */
    public function profile()
    {
        $data = $this->Api->get('customer/profile');
    }

}
