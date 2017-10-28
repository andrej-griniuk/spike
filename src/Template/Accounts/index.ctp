<?php
/**
 * @var \App\View\AppView $this
 * @var array $accounts
 */

use Cake\Utility\Hash;
?>
<h2 class="text-center"><?= __('ACCOUNTS') ?></h2>

<?php foreach ($accounts as $account): ?>
    <?php
    $availableBalance = Hash::get($account, 'availableBalance');
    $currentBalance = Hash::get($account, 'currentBalance');
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong><?= h(Hash::get($account, 'nickname')) ?></strong>
            <span class="pull-right">#<?= h(Hash::get($account, 'accountIdDisplay')) ?></span>
        </div>
        <div class="panel-body">
            <table class="table">
                <?php if ($category = Hash::get($account, 'category')): ?>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($category) ?></td>
                </tr>
                <?php endif; ?>
                <?php if ($type = Hash::get($account, 'accountType')): ?>
                <tr>
                    <th><?= __('Account Type') ?></th>
                    <td><?= h(ucfirst($type)) ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <th><?= __('Available Balance') ?></th>
                    <td>
                        <?php if ($availableBalance > 0): ?>
                            <span class="label label-success"><?= $this->Number->currency($availableBalance) ?></span>
                        <?php elseif ($availableBalance < 0): ?>
                            <span class="label label-danger"><?= $this->Number->currency($availableBalance) ?></span>
                        <?php else: ?>
                            <span class="label label-info"><?= $this->Number->currency($availableBalance) ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:150px"><?= __('Current Balance') ?></th>
                    <td>
                        <?php if ($currentBalance > 0): ?>
                            <span class="label label-success"><?= $this->Number->currency($currentBalance) ?></span>
                        <?php elseif ($currentBalance < 0): ?>
                            <span class="label label-danger"><?= $this->Number->currency($currentBalance) ?></span>
                        <?php else: ?>
                            <span class="label label-info"><?= $this->Number->currency($currentBalance) ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<?php endforeach; ?>
