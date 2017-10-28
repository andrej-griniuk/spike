<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
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
}
