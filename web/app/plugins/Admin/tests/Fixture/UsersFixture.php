<?php
declare(strict_types=1);

namespace Admin\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'account' => 'Lorem ipsum dolor ',
                'password' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor ',
                'email' => 'Lorem ipsum dolor sit amet',
                'deleted' => '2025-03-19 12:30:23',
                'created' => 1742387423,
                'modified' => 1742387423,
                'created_user' => 'Lorem ipsum dolor sit amet',
                'modified_user' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
