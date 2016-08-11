@extends('layouts.app')

@section('content')
    <a href="{{ Route('project.update', ['key'=>$project->key]) }}" class="pull-right btn btn-primary">
        <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;upravit
    </a>


    <h1>{{ $project->name }}</h1>

    @if(trim($project->description))
        <div class="panel panel-default">
            <div class="panel-heading">Popis projektu</div>
            <div class="panel-body">
                {!! nl2br(linkInText(e($project->description))) !!}
            </div>
        </div>
    @endif

    @if(trim($project->description_secret) && trim(decrypt($project->description_secret)))
        <div class="panel panel-default">
            <div class="panel-heading">
                Skrytý popis projektu
                &nbsp;
                <button type="button" class="btn btn-primary" id="btn-description-secret">
                    <span class="glyphicon glyphicon-resize-full"></span>&nbsp;zobrazit
                </button>
            </div>
            <div class="panel-body" id="description-secret">
                {!! nl2br(linkInText(e(decrypt($project->description_secret)))) !!}
            </div>
        </div>
    @endif

    @include('@shared.thumb', ['type'=>'project'])
@endsection