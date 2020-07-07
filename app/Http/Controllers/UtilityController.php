<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class UtilityController extends Controller
{
    protected function ping()
    {
        return 'pong';
    }

    protected function logPing()
    {
        Log::info('pong');
        Log::error('pong');

        return 'pong';
    }
}
