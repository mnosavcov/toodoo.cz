@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">task</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('task.'.(($task->id>0)?'update':'add').'.save', ['key'=>$project->key]) }}">
                            {{ csrf_field() }}

                            @if($task->id>0)
                                {{ method_field('PUT') }}
                            @endif
                            <input type="hidden" name="task_id" value="{{ $task->id }}">

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Název</label>

                                <div class="col-md-6">
                                    <input id="name" type="name" class="form-control" name="name"
                                           value="{{ old('name', $task->name) }}" maxlength="255">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
                                <label for="key" class="col-md-4 control-label">Klíč</label>

                                <div class="col-md-6">
                                    <input id="key" type="key" class="form-control" name="key"
                                           value="{{ old('key', $project->key) }}"
                                           maxlength="10">

                                    @if ($errors->has('key'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('key') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                                <label for="priority" class="col-md-4 control-label">Priorita</label>

                                <div class="col-md-6">
                                    <select id="priority" type="priority" class="form-control" name="priority">
                                        <option value="1"
                                                @if(old('priority', $task->priority)==1) selected="selected" @endif>
                                            Vysoká
                                        </option>
                                        <option value="0"
                                                @if(old('priority', $task->priority)==0) selected="selected" @endif>
                                            Normální
                                        </option>
                                        <option value="-1"
                                                @if(old('priority', $task->priority)==-1) selected="selected" @endif>
                                            Nízká
                                        </option>
                                    </select>

                                    @if ($errors->has('priority'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Popis</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="description" class="form-control"
                                              name="description">{{ old('description', $task->description) }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i> Uložit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
