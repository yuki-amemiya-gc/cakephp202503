<div class="rosters form">
    <center>
        <?= $this->Flash->render() ?>
        <?php
            $this->start('title');
            echo '勤怠システム';
            $this->end();
        ?>
        <div style="width:500px">
            <?= $this->Form->create() ?>
            <?= __('アカウントIDを入力して打刻してください。') ?>
            <?= $this->Form->control('account', ['required' => true, 'label' => '']) ?>
            <?= $this->Form->button('出勤', ['value' => 'sta', 'name' => 'kubun']); ?>
            <?= $this->Form->button('退勤', ['value' => 'end', 'name' => 'kubun']); ?>
            <?= $this->Form->end() ?>
        </div>
    </center>
</div>