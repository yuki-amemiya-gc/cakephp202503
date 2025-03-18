<?php
declare(strict_types=1);

namespace App\Test\Fixture;

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
                'created' => 1742305576,
                'modified' => 1742305576,
                'created_user' => 'Lorem ipsum dolor sit amet',
                'modified_user' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
