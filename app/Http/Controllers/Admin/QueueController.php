<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QueueController extends Controller
{
    public function index(): View
    {
        return view('admin.queues.index', [
            'pendingJobs' => DB::table('jobs')->count(),
            'failedJobs' => DB::table('failed_jobs')->count(),
            'recentFailedJobs' => DB::table('failed_jobs')->latest('failed_at')->limit(10)->get(),
        ]);
    }
}
