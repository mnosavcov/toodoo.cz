@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">task</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST"
                          action="{{ route('task.'.(($task->id>0)?'update':'add').'.save', ['key'=>(($task->id>0)?$task->key():$project->key), 'owner'=>$project->owner()]) }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @if($task->id>0)
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" name="task_id" value="{{ $task->id }}">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Název</label>

                            <div class="col-md-10">
                                <input id="name" type="name" class="form-control" name="name"
                                       value="{{ old('name', $task->name) }}" maxlength="255">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                            <label for="priority" class="col-md-2 control-label">Priorita</label>

                            <div class="col-md-10">
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
                            <label for="description" class="col-md-2 control-label">Popis</label>

                            <div class="col-md-10">
                                    <textarea id="description" class="form-control"
                                              name="description"
                                              rows="15">{{ old('description', $task->description) }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <button type="button" class="btn btn-primary col-md-12" id="description-secret-button">
                                    Upravit skrytý popis
                                </button>
                            </div>
                        </div>

                        <div id="description-secret"
                             class="form-group{{ $errors->has('description_secret') ? ' has-error' : '' }}">
                            <label for="description_secret" class="col-md-2 control-label">Popis skrytý</label>

                            <div class="col-md-10">
                                    <textarea id="description_secret" class="form-control"
                                              name="description_secret"
                                              rows="15">{{ old('description_secret', ((isset($task->description_secret) && $task->description_secret)?decrypt($task->description_secret):'')) }}</textarea>

                                @if ($errors->has('description_secret'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description_secret') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('files[]') ? ' has-error' : '' }}">
                            <label for="files" class="col-md-2 control-label">Soubory</label>

                            <div class="col-md-10">
                                <input id="files" type="file" class="form-control"
                                       name="files[]" multiple>

                                @if ($errors->has('files[]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('files[]') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Uložit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
