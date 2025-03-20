<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roster $roster
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Rosters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="rosters form content">
            <?= $this->Form->create($roster) ?>
            <fieldset>
                <legend><?= __('Add Roster') ?></legend>
                <?php
                    echo $this->Form->control('users_id', ['options' => $users]);
                    echo $this->Form->control('start_time', ['empty' => true]);
                    echo $this->Form->control('end_time', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('reason');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('created_user');
                    echo $this->Form->control('modified_user');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
