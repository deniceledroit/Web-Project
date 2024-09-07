@extends('adminlte::page')

@section('title', '7Travel - Réservations')

@section('content_header')
    <h1 class="m-0 text-dark">{{__('Bookings')}}</h1>
@stop

@php
    $heads = [
        '#',
        __('Name'),
        __('Status'),
        ['label' => 'Actions', 'no-export' => true]
    ];

    $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                       <i class="fa fa-lg fa-fw fa-eye"></i>
                   </button>';
    $btnCancel = '<button class="btn btn-xs btn-default text-red mx-1 shadow" title="Erase">
                       <i class="fa fa-lg fa-fw fa-ban"></i>
                   </button>';
    $config=['columns' => [null, null]]
@endphp

@section('plugins.Datatables', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Réservations en cours</p>
                    <p style="color: green">{{$info}}</p>
                    <x-adminlte-datatable id="table-categories" :heads="$heads" :config="$config">
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->id}}</td>
                                <td>{{$booking->name}}</td>
                                <td>{{$booking->status}}</td>
                                <td><a href="{{url("booking/".$booking->id)}}">{!! $btnDetails !!}</a>
                                    @if($booking->status!='annulée')
                                        <a href="{{route('booking.edit',$booking->id)}}">{!! $btnCancel !!}</a>
                                    @endif</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
