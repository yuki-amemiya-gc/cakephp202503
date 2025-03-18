<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoginHistory $loginHistory
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Login History'), ['action' => 'edit', $loginHistory->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Login History'), ['action' => 'delete', $loginHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loginHistory->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Login Historys'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Login History'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="loginHistorys view content">
            <h3><?= h($loginHistory->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $loginHistory->has('user') ? $this->Html->link($loginHistory->user->name, ['controller' => 'Users', 'action' => 'view', $loginHistory->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Created User') ?></th>
                    <td><?= h($loginHistory->created_user) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified User') ?></th>
                    <td><?= h($loginHistory->modified_user) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loginHistory->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Login Time') ?></th>
                    <td><?= h($loginHistory->login_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Logout Time') ?></th>
                    <td><?= h($loginHistory->logout_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loginHistory->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loginHistory->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
