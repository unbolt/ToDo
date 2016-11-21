<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TaskRequest as StoreRequest;
use App\Http\Requests\TaskRequest as UpdateRequest;

class TaskCrudController extends CrudController {

	public function setUp() {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Task");
        $this->crud->setRoute("task");
        $this->crud->setEntityNameStrings('task', 'tasks');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

		// ------ CRUD COLUMNS
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
                   'label' => "Project", // Table column heading
                   'type' => "select",
                   'name' => 'project_id', // the column that contains the ID of that connected entity;
                   'entity' => 'project', // the method that defines the relationship in your Model
                   'attribute' => "name", // foreign key attribute that is shown to user
                   'model' => "App\Models\Project", // foreign key model
                ]);

        $this->crud->addColumn([
                    'name' => 'status',
                    'label' => "Status"
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

        $this->crud->enableReorder('name', 1);
        $this->crud->allowAccess('reorder');

    }

	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}

	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
