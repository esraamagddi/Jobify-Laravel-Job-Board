<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Exceptions\Handler;
use App\Http\Helpers\UploadImages;
use Exception;



class AdminController extends Controller
{
    private $uploader;
    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
        $this->uploader = new UploadImages();
    }

    public function index()
    {
        //
        return UserResource::collection(User::paginate(5));    
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(StoreAdminRequest $request)
        {

            try{
                // dd($request->role);
            
            $admin = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role'=>$request->role,
                    'profile_photo_path'=>$this->uploader->file_operations($request,'image','admins'),
                ]);
                return new UserResource($admin);
            }
            catch (Exception $e) {
                return $this->handler->render($request, $e);
            }
        }

    


    /**
     * Display the specified resource.
     */
    public function show(Request $request,User $admin)
    {
            return new UserResource($admin);
    }


    /**
     * Update the specified resource in storage.
     */
    
 public function update(UpdateAdminRequest $request, $id)
    {
        try {
            $admin = User::findOrFail($id);
        
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->role = $request->input('role');

            if ($request->has('password')) {
               $admin->password = bcrypt($request->input('password'));
           }
        
         $admin->save();
        
        return response()->json(['message' => 'Admin updated successfully', 'admin' => new UserResource($admin)], 200);
         } 
        catch (Exception $e) {
            return response()->json(['error' => 'Admin not found'], 404);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

            $admin = User::findOrFail($id);
            $admin->delete();
            return response()->json(['message' => 'Admin deleted successfully']);   
    }
}
