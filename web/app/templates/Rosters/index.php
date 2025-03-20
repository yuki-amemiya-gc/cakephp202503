<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Roster> $rosters
 */
?>
<div class="rosters index content">
    <h3>◾<?= __('勤務表') ?>◾</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= ('start_time') ?></th>
                    <th><?= ('end_time') ?></th>
                    <th><?= ('status') ?></th>
                    <th><?= ('reason') ?></th>

                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rosters as $roster): ?>
                <tr>
                    <td><?= h($roster->start_time) ?></td>
                    <td><?= h($roster->end_time) ?></td>
                    <td><?= $this->Number->format($roster->status) ?></td>
                    <td><?= h($roster->reason) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $roster->id]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
