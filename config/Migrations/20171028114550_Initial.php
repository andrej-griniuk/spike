<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('invoices')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('supplier_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('payment_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('number', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('invoice_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('due', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('amount', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 22,
                'scale' => 2,
            ])
            ->addColumn('mapped_account', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('payment_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('payment_account_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('payment_account_token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('data', 'text', [
                'default' => null,
                'limit' => 4294967295,
                'null' => false,
            ])
            ->addColumn('is_approved', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_paid', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->addIndex(
                [
                    'supplier_id',
                ]
            )
            ->addIndex(
                [
                    'payment_id',
                ]
            )
            ->create();

        $this->table('payments')
            ->addColumn('reference', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'reference',
                ]
            )
            ->create();

        $this->table('suppliers')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'name',
                ]
            )
            ->create();

        $this->table('users')
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'username',
                ]
            )
            ->create();
    }

    public function down()
    {
        $this->dropTable('invoices');
        $this->dropTable('payments');
        $this->dropTable('suppliers');
        $this->dropTable('users');
    }
}
