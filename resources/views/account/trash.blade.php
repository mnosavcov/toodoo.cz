@extends('layouts.app')

@section('content')
    <table class="table table-bordered col-xs-12">
        @foreach($items as $item)
            <tr>
                <td class="col-xs-1 active">
                    <strong>{{ $item->key }}</strong>
                    <div class="clearfix"></div>
                    <span class="label label-{{ $item->type=='project'?'success':'primary' }}">
                        {{ trans('message.'.$item->type) }}
                    </span>

                </td>
                <td class="col-xs-11{{$item->deleted_at + 2419200<time()?' bg-danger':''}}">
                    <span class="pull-right">vloženo do koše {{ date('d.m.Y H:i:s', $item->deleted_at) }}</span>
                    <span class="pull-left">
                            bude odstraněno {{ date('d.m.Y H:i', $item->deleted_at + 2592000) }} {{-- 30 dni --}}
                    </span>

                    <div class="clearfix"></div>

                    <div class="pull-right btn-group">
                        <a href="javascript:void(0)" type="button"
                           class="btn btn-success"
                           onclick="location_confirm('Opravdu si přejete položku obnovit?', '{{ Route($item->type.'.renew', ['key'=>$item->key]) }}')">
                            <span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;obnovit
                        </a>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0)"
                                   onclick="location_confirm('opravdu nanávratně smazat tuto položku? Budou odstraněny všechny přiložené soubory k této položce. Pokud se jedná o projekt budou smazány všechny úkoly tohoto projektu včetně vložených souborů.', '{{ Route($item->type.'.delete.force', ['key'=>$item->key]) }}')">
                                    <span class="glyphicon glyphicon-remove-sign text-danger"></span>
                                    <strong class="text-danger">ODSTRANIT NA VŽDY</strong>
                                </a>
                            </li>
                        </ul>
                    </div>

                    @if($item->type=='task')
                        <strong>{{ $item->task_name }}</strong>
                        <br>
                        <strong>[{{ $item->project_name }}]</strong>
                    @else
                        <strong>{{ $item->project_name }}</strong>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection