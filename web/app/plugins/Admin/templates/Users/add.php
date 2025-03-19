<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <?php
                    echo $this->Form->control('account');
                    echo $this->Form->control('password');
                    echo $this->Form->control('name');
                    echo $this->Form->control('email');
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
