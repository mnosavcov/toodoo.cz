@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">projekt</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('project.'.(($project->id>0)?'update':'add').'.save', ['key'=>$project->key]) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @if($project->id>0)
                                {{ method_field('PUT') }}
                            @endif
                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Název</label>

                                <div class="col-md-6">
                                    <input id="name" type="name" class="form-control" name="name"
                                           value="{{ old('name', $project->name) }}" maxlength="255">

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
                                                @if(old('priority', $project->priority)==1) selected="selected" @endif>
                                            Vysoká
                                        </option>
                                        <option value="0"
                                                @if(old('priority', $project->priority)==0) selected="selected" @endif>
                                            Normální
                                        </option>
                                        <option value="-1"
                                                @if(old('priority', $project->priority)==-1) selected="selected" @endif>
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
                                    <textarea id="description" class="form-control"
                                              name="description" rows="8">{{ old('description', $project->description) }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="button" class="btn btn-primary col-md-12" id="description-secret-button">
                                        Upravit skrytý popis
                                    </button>
                                </div>
                            </div>

                            <div id="description-secret" class="form-group{{ $errors->has('description_secret') ? ' has-error' : '' }}">
                                <label for="description_secret" class="col-md-4 control-label">Popis skrytý</label>

                                <div class="col-md-6">
                                    <textarea id="description_secret" class="form-control"
                                              name="description_secret" rows="8">{{ old('description_secret', decrypt($project->description_secret)) }}</textarea>

                                    @if ($errors->has('description_secret'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description_secret') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('files[]') ? ' has-error' : '' }}">
                                <label for="files" class="col-md-4 control-label">Soubory</label>

                                <div class="col-md-6">
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
                                <div class="col-md-6 col-md-offset-4">
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
    </div>
@endsection
