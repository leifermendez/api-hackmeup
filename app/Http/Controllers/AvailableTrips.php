<?php

namespace App\Http\Controllers;

use App\availableTrip;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class AvailableTrips extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            /**
             * Este controlador deberia ser capaz de realacionar otras rutas para posteriormente
             * mostrar conexion de viajes, por ahora solo mostrara resultados en los cuales son directos 
             * todos
             *  */
            $origin_available_zone_id = $request->origin_available_zone_id;
            $destination_available_zone_id = $request->destination_available_zone_id;
            $inbound_date = $request->inbound_date;
            $outbound_date = $request->outbound_date;
            

            $limit = ($request->limit) ? $request->limit : 15;
            
            if(!$origin_available_zone_id){
               return response()->json([
                'msg' => 'Origen not valido'
               ],404); 
            }

            if(!$destination_available_zone_id){
                return response()->json([
                 'msg' => 'Destino not valido'
                ],404); 
             }
             
             if(!$inbound_date){
                return response()->json([
                 'msg' => 'Fecha inicio not valido'
                ],404); 
             }
             

             if(!$outbound_date){
                return response()->json([
                 'msg' => 'Fecha final not valido'
                ],404); 
             }
             
            $now = Carbon::now()->toDateTimeString();
            $inbound_date = Carbon::parse($inbound_date)->toDateTimeString();
            $outbound_date = Carbon::parse($outbound_date)->toDateTimeString();

            /**
             * Tomamos el numero de resultados default 15 o los que se indiquen en el parametro limit
             * Se deberia devolver la divisa de acuerdo al pais
             *  */
            $go_data = availableTrip::orderBy('available_trips.id', 'DESC')
                ->where('available_trips.origin_available_zone_id',$origin_available_zone_id)
                ->where('available_trips.destination_available_zone_id',$destination_available_zone_id)
                ->where('available_trips.inbound_date','>=',$inbound_date)
                ->where('available_trips.outbound_date','<=',$outbound_date)
                ->select('available_trips.*')
                ->take($limit)
                ->get();

            $go_data->map(function ($item) {
                $_start = Carbon::parse($item->inbound_date);
                $_finish = Carbon::parse($item->outbound_date);
                $item->diffTime = [
                    'hours' => $_start->diff($_finish)->format('%H'),
                    'minutes' => $_start->diff($_finish)->format('%I')
                ];
                return $item;
            });

            $back_data = availableTrip::orderBy('available_trips.id', 'DESC')
            ->where('available_trips.origin_available_zone_id',$destination_available_zone_id)
            ->where('available_trips.destination_available_zone_id',$origin_available_zone_id)
            ->where('available_trips.inbound_date','>=',$outbound_date)
            ->select('available_trips.*')
            ->take($limit)
            ->get();

            $back_data->map(function ($item) {
                $_start = Carbon::parse($item->inbound_date);
                $_finish = Carbon::parse($item->outbound_date);
                $item->diffTime = [
                    'hours' => $_start->diff($_finish)->format('%H'),
                    'minutes' => $_start->diff($_finish)->format('%I')
                ];
                return $item;
            });
                    
            $data = [
                'go_way' => $go_data,
                'back_way' => $back_data
            ];

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
        $fields = array();
        foreach ($request->all() as $key => $value) {
            $fields[$key] = $value;
        }
        try {

            $data = availableTrip::insertGetId($fields);
            $data = availableTrip::find($data);

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

            $data = availableTrip::find($id);
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

            availableTrip::where('id', $id)
                ->update($fields);

            $data = availableTrip::find($id);


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

            availableTrip::where('id', $id)
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