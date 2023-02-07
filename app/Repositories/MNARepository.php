<?php

namespace App\Repositories;

use App\Http\Resources\MNA\MNAResource;
use App\Http\Resources\MNA\MNACollection;
use App\Repositories\Interfaces\MNAInterface;
use App\Events\MNA\NewMNACreatedEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MNA;
use Carbon\Carbon;

class MNARepository implements MNAInterface
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\MNA\MNACollection
     */
    public function index(Request $request)
    {
        // save request details in variables
        $keywords = $request->keywords;
        $request->from_date? 
            $from_date = $request->from_date."T00:00:00.000Z": 
            $from_date = Carbon::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00');
        $request->to_date? 
            $to_date = $request->to_date."T23:59:59.000Z": 
            $to_date = Carbon::now();

        // fetch MNAs from db using filters when they are available in the request
        $mnas = MNA::when($keywords, function ($query, $keywords) {
                                        return $query->where("name", "like", "%{$keywords}%");
                                    })
                                    ->when($from_date, function ($query, $from_date) {
                                        return $query->whereDate('created_at', '>=', $from_date );
                                    })
                                    ->when($to_date, function ($query, $to_date) {
                                        return $query->whereDate('created_at', '<=', $to_date );
                                    })
                                    ->latest();

        // if client asks that the result be paginated
        if ($request->filled('paginate') && $request->paginate) {
            return new MNACollection($mnas->paginate($request->paginate_per_page)->withPath('/'));
        }

        // return collection
        return new MNACollection($mnas->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\MNA\MNAResource
     */
    public function store(Request $request)
    {
        // persist request details then store in a variable
        $mna = MNA::create($request->all());

        // call event that a new Mini Nutritional Assessment has been created
        event(new NewMNACreatedEvent($request, $mna));

        // return resource
        return new MNAResource($mna);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Resources\MNA\MNAResource
     */
    public function show($id)
    {
        // return resource
        return new MNAResource(MNA::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Resources\MNA\MNAResource
     */
    public function update(Request $request, $id)
    {
        // find the instance
        $mna = $this->getMNAById($id);

        // remove or filter null values from the request data then update the instance
        $mna->update(array_filter($request->all()));

        // return resource
        return new MNAResource($mna);
    }

    /**
     * find a specific MNA using ID.
     *
     * @param  int  $id
     * @return \App\Models\MNA
     */
    public function getMNAById($id)
    {
        // find and return the instance
        return MNA::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        // softdelete instance
        $this->getMNAById($id)->delete();
    }
}
