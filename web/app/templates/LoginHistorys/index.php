<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoginHistory> $loginHistorys
 */
?>
<div class="loginHistorys index content">
    <?= $this->Html->link(__('New Login History'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Login Historys') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('login_time') ?></th>
                    <th><?= $this->Paginator->sort('logout_time') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created_user') ?></th>
                    <th><?= $this->Paginator->sort('modified_user') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loginHistorys as $loginHistory): ?>
                <tr>
                    <td><?= $this->Number->format($loginHistory->id) ?></td>
                    <td><?= $loginHistory->has('user') ? $this->Html->link($loginHistory->user->name, ['controller' => 'Users', 'action' => 'view', $loginHistory->user->id]) : '' ?></td>
                    <td><?= h($loginHistory->login_time) ?></td>
                    <td><?= h($loginHistory->logout_time) ?></td>
                    <td><?= h($loginHistory->created) ?></td>
                    <td><?= h($loginHistory->modified) ?></td>
                    <td><?= h($loginHistory->created_user) ?></td>
                    <td><?= h($loginHistory->modified_user) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loginHistory->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loginHistory->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loginHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loginHistory->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
