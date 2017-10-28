<?php
namespace App\Model\Table;

use App\Model\Entity\Invoice;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Invoices Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ScansTable $Scans
 * @property \App\Model\Table\SuppliersTable $Suppliers
 * @property \App\Model\Table\PaymentsTable $Payments
 *
 * @method \App\Model\Entity\Invoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invoice newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Invoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InvoicesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('invoices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users');
        $this->belongsTo('Suppliers');
        $this->belongsTo('Payments');
        $this->hasOne('Scans', [
            'foreignKey' => 'foreign_key',
            'conditions' => [
                'Scans.model' => 'Scans'
            ]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('number')
            ->requirePresence('number', 'create')
            ->notEmpty('number');

        $validator
            ->date('invoice_date')
            ->allowEmpty('invoice_date');

        $validator
            ->date('due')
            ->allowEmpty('due');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->scalar('mapped_account')
            //->requirePresence('mapped_account', 'create')
            ->allowEmpty('mapped_account');

        $validator
            ->date('payment_date')
            ->allowEmpty('payment_date');

        $validator
            ->scalar('payment_account_name')
            //->requirePresence('payment_account_name', 'create')
            ->allowEmpty('payment_account_name');

        $validator
            ->scalar('payment_account_token')
            //->requirePresence('payment_account_token', 'create')
            ->allowEmpty('payment_account_token');

        $validator
            ->scalar('data')
            //->requirePresence('data', 'create')
            ->allowEmpty('data');

        $validator
            ->boolean('is_approved')
            //->requirePresence('is_approved', 'create')
            ->allowEmpty('is_approved');

        $validator
            ->boolean('is_paid')
            //->requirePresence('is_paid', 'create')
            ->allowEmpty('is_paid');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'));
        $rules->add($rules->existsIn(['payment_id'], 'Payments'));

        return $rules;
    }

    public function parseSupplierData(Invoice $invoice, array $lines = [])
    {
        //debug($lines);die;

        $data = [];
        $suppliers = $this->Suppliers->find()->all();
        foreach ($suppliers as $supplier) {
            if ($supplier->identifier && in_array($supplier->identifier, $lines)) {
                $parser = "_parse{$supplier->slug}";
                $data = $this->$parser($lines);
                $data['supplier_id'] = $supplier->id;

                break;
            }
        }

        $data += $this->_getDefaultData();
        $invoice = $this->patchEntity($invoice, $data);
        //debug($invoice);die;

        return $invoice;
    }

    protected function _parseTheKnightAlliance(array $lines = [])
    {
        $data = [];
        foreach ($lines as $k => $line) {
            if (strpos($line, 'Invoice No.') !== false) {
                $data['number'] = trim(str_replace('Invoice No.', '', $line));

                continue;
            }

            if (strpos($line, 'Print Date') !== false) {
                $data['invoice_date'] = $this->_parseAustralianDate(trim(str_replace('Print Date', '', $line)));

                continue;
            }

            if (strpos($line, 'Current Charges Payable By') !== false) {
                $data['due'] = $this->_parseAustralianDate(trim(str_replace('Current Charges Payable By', '', $line)));

                continue;
            }

            if (strpos($line, 'Amount Payable') !== false) {
                $data['amount'] = (float)trim(str_replace('$', '', $lines[$k + 1]));

                continue;
            }
        }

        return $data;
    }

    protected function _parseSydneyWater(array $lines = [])
    {
        $data = [
            'invoice_date' => new Date(),
            'due' => new Date(),
        ];

        foreach ($lines as $k => $line) {
            if (strpos($line, 'Payment number') !== false) {
                $data['number'] = trim(str_replace(' ', '', $lines[$k + 1]));

                continue;
            }

            if (strpos($line, 'Total amount due') !== false && !Hash::get($data, 'amount')) {
                $data['amount'] = (float)trim(str_replace('$', '', $lines[$k + 1]));

                continue;
            }
        }

        return $data;
    }

    protected function _parseRedEnergy(array $lines = [])
    {
        $data = [];
        foreach ($lines as $k => $line) {
            if (strpos($line, 'Customer Number:') !== false) {
                $data['number'] = trim($lines[$k + 1]);

                continue;
            }

            if (strpos($line, 'ISSUE DATE') !== false) {
                $data['invoice_date'] = new Date(trim($lines[$k + 1]));

                continue;
            }

            if (strpos($line, 'Due Date:') !== false) {
                $data['due'] = new Date(trim($lines[$k + 3]));

                continue;
            }

            if (strpos($line, 'Amount Due if paid by') !== false) {
                $data['amount'] = (float)trim(str_replace('$', '', $lines[$k + 3]));

                continue;
            }
        }

        return $data;
    }

    protected function _parseAgl(array $lines = [])
    {
        $data = [
            'invoice_date' => new Date(),
        ];

        foreach ($lines as $k => $line) {
            if (strpos($line, 'Account number:') !== false) {
                $data['number'] = trim(str_replace(' ', '', $lines[$k + 3]));

                continue;
            }

            if (strpos($line, 'Due date') !== false) {
                $data['due'] = new Date($lines[$k - 2]);

                continue;
            }

            if (strpos($line, 'Total due') !== false) {
                $data['amount'] = (float)trim(str_replace('$', '', $lines[$k - 1]));

                continue;
            }
        }

        return $data;
    }

    protected function _parseAustralianDate($date)
    {
        $date = explode('/', $date);
        $year = $date[2];
        $month = $date[1];
        $day = $date[0];

        if ($month == '0') {
            $month = '01';
        }

        if ($day == '0') {
            $day = '01';
        }

        return new Date("{$year}-{$month}-{$day}");
    }

    /**
     * Default data
     *
     * @return array
     */
    protected function _getDefaultData()
    {
        return [
            'supplier_id' => 4,
            'number' => '478013',
            'invoice_date' => '2014-01-01',
            'due' => '2014-01-31',
            'amount' => 684.79,
            'mapped_account' => 'Xero - Electricity',
            'payment_account_token' => 'operating',
        ];
    }
}
