<?php
declare(strict_types=1);

namespace Admin\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    
        // 認証結果を確認し、サイトのロックを行うために次の行を追加します
        $this->loadComponent('Authentication.Authentication');
    }

}
