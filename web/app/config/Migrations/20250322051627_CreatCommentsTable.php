<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatCommentsTable extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void
    {
        $this->table('comments')
            ->addColumn('post_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'post_id',
                ],
                [
                    'name' => 'comments_ibfk_1',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ],
                [
                    'name' => 'comments_ibfk_2',
                ]
            )
            ->addIndex(
                [
                    'parent_id',
                ],
                [
                    'name' => 'comments_ibfk_3',
                ]
            )
            ->create();

        $this->table('comments')
            ->addForeignKey(
                'post_id',
                'posts',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'CASCADE',
                    'constraint' => 'comments_ibfk_1'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'CASCADE',
                    'constraint' => 'comments_ibfk_2'
                ]
            )
            ->addForeignKey(
                'parent_id',
                'comments',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'CASCADE',
                    'constraint' => 'comments_ibfk_3'
                ]
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down(): void
    {
        $this->table('comments')
            ->dropForeignKey(
                'post_id'
            )
            ->dropForeignKey(
                'user_id'
            )
            ->dropForeignKey(
                'parent_id'
            )->save();

        $this->table('comments')->drop()->save();
    }
}
