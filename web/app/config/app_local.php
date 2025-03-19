<?php
/*
 * ブランチを分けてみるテストのための修正
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', 'ad917005063db52f190f19496cf2fc42fd89dc746be6026f5740ee38717b1b17'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'driver' => 'Cake\Database\Driver\Mysql',
            'host' => 'db', // MySQL コンテナのサービス名（docker-compose.yml でのサービス名）
            'username' => env('MYSQL_USER', 'user'), // 環境変数で設定
            'password' => env('MYSQL_PASSWORD', 'password'), // 環境変数で設定
            'database' => env('MYSQL_DATABASE', 'cakephp'), // 環境変数で設定
            'port' => '3306', // MySQL のデフォルトポート
            'encoding' => 'utf8mb4',
        ],

        'test' => [
            'driver' => 'Cake\Database\Driver\Mysql',
            'host' => 'db', // 同様にサービス名を指定
            'username' => env('MYSQL_USER', 'user'),
            'password' => env('MYSQL_PASSWORD', 'password'),
            'database' => 'test_cakephp', // テスト用のデータベース
            'port' => '3306',
            'encoding' => 'utf8mb4',
        ],
    ],


    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
