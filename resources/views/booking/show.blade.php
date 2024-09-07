@extends('adminlte::page')

@section('title', '7Travel - Détails de la réservation')

@section('content_header')
    <h1 class="m-0 text-dark">{{__("Booking n°").$booking->id}}</h1>
@stop

@php

@endphp

@section('plugins.Datatables', true)

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Détails de la réservation</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>{{__('Starting date')}}</b> <p class="float-right">&nbsp;{{$booking->startDate}}</p>
                        </li>
                        <li class="list-group-item">
                            <b>{{__('Ending date')}}</b> <p class="float-right">&nbsp;{{$booking->endingDate}}</p>
                        </li>
                        <li class="list-group-item">
                            <b>{{__('Status')}}</b> <p class="float-right">&nbsp;{{$booking->status}}</p>
                        </li>
                        @php if($booking->bookingType_id==1){ @endphp
                        <li class="list-group-item">
                            <b>{{__('City')}}</b> <p class="float-right">&nbsp;{{$booking->city}}</p>
                        </li>
                        @php }elseif($booking->bookingType_id==2){ @endphp
                        <li class="list-group-item">
                            <b>{{__('Starting city')}}</b> <p class="float-right">&nbsp;{{$booking->startCity}}</p>
                        </li>
                        <li class="list-group-item">
                            <b>{{__('Ending city')}}</b> <p class="float-right">&nbsp;{{$booking->endingCity}}</p>
                        </li>
                        @php }@endphp
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
