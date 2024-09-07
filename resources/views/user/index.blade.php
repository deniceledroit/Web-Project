@extends('adminlte::page')

@section('title', '7Travel - Utilisateur')

@section('content_header')
    <h1 class="m-0 text-dark">Profil</h1>
@stop

@php

@endphp

@section('plugins.Datatables', true)

@section('content')
    <script>
        function onChangingPassword(){
            if(document.getElementById("password").value===document.getElementById("confirmPassword").value) {
                if(document.getElementById("password").value!==""){
                    document.getElementById("confirmButton").disabled=false;
                }
                else{
                    document.getElementById("confirmButton").disabled=true;
                }
            }
            else{
                document.getElementById("confirmButton").disabled=true;
            }
        }
    </script>
    <div class="row">
        <div class="col-12">
            <div class="card-body" style="display: grid">
                <p class="card-title">Prénom et Nom : {{ Auth::user()->name }}</p>
                <p class="card-title">Email : {{Auth::user()->email}}</p>
            </div>
            <form method="post" action="{{route("user.update",Auth::user()->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="city">Nouveau mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" oninput="onChangingPassword()">
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" oninput="onChangingPassword()">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="confirmButton" disabled>Modifier le mot de passe</button>
                </div>
            </form>
        </div>
    </div>
@stop
