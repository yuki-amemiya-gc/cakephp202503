<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoginHistory $loginHistory
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Login Historys'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="loginHistorys form content">
            <?= $this->Form->create($loginHistory) ?>
            <fieldset>
                <legend><?= __('Add Login History') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('login_time');
                    echo $this->Form->control('logout_time');
                    echo $this->Form->control('created_user');
                    echo $this->Form->control('modified_user');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
