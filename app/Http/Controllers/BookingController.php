<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('booking.index',["bookings"=>Booking::all(),"info"=>""]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('booking.create',["cars"=>Car::all(),"customers"=>Customer::all(),"error"=>""]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $booking=[
            'startDate'=>$request->input('startDate'),
            'endingDate'=>$request->input('endingDate'),
            'status'=>'en cours',
            'city'=>$request->input('city'),
            'startCity'=>$request->input('startCity'),
            'endingCity'=>$request->input('endingCity'),
            'customer_id'=>$request->input('customer_id'),
            'car_id'=>$request->input('car_id'),
            'bookingType_id'=>$request->input('bookingType_id'),
        ];
        if(Booking::create($booking)!=null){
            return view('booking.index',["bookings"=>Booking::all(),"info"=>"Réservation créée avec succès !"]);
        }
        else{
            return view('booking.create',["cars"=>Car::all(),"customers"=>Customer::all(),"error"=>"Problème lors de la création de la réservation."]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return view('booking.show',["booking"=>Booking::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        return view('booking.edit',["booking"=>Booking::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id)
    {
        $editStatut = [
            'status' => 'annulée',
        ];
        Booking::maj($id, $editStatut);
        return view('booking.index',["bookings"=>Booking::all(),"info"=>"Réservation annulée avec succès !"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {

    }
}
