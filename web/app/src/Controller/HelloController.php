<?php
declare(strict_types=1);

namespace App\Controller;

class HelloController extends AppController
{
    public function index()
    {
        // ビューに渡す変数をセット（任意）
        $this->set('message', 'Hello, World!');
    }
}
