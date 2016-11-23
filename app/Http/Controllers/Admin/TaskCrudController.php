<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TaskRequest as StoreRequest;
use App\Http\Requests\TaskRequest as UpdateRequest;

use App\Models\Task as Task;

class TaskCrudController extends CrudController {

	public function setUp() {

        $this->crud->setModel("App\Models\Task");
        $this->crud->setRoute("task");
        $this->crud->setEntityNameStrings('task', 'tasks');
        $this->crud->enableReorder('name', 1);
        $this->crud->allowAccess('reorder');
        $this->crud->addClause('where', 'status', '!=', 'COMPLETE');

		// ------ CRUD COLUMNS
        $this->crud->addColumn([
                    'name' => 'status',
                    'label' => "Status"
                ]);

        $this->crud->addColumn([
                    'name' => 'name',
                    'label' => "Name"
                ]);

        $this->crud->addColumn([
                    'name' => 'due_date',
                    'label' => 'Due Date',
                    'type' => 'date'
                ]);

        $this->crud->addColumn([
                   'label' => "Project", 
                   'type' => "select",
                   'name' => 'project_id', 
                   'entity' => 'project', 
                   'attribute' => "name", 
                   'model' => "App\Models\Project", 
                ]);


        $this->crud->addFilter([
                    'name' => 'status',
                    'type' => 'dropdown',
                    'label'=> 'Status'
                ], [
                    'OPEN' => 'OPEN',
                    'IN PROGRESS' => 'IN PROGRESS',
                    'COMPLETE' => 'COMPLETE'
                ], function($value) {
                    $this->crud->addClause('where', 'status', $value);
                });

        $this->crud->addFilter([
                    'name' => 'project_id',
                    'type' => 'select2',
                    'label'=> 'Project'
                ], function() {
                    return \App\Models\Project::all()->pluck('name', 'id')->toArray();
                }, function($value) {
                    $this->crud->addClause('where', 'project_id', $value);
                });



        // ------ CRUD FIELDS

        $this->crud->addField([
                        'name' => 'status',
                        'label' => "Status",
                        'type' => 'enum'
                    ]);

        $this->crud->addField([
                        'name' => 'name',
                        'label' => 'Name'
                    ]);

        $this->crud->addField([
                        'name' => 'due_date',
                        'label' => 'Due Date',
                        'type' => 'date'
                    ]);

        $this->crud->addField([
                        'name' => 'description',
                        'label' => 'Description',
                        'type' => 'summernote'
                    ]);

        $this->crud->addField([
                        'label' => "Project",
                        'type' => 'select2',
                        'name' => 'project_id',
                        'entity' => 'project',
                        'attribute' => 'name',
                        'model' => "App\Models\Project"
                    ]);
    }

	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}

	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}

    public function changeStatus($id, $status) {
        $task = Task::findOrFail($id);
        $task->status = $status;
        $task->save();
        return back();
    }
}
