<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roster $roster
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $roster->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $roster->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Rosters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="rosters form content">
            <?= $this->Form->create($roster) ?>
            <fieldset>
                <legend><?= __('Edit Roster') ?></legend>
                <?php
                    echo $this->Form->control('users_id', ['disabled' => true]);
                    echo $this->Form->control('start_time', ['type' => 'time']);
                    echo $this->Form->control('end_time', ['type' => 'time']);
                    echo $this->Form->control('status');
                    echo $this->Form->control('reason');
                    // echo $this->Form->control('deleted', ['empty' => true]);
                    // echo $this->Form->control('created_user');
                    // echo $this->Form->control('modified_user');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>