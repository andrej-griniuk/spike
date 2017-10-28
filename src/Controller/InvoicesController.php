<?php
namespace App\Controller;

use App\Model\Entity\Invoice;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Hash;

/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 *
 * @method \App\Model\Entity\Invoice[] paginate($object = null, array $settings = [])
 */
class InvoicesController extends AppController
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['add', 'edit']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Suppliers', 'Scans'],
            'order' => ['Invoices.id' => 'DESC']
        ];
        $invoices = $this->paginate($this->Invoices);

        $this->set(compact('invoices'));
        $this->set('_serialize', ['invoices']);
    }

    /**
     * View method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('invoice', $invoice);
        $this->set('_serialize', ['invoice']);
    }

    /**
     * Add method
     *
     * @param int|null $username
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($username = null)
    {
        $user = null;
        if ($username) {
            $user = $this->Invoices->Users->find()->where(compact('username'))->first();
        }

        if (!$user && !$this->Auth->user()) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $success = true;
        $invoice = $this->Invoices->newEntity();
        $invoice->user_id = $user
            ? $user->id
            : $this->Auth->user('id');
        $invoice->is_approved = $user
            ? false
            : true;
        if ($this->request->is('post')) {
            if (!$this->_processInvoice($invoice, $this->request->getData())) {
                $success = false;
            }

            if (!$this->request->is('json')) {
                return $this->redirect(['action' => 'edit', $invoice->id]);
            }
        }

        $this->set(compact('invoice', 'success', 'username', 'user'));
        $this->set('_serialize', ['invoice', 'success']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Scans', 'Suppliers', 'Users']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                if ($invoice->is_approved) {
                    if (!$invoice->is_paid) {
                        $this->_pay($invoice);
                    }

                    return $this->redirect(['action' => 'process', $invoice->id]);
                } else {
                    return $this->redirect(['action' => 'add', $invoice->user->username]);
                }
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }

        $suppliers = $this->Invoices->Suppliers->find('list');
        //$accounts = $this->Api->get('accounts');
        //$accounts = collection($accounts['accountsResponse']['accounts'])->indexBy('accountToken')->toArray();

        $this->set(compact('invoice', 'suppliers', 'accounts'));
        $this->set('_serialize', ['invoice']);
    }

    /**
     * Process method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function process($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Scans', 'Suppliers', 'Payments']
        ]);

        $this->set(compact('invoice'));
        $this->set('_serialize', ['invoice']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoice = $this->Invoices->get($id);
        if ($this->Invoices->delete($invoice)) {
            $this->Flash->success(__('The invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Prepare entity
     *
     * @param \App\Model\Entity\Invoice $invoice
     * @param array $data
     * @param array $options
     * @return EntityInterface|bool
     */
    protected function _processInvoice(Invoice $invoice, array $data, array $options = [])
    {
        $invoice = $this->Invoices->patchEntity($invoice, $data);

        $vision = new \Vision\Vision(
            Configure::read('Vision.key'),
            [new \Vision\Feature(\Vision\Feature::TEXT_DETECTION, 100)]
        );

        if ($imageBase64 = $this->request->getData('file_base64')) {
            $imageBase64 = str_replace('data:image/jpeg;base64,', '', $imageBase64);
            $imagePath = TMP . DS . time() . '-base64.jpg';
            file_put_contents($imagePath, base64_decode($imageBase64));
        } else {
            $imagePath = $this->request->getData('file.tmp_name');
        }

        $response = $vision->request(new \Vision\Image($imagePath));

        $texts = $response->getTextAnnotations();

        //$image = file_get_contents($imagePath);
        $im = imagecreatefromjpeg($imagePath);
        $red = imagecolorallocate($im, 190, 13, 0);
        foreach ($texts as $box) {
            //debug($box->getDescription());
            $points = [];

            $vertices = $box->getBoundingPoly()->getVertices();
            foreach ($vertices as $vertex) {
                array_push($points, $vertex->getX(), $vertex->getY());
            }

            imagesetthickness($im, 3);
            imagepolygon($im, $points, count($vertices), $red);
        }

        // give our image a name and store it
        $fileName = time() . '.jpg';
        $filePath = TMP . DS . $fileName;
        imagejpeg($im, $filePath);
        imagedestroy($im);

        //$data['data'] = json_encode($texts);

        $lines = [];
        if ($texts) {
            $lines = explode("\n", $texts[0]->getDescription());
        }
        $invoice = $this->Invoices->parseSupplierData($invoice, $lines);

        if (!$this->Invoices->save($invoice)) {
            debug($invoice);die;
            $this->Flash->error('Invoice could not be saved');

            return false;
        }

        $data = $this->request->getData();
        $data['file']['name'] = $fileName;
        $data['file']['tmp_name'] = $filePath;

        $image = $this->Invoices->Scans->newEntity($data);
        if (!$this->Invoices->Scans->upload($invoice->id, $image)) {
            $this->Flash->error('Scan could not be saved');

            return false;
        }

        unlink($filePath);

        return $invoice;
    }

    public function optimise()
    {

    }

    public function share()
    {

    }

    /**
     * Pay method
     *
     * @param Invoice $invoice
     */
    protected function _pay(Invoice $invoice)
    {
        // TODO: for demo purposes
        return;

        $data = [
            "paymentRequest" => [
                "from" => [
                    "account" => [
                        "apiStructType" => "accountToken",
                        "accountToken" => [
                            "token" => $invoice->payment_account_token,
                        ]
                    ]
                ],
                "to" => [
                    "account" => [
                        "apiStructType" => "accountToken",
                        "accountToken" => [
                            "token" => $invoice->supplier->account_token,
                        ]
                    ]
                ],
                "method" => [
                    "apiStructType" => "transfer",
                    "transfer" => [
                        "amount" => $invoice->amount,
                        "statementReference" => __('Invoice {0}', $invoice->number),
                        "remitterName" => $this->Auth->user('full_name'),
                    ],
                ],
                "recurrence" => [
                    "apiStructType" => "onceOff",
                    "onceOff" => [
                        "paymentDate" => date('Y-m-d')
                    ]
                ]
            ]
        ];

        $response = $this->Api->post('payment', $data);

        $payment = $this->Invoices->Payments->newEntity([
            'reference' => Hash::get($response, 'paymentResponse', 'paymentReference'),
        ]);
        $this->Invoices->Payments->saveOrFail($payment);

        $invoice->payment_id = $payment->id;
        $this->Invoices->saveOrFail($invoice);
    }
}
