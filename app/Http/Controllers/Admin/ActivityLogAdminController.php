<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ActivityLogAdminController extends Controller
{
    public function show()
    {
        return view('admin.dashboard.settings.activity.show');
    }
}
