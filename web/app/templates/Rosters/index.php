<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roster[]|\Cake\Collection\CollectionInterface $rosters
 */

use Cake\I18n\FrozenTime;

$month = range(0, 12);
unset($month[0]);


$default_year = $condition['year'];
$default_day = $condition['month'];

?>
<div class="rosters index content">
    <h3><?= __('勤務表') ?></h3>
    <?= $this->Form->create($rosters, ['type' => 'get']) ?>
    <div style="float: left; padding-right: 10px;">
        <?= $this->Form->select('year', $years, ['value' => $default_year]) ?>
    </div>
    <div style="float: left; padding: 7px 10px 5px 0px;">年</div>
    <div style="float: left; padding-right: 10px;">
        <?= $this->Form->select('month', $month, ['value' => $default_day]) ?>
    </div>
    <div style="float: left; padding: 7px 10px 5px 0px;">月</div>
    <div style="float: left">
        <?= $this->Form->button(__('search')) ?>
    </div>
    <?= $this->Form->end() ?>
    <div class="table-responsive">
        <?php if (isset($rosters)) : ?>
            <table>
                <thead>
                    <tr>
                        <th><?= __('day') ?></th>
                        <th><?= __('start_time') ?></th>
                        <th><?= __('end_time') ?></th>
                        <th><?= __('status') ?></th>
                        <th><?= __('reason') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rosters as $key => $roster) : ?>
                        <?php $date = new FrozenTime($condition['year'] . '-' . $condition['month'] . '-' . $key) ?>
                        <tr>
                            <td><?= h($date->i18nFormat('d日（E）')) ?></td>
                            <td><?= empty($roster->start_time) ? '' : h($roster->start_time->i18nFormat('HH:mm')) ?></td>
                            <td><?= empty($roster->end_time) ? '' : h($roster->end_time->i18nFormat('HH:mm')) ?></td>
                            <td><?= empty($roster->status) ? '' : $this->Number->format($roster->status) ?></td>
                            <td><?= empty($roster->reason) ? '' : h($roster->reason) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', empty($roster) ? '' : $roster->id, '?' => ['date' => $date->i18nFormat('yyyy-MM-dd 00:00')]]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>