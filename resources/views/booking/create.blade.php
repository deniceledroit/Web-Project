@extends('adminlte::page')

@section('title', '7Travel - Créer une réservation')

@section('content_header')
    <h1 class="m-0 text-dark">{{__('Bookings')}}</h1>
@stop

@php

@endphp

@section('plugins.Datatables', true)

@section('content')
    <script>
        function showOrHideDiv(){
            document.getElementById('startCity').value="";
            document.getElementById('endingCity').value="";
            document.getElementById('city').value="";
            if(document.getElementById('bookingType_id').value==='1'){
                document.getElementById('simple').style.display="block";
                document.getElementById('roundTrip').style.display="none";
            }
            else if(document.getElementById('bookingType_id').value==='2'){
                document.getElementById('simple').style.display="none";
                document.getElementById('roundTrip').style.display="block";
            }
            else{
                document.getElementById('simple').style.display="none";
                document.getElementById('roundTrip').style.display="none";
            }
        }
        function limitMinDate(){
            document.getElementById('endingDate').value=null;
            document.getElementById('endingDate').disabled=false;
            document.getElementById('endingDate').min=document.getElementById('startDate').value;
        }
    </script>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Créer une réservation</h3>
                </div>
                <strong style="color: red">{{$error}}</strong>
                <form method="POST" action="{{route("booking.store")}}">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="startDate">Date de réservation</label>
                            <input type="date" class="form-control" name="startDate" id="startDate" onchange="limitMinDate()">
                        </div>
                        <div class="form-group">
                            <label for="endingDate">Date d'arrivée</label>
                            <input type="date" class="form-control" name="endingDate" id="endingDate" disabled>
                        </div>
                        <div class="form-group">
                            <label for="bookingType_id">Type de trajet</label>
                            <select name="bookingType_id" id="bookingType_id">
                                <option value="" onclick="showOrHideDiv()">-</option>
                                <option value="1" onclick="showOrHideDiv()">Simple</option>
                                <option value="2" onclick="showOrHideDiv()">Aller-retour</option>
                            </select>
                        </div>
                        <div class="form-group" id="roundTrip" style="display: none">
                            <label for="startCity">Point de départ</label>
                            <input type="text" class="form-control" name="startCity" id="startCity">
                            <label for="endingCity">Destination</label>
                            <input type="text" class="form-control" name="endingCity" id="endingCity">
                        </div>
                        <div class="form-group" id="simple" style="display: none">
                            <label for="city">Destination</label>
                            <input type="text" class="form-control" name="city" id="city">
                        </div>
                        <div class="form-group">
                            <label for="car_id">Voiture</label>
                            <select name="car_id" id="car_id">
                                <option value="">-</option>
                                @foreach($cars as $car)
                                    <option value="{{$car->id}}">{{$car->modele}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="customer_id">Conducteur</label>
                            <select name="customer_id" id="customer_id">
                                <option value="">-</option>
                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
