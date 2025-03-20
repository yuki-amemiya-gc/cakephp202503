<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Roster> $rosters
 */
?>
<div class="rosters index content">
    <?= $this->Html->link(__('New Roster'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3>◾<?= __('Rosters') ?>◾</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('users_id') ?></th>
                    <th><?= $this->Paginator->sort('start_time') ?></th>
                    <th><?= $this->Paginator->sort('end_time') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('reason') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created_user') ?></th>
                    <th><?= $this->Paginator->sort('modified_user') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rosters as $roster): ?>
                <tr>
                  <td><?= $this->Number->format($roster->id) ?></td>
                    <td><?= $roster->has('user') ? $this->Html->link($roster->user->name, ['controller' => 'Users', 'action' => 'view', $roster->user->id]) : '' ?></td>
                  <td><?= h($roster->start_time) ?></td>
                  <td><?= h($roster->end_time) ?></td>
                  <td><?= $this->Number->format($roster->status) ?></td>
                  <td><?= h($roster->reason) ?></td>
                  <td><?= h($roster->deleted) ?></td>
                  <td><?= h(date('Y年m月d日 H時i分s秒', strtotime($roster->created))) ?></td>
                  <td><?= h(date('Y年m月d日 H時i分s秒', strtotime($roster->modified))) ?></td>
                  <td><?= h($roster->created_user) ?></td>
                  <td><?= h($roster->modified_user) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $roster->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $roster->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $roster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roster->id)]) ?>
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
