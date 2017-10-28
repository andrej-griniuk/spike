<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $supplier_id
 * @property int $payment_id
 * @property string $number
 * @property \Cake\I18n\FrozenDate $invoice_date
 * @property \Cake\I18n\FrozenDate $due
 * @property float $amount
 * @property string $mapped_account
 * @property \Cake\I18n\FrozenDate $payment_date
 * @property string $payment_account_name
 * @property string $payment_account_token
 * @property string $data
 * @property bool $is_approved
 * @property bool $is_paid
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\User $scan
 * @property \App\Model\Entity\Supplier $supplier
 */
class Invoice extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'supplier_id' => true,
        'payment_id' => true,
        'number' => true,
        'invoice_date' => true,
        'due' => true,
        'amount' => true,
        'mapped_account' => true,
        'payment_date' => true,
        'payment_account_name' => true,
        'payment_account_token' => true,
        'data' => true,
        'is_approved' => true,
        'is_paid' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
}
