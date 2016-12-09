<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller {
    public function index() {
        // Get projects with their respective todos

        // Get infomation

        $tasks_open = Task::where('status', '=', 'OPEN')->count();
        $tasks_inprogress = Task::where('status', '=', 'IN PROGRESS')->count();
        $tasks_closed = Task::where('status', '=', 'COMPLETE')->count();
        $total_tasks = $tasks_open + $tasks_inprogress + $tasks_closed;

        $tasks_inprogress_pc    = round(100*$tasks_inprogress / ($tasks_open+$tasks_inprogress));
        $tasks_open_pc          = round(100*$tasks_open / ($tasks_open+$tasks_inprogress));
        $tasks_closed_pc        = round(100*$tasks_closed / ($total_tasks));

        $tasks_open_data = Task::where('status', '=', 'OPEN')->orderBy('due_date', 'ASC')->get();
        $tasks_inprogress_data = Task::where('status', '=', 'IN PROGRESS')->orderBy('due_date', 'ASC')->get();
        $tasks_closed_data = Task::where('status', '=', 'COMPLETE')->orderBy('updated_at', 'DESC')->limit(5)->get();

        $projects = Project::where('status', '=', 'ACTIVE')->orderBy('due_date', 'ASC')->get();

        return view(
                'dashboard', 
                compact(
                    'tasks_open',
                    'tasks_open_pc',
                    'tasks_open_data',
                    'tasks_inprogress',
                    'tasks_inprogress_pc',
                    'tasks_inprogress_data',
                    'tasks_closed',
                    'tasks_closed_pc',
                    'tasks_closed_data',
                    'total_tasks',
                    'projects'
                )
            );
    }
}
