<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProjectRequest as StoreRequest;
use App\Http\Requests\ProjectRequest as UpdateRequest;

class ProjectCrudController extends CrudController {

	public function setUp() {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Project");
        $this->crud->setRoute("project");
        $this->crud->setEntityNameStrings('project', 'projects');

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


        // ------ CRUD FIELDS

        $this->crud->addField([
                        'name' => 'name',
                        'label' => 'Name'
                    ]);

        $this->crud->addField([
                        'name' => 'due_date',
                        'label' => 'Due Date',
                        'type' => 'date',
                        'value' => date('Y-m-d')
                    ], 'create');

        $this->crud->addField([
                        'name' => 'due_date',
                        'label' => 'Due Date',
                        'type' => 'date'
                    ], 'edit');

        $this->crud->addField([
                        'name' => 'description',
                        'label' => 'Description',
                        'type' => 'summernote'
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
}
