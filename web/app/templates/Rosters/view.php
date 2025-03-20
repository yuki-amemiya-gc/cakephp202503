<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roster $roster
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Roster'), ['action' => 'edit', $roster->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Roster'), ['action' => 'delete', $roster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roster->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Rosters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Roster'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="rosters view content">
            <h3><?= h($roster->reason) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $roster->has('user') ? $this->Html->link($roster->user->name, ['controller' => 'Users', 'action' => 'view', $roster->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Reason') ?></th>
                    <td><?= h($roster->reason) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created User') ?></th>
                    <td><?= h($roster->created_user) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified User') ?></th>
                    <td><?= h($roster->modified_user) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($roster->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($roster->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= h($roster->start_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Time') ?></th>
                    <td><?= h($roster->end_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($roster->deleted) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($roster->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($roster->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
