<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RostersFixture
 */
class RostersFixture extends TestFixture
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
                'users_id' => 1,
                'start_time' => '2025-03-20 06:53:43',
                'end_time' => '2025-03-20 06:53:43',
                'status' => 1,
                'reason' => 'Lorem ipsum dolor sit amet',
                'deleted' => '2025-03-20 06:53:43',
                'created' => 1742453623,
                'modified' => 1742453623,
                'created_user' => 'Lorem ipsum dolor sit amet',
                'modified_user' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
