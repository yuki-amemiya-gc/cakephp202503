<?php
declare(strict_types=1);

namespace App\Controller;

class HelloController extends AppController
{
    public function index()
    {
        $this->autoRender = false;
        echo "Hello, World!";
    }
}
