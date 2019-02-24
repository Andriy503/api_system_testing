<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Core component
 */
class CoreComponent extends Component
{
    public function jsonResponse($success = false, $message = null, $data = [])
    {
        $this->getController()->viewBuilder()->setClassName('Json');

        $this->getController()->set(compact(['success', 'message', 'data']));

        $serialize = ['success'];

        if ($message !== null) {
            $serialize[] = 'message';
        }

        if (!empty($data)) {
            $serialize[] = 'data';
        }

        $this->getController()->set('_serialize', $serialize);
    }

}
