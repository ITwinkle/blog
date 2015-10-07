<?php

namespace Framework\Response;

use Framework\DI\Service;

class Flash
{
    public function set($message, $status) {

        Service::get('session')->set('flash',array(
            'status' => $status,
            'message' => $message
        ));
        return true;

    }

    public function show() {

        $flash = Service::get('session')->get('flash');
        if (!empty($flash)) {

            echo '<div class="' . $flash['status'] . '" id="flash">';
            echo $flash['message'];
            echo '</div>';

            Service::get('session')->delete('flash');

        }

        return true;

    }
}