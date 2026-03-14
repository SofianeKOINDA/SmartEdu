<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index()
    {
        $logs = Activity::orderByDesc('created_at')->paginate(50);
        return view('super_admin.logs.index', compact('logs'));
    }
}

