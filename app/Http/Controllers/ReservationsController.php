<?php

namespace App\Http\Controllers;

use App\reservations;
use Illuminate\Http\Request;
use App\Notifications\Reservation;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /**
         * Deberiamos validar mas a fondo los datos que se ingresan como si el email realmente es un mail y el telefono.
         * Tambien disparar un email para que el cliente tenga un feedback y de reservacion
         */

        $fields = array();
        foreach ($request->all() as $key => $value) {
            $fields[$key] = $value;
        }
        try {

            $data = reservations::insertGetId($fields);
            $data = reservations::find($data);
            $data->notify(new Reservation($data));
            $response = array(
                'status' => 'success',
                'msg' => 'Insertado',
                'data' => $data,
                'code' => 0
            );
            return response()->json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => 'fail',
                'code' => 5,
                'error' => $e->getMessage()
            );
            return response()->json($response);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {

            /**
             * Deberiamos limitar por tiempo o numero de peticiones, o un captacha para evitar llamadas de robot o consumo
             * excesivo de las peticiones
             */
            
            $limit = ($request->limit) ? $request->limit : 15;
            $last_name = $request->last_name;

            if(!$id){
                return response()->json([
                 'msg' => 'ID no valido'
                ],404); 
             }

            if(!$last_name){
                return response()->json([
                 'msg' => 'Apellido no valido'
                ],404); 
             }
             

            $data = reservations::orderBy('reservations.id', 'DESC')
                ->join('available_trips','reservations.available_trip_id','=','available_trips.id')
                ->join('available_zones as _o','available_trips.origin_available_zone_id','=','_o.id')
                ->join('available_zones as _d','available_trips.destination_available_zone_id','=','_d.id')
                ->where('reservations.id',$id)
                ->where('reservations.last_name',$last_name)
                ->select('reservations.*',
                'available_trips.inbound_date as inbound_date',
                'available_trips.outbound_date as outbound_date',
                '_o.contry_name as origin_contry',
                '_d.contry_name as destination_contry'
                )
                ->paginate($limit);

            $response = array(
                'status' => 'success',
                'data' => $data,
                'code' => 0
            );
            return response()->json($response);

        } catch (\Exception $e) {

            $response = array(
                'status' => 'fail',
                'msg' => $e->getMessage(),
                'code' => 1
            );

            return response()->json($response, 500);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $fields = array();
            foreach ($request->all() as $key => $value) {
                if ($key !== 'id') {
                    $fields[$key] = $value;
                };
            }

            reservations::where('id', $id)
                ->update($fields);

            $data = reservations::find($id);


            $response = array(
                'status' => 'success',
                'msg' => 'Actualizado',
                'data' => $data,
                'code' => 0
            );
            return response()->json($response);


        } catch (\Exception $e) {

            $response = array(
                'status' => 'fail',
                'msg' => $e->getMessage(),
                'code' => 1
            );

            return response()->json($response, 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {

            reservations::where('id', $id)
                ->delete();

            $response = array(
                'status' => 'success',
                'msg' => 'Eliminado',
                'code' => 0
            );
            return response()->json($response);


        } catch (\Exception $e) {

            $response = array(
                'status' => 'fail',
                'msg' => $e->getMessage(),
                'code' => 1
            );

            return response()->json($response, 500);

        }
    }
}