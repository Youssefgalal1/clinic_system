<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\Controller;
use App\Http\Policies\UserPolicy;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\apiResponse;

class UserController extends Controller
{
    use apiResponse;
    public function testRequest(Request $request){
        return response()->json(['data'=>$request-> header()]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $this->authorize('viewAny', User::class);
       $query = User::query();
       if($request->filled('role')){
        $query->where('role',$request->query('role'));
       }
       if($request->filled('search')){
        $query->where('name','like','%'.$request->query('search').'%');
       }
       if($request->filled('sort')){
        $query->orderBy($request->query('sort') ?? 'id');
       }
       $users = $query->paginate(10);
       return $this->apiResponse(UserResource::collection($users), 'data retrived successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request , User $user)
    {
        $this->authorize('view', $user);
        //
        return $this->apiResponse(new UserResource($user), 'user retrived successfuly');
        // return $request->user(); by token sent in header
        // return response()->json(['message'=>'user retrived successfuly', 'data'=>$user]);
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create',User::class);
        //vlaidate the data
       $validated = $request->validated(); 
        // hashing password
        $validated['password'] = Hash::make($validated['password']);
        //store the data
        $data = User::create($validated);
        return $this->apiResponse(new UserResource($data), 'data stored successfuly');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        //vlaidate date
        $validated = $request->validated(); 
        // hashing password
        $validated['password'] = $request->has('password') ? bcrypt($request->password) : $validated->password ;
        //update data
        $user->update($validated);
        //redirect to index
        return $this->apiResponse(new UserResource($user), 'data updated successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('delete', $user);

        $user->delete();

        return $this->apiResponse(null, 'data deleted successfully');
    }
}
