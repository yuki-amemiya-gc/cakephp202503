<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= h($user->account) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($user->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created User') ?></th>
                    <td><?= h($user->created_user) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified User') ?></th>
                    <td><?= h($user->modified_user) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Login Historys') ?></h4>
                <?php if (!empty($user->login_historys)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Login Time') ?></th>
                            <th><?= __('Logout Time') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Created User') ?></th>
                            <th><?= __('Modified User') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->login_historys as $loginHistorys) : ?>
                        <tr>
                            <td><?= h($loginHistorys->id) ?></td>
                            <td><?= h($loginHistorys->user_id) ?></td>
                            <td><?= h($loginHistorys->login_time) ?></td>
                            <td><?= h($loginHistorys->logout_time) ?></td>
                            <td><?= h($loginHistorys->created) ?></td>
                            <td><?= h($loginHistorys->modified) ?></td>
                            <td><?= h($loginHistorys->created_user) ?></td>
                            <td><?= h($loginHistorys->modified_user) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LoginHistorys', 'action' => 'view', $loginHistorys->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LoginHistorys', 'action' => 'edit', $loginHistorys->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoginHistorys', 'action' => 'delete', $loginHistorys->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loginHistorys->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
