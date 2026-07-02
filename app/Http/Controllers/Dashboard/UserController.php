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

class UserController extends Controller
{
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
       return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request , User $user)
    {
        $this->authorize('view', $user);
        //
        return new UserResource($user);
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
        return response()->json([
        'message'=>'data stored successfuly',    
        'user'=> new UserResource($data)]);
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
        return response()->json([
        'message'=>'data updated successfuly',    
        'data'=>new UserResource($user)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('delete', $user);

        $user->delete();

        return response()->json([
            'message' => 'data deleted successfully'
        ]);
    }
}
