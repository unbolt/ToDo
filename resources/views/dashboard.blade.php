@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
      <div class="col-md-4">
        <div class="info-box bg-aqua">
          <span class="info-box-icon"><i class="fa fa-cog"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">In Progress</span>
            <span class="info-box-number">{{ $tasks_inprogress }}</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: {{ $tasks_inprogress_pc }}%"></div>
            </div>
            <span class="progress-description">
              {{ $tasks_inprogress_pc }}%
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box bg-yellow">
          <span class="info-box-icon"><i class="fa fa-square-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Open</span>
            <span class="info-box-number">{{ $tasks_open }}</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: {{ $tasks_open_pc }}%"></div>
            </div>
            <span class="progress-description">
              {{ $tasks_open_pc }}%
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box bg-green">
          <span class="info-box-icon"><i class="fa fa-check-square-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Closed</span>
            <span class="info-box-number">{{ $tasks_closed }}</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: {{ $tasks_closed_pc }}%"></div>
            </div>
            <span class="progress-description">
              {{ $tasks_closed_pc }}%
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">In Progress</h3>
            </div>
            <div class="box-body no-padding">
              <table class="table table-condensed">
                @foreach ($tasks_inprogress_data as $task)
                  <tr>
                    <td><span class="label" style="background-color: #{{ $task->project->color }};">{{ $task->project->acronym }}</span></td>
                    <td>{{ $task->name }}</td>
                    <td><a href="/task/{{ $task->id }}/COMPLETE" class="btn btn-block btn-success btn-xs">Finish</a></td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">Open</h3>
            </div>
            <div class="box-body no-padding">
              <table class="table table-condensed">
                @foreach ($tasks_open_data as $task)
                  <tr>
                    <td><span class="label" style="background-color: #{{ $task->project->color }};">{{ $task->project->acronym }}</span></td>
                    <td>{{ $task->name }}</td>
                    <td><a href="/task/{{ $task->id }}/IN PROGRESS" class="btn btn-block btn-info btn-xs">Start</a></td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
      </div>
      <div class="col-md-4">
        <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Closed</h3>
            </div>
            <div class="box-body no-padding">
              <table class="table table-condensed">
                @foreach ($tasks_closed_data as $task)
                  <tr>
                    <td><span class="label" style="background-color: #{{ $task->project->color }};">{{ $task->project->acronym }}</span></td>
                    <td>{{ $task->name }}</td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
      </div>
    </div>

    @foreach($projects->chunk(3) as $items)
      <div class="row">
        @foreach($items as $project)
          <article class="col-md-4">
            <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-{{ $project->criticality }}">
              <div class="widget-user-image">
                <img class="img-circle" src="http://placehold.it/160x160/{{ $project->color }}/ffffff/&text={{ $project->acronym }}" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">{{ $project->name }}</h3>
              <h5 class="widget-user-desc">due {{ $project->due_date->diffForHumans() }}</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                @if( $project->in_progress_count )
                  <li><a href="#">In Progress <span class="pull-right badge bg-aqua">{{ $project->in_progress_count }}</span></a></li>
                @endif
                @if( $project->open_count )
                  <li><a href="#">Open <span class="pull-right badge bg-yellow">{{ $project->open_count }}</span></a></li>
                @endif
                @if( $project->closed_count )
                  <li><a href="#">Closed <span class="pull-right badge bg-green">{{ $project->closed_count }}</span></a></li>
                @endif
              </ul>
            </div>
          </div>
          </article>
        @endforeach
      </div>
    @endforeach
@endsection
