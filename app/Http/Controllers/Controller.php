<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendFlashMessage($message, $status = 'success')
    {
        if(is_array($message)) {
            $message = implode(' ', $message);
        }

        if ($message != '') {
            Session::flash('flash_message', $message);
            Session::flash('flash_type', $status);
        }
    }
}
