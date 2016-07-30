@extends('layouts.app')

@section('content')
    <a href="{{ Route('project.update', ['key'=>$project->key]) }}" class="pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
    projekt.detail

    @include('@shared.thumb', ['type'=>'project'])

    <pre>
    {{ var_dump($project) }}
    </pre>
@endsection