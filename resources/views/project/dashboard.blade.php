@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ Route('project.detail', ['id'=>$project->key]) }}">Detail</a>
                <a href="{{ Route('project.update', ['id'=>$project->key]) }}">Update</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">todo</div>
                    </div>
                </div>
            </div>
            @foreach($tasks as $task)
                <div class="bs-callout bs-callout-danger" id="callout-overview-not-both"> <h4>{{ $task->name }}</h4> <p>{{ $task->description }}Lorem Ipsum je demonstrativní výplňový text používaný v tiskařském a knihařském průmyslu. Lorem Ipsum je považováno za standard v této oblasti už od začátku 16. století, kdy dnes neznámý tiskař vzal kusy textu a na jejich základě vytvořil speciální vzorovou knihu. Jeho odkaz nevydržel pouze pět století, on přežil i nástup elektronické sazby v podstatě beze změny. Nejvíce popularizováno bylo Lorem Ipsum v šedesátých letech 20. století, kdy byly vydávány speciální vzorníky s jeho pasážemi a později pak díky počítačovým DTP programům jako Aldus PageMaker</p> </div>
                <div class="bs-callout bs-callout-danger" id="callout-overview-not-both"> <h4>{{ $task->name }}</h4> <p>{{ $task->description }}</p> </div>
                <div class="bs-callout bs-callout-danger" id="callout-overview-not-both"> <h4>{{ $task->name }}</h4> <p>{{ $task->description }}</p> </div>
            @endforeach
        </div>
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">in progress</div>
                    </div>
                </div>
            </div>
            @foreach($tasks as $task)
                <div class="bs-callout bs-callout-info" id="callout-overview-not-both"> <h4>{{ $task->name }}</h4> <p>{{ $task->description }}</p> </div>
                <div class="bs-callout bs-callout-info" id="callout-overview-not-both"> <h4>{{ $task->name }}</h4> <p>{{ $task->description }}</p> </div>
                <div class="bs-callout bs-callout-info" id="callout-overview-not-both"> <h4>{{ $task->name }}</h4> <p>{{ $task->description }}</p> </div>
            @endforeach
        </div>
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">done / reject</div>
                    </div>
                </div>
            </div>
            @foreach($tasks as $task)
                <div class="bs-callout" id="callout-overview-not-both"> <h4>{{ $task->name }}</h4> <p>{{ $task->description }}</p> </div>
                <div class="bs-callout" id="callout-overview-not-both"> <h4>{{ $task->name }}</h4> <p>{{ $task->description }}</p> </div>
                <div class="bs-callout" id="callout-overview-not-both"> <h4>{{ $task->name }}</h4> <p>{{ $task->description }}</p> </div>
            @endforeach
        </div>
    </div>
@endsection