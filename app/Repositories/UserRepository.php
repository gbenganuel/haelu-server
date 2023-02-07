<?php

namespace App\Repositories;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Repositories\Interfaces\UserInterface;
use App\Events\User\NewUserCreatedEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserRepository implements UserInterface
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\User\UserCollection
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

        // fetch Users from db using filters when they are available in the request
        $users = User::when($keywords, function ($query, $keywords) {
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
            return new UserCollection($users->paginate($request->paginate_per_page)->withPath('/'));
        }

        // return collection
        return new UserCollection($users->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\User\UserResource
     */
    public function store(Request $request)
    {
        // persist request details then store in a variable
        $user = User::create($request->all());

        // call event that a new Mini Nutritional Assessment has been created
        event(new NewUserCreatedEvent($request, $user));

        // return resource
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Resources\User\UserResource
     */
    public function show($id)
    {
        // return resource
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Resources\User\UserResource
     */
    public function update(Request $request, $id)
    {
        // find the instance
        $user = $this->getUserById($id);

        // remove or filter null values from the request data then update the instance
        $user->update(array_filter($request->all()));

        // return resource
        return new UserResource($user);
    }

    /**
     * find a specific User using ID.
     *
     * @param  int  $id
     * @return \App\Models\User
     */
    public function getUserById($id)
    {
        // find and return the instance
        return User::findOrFail($id);
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
        $this->getUserById($id)->delete();
    }
}
