<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * Accounts Controller
 *
 */
class AccountsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $accounts = Hash::get($this->Api->get('accounts'), 'accountsResponse.accounts', []);

        $this->set(compact('accounts'));
        $this->set('_serialize', ['accounts']);
    }

    /**
     * View method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $account = $this->Accounts->get($id, [
            'contain' => []
        ]);

        $this->set('account', $account);
        $this->set('_serialize', ['account']);
    }
}
