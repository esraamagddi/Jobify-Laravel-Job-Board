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
use App\Http\Helpers\CheckAdmin;
use Exception;



class AdminController extends Controller
{
    private $uploader;
    private $handler;
    private $checker;


    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
        $this->uploader = new UploadImages();
        $this->checker = new CheckAdmin();

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
                $file_path = $this->uploader->file_operations($request);
                $request_parms['profile_photo_path'] = $file_path;
                $request_parms['name'] = $request->name;
                $request_parms['email'] = $request->email;
                $request_parms['password'] = bcrypt($request->password);
                $request_parms['role'] = $request->role;
                $admin = User::create($request_parms);
                return new UserResource($admin);
            }
            catch (Exception $e) {
                return $this->handler->render($request, $e);
            }
        }

    


    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $admin)
    {

        $isAdmin= $this->checker->isAdmin($admin);
        
        if (!$isAdmin){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        else 
        {
            return new UserResource($admin);
        }
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
