<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoginHistory $loginHistory
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $loginHistory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $loginHistory->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Login Historys'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="loginHistorys form content">
            <?= $this->Form->create($loginHistory) ?>
            <fieldset>
                <legend><?= __('Edit Login History') ?></legend>
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
