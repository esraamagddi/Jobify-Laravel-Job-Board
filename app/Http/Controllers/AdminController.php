<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Exceptions\Handler;
use App\Http\Helpers\UploadImages;
use App\Http\Helpers\CheckAdmin;
use App\Models\Employer;
use Exception;
use Illuminate\Support\Facades\Storage;


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
        return response()->json([
            'data' => UserResource::collection(User::where('role', 'admin')->paginate(5)),
            'count' => User::where('role', 'admin')->count()
            ]);
    }
    /**
     * Store a newly created resource in storage.
     */
        public function store(StoreAdminRequest $request)
        {
            if ($request->role == 'admin'){
                $isAdmin= $this->checker->isAdmin(Auth::user());
                if (!$isAdmin){
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            }

            try{
                $file_path = $this->uploader->file_operations($request);
                $request_params['profile_photo_path'] = $file_path;
                $request_params['name'] = $request->name;
                $request_params['email'] = $request->email;
                $request_params['password'] = bcrypt($request->password);
                $request_params['role'] = $request->role;
                $admin = User::create($request_params);
                return new UserResource($admin);
            }
            catch (Exception $e) {
                return $this->handler->render($request, $e);
            }
        }




    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $id)
    {
        try{
            //
            $admin = User::find($id);
            // dd($admin);
            if ($admin->role == 'admin'){
                $isAdmin= $this->checker->isAdmin(Auth::user());
                if (!$isAdmin){
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            }
            return new UserResource($admin);

        }
        catch (Exception $e) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

    }




    /**
     * Update the specified resource in storage.
     */

 public function update(UpdateAdminRequest $request, $id)
    {

        try {

            $admin = User::findOrFail($id);
            if ($admin->role == 'admin'){
                $isAdmin= $this->checker->isAdmin(Auth::user());
                if (!$isAdmin){
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            }

            $file_path = $this->uploader->file_operations($request);
            $request_params = $request->all();

            if ($file_path != null) {
                $request_params['profile_photo_path'] = $file_path;
                unset($request_params['image']);
            }
            if ($request->filled('password')) {
                $request_params['password'] = bcrypt($request->password);
            } else {
                $request_params['password'] = $admin->password;
            }
            $admin->update($request_params);
            return response()->json(['message' => 'Admin updated successfully', 'admin' => new UserResource($admin)], 200);
         }
        catch (Exception $e) {
            return $this->handler->render($request, $e);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);

        if ($admin->role == 'admin') {
            $isAdmin = $this->checker->isAdmin(Auth::user());
            if (!$isAdmin) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }

        if ($admin->profile_photo_path != null) {
            unlink(public_path('images/users/' . $admin->profile_photo_path));
            Storage::delete($admin->profile_photo_path);
        }

        $admin->delete();
        return response()->json(['message' => 'Admin deleted successfully']);
    }

    public function deactivate(string $id)
    {
        $isAdmin = $this->checker->isAdmin(Auth::user());
        if (!$isAdmin) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deactivated successfully', 'user' => $user]);
    }

    public function activate(string $id)
    {
        $isAdmin= $this->checker->isAdmin(Auth::user());
        if (!$isAdmin){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
            $user = User::withTrashed()->findOrFail($id);

            $user->restore();
            return response()->json(['message' => 'user activated successfully',$user]);

    }

    public function getAllUsers()
    {
        return response()->json([
            'data' => UserResource::collection(User::all()),
        ]);
    }
    public function updatePostStatus(Request $request, $id)
    {
        $jobPosting = Post::findOrFail($id);
        $newStatus = $request->getContent();
        $jobPosting->status = $newStatus;
        $jobPosting->save();
        return response()->json(['message' => 'Updated Successfully', 'job_posting' => $jobPosting]);
    }

    public function candidatesWithProfiles()
    {
        $candidates = User::where('role', 'candidate')->with('profile')->paginate(5);
        $candidateCount = User::where('role', 'candidate')->count();
            return response()->json([
            'data' => $candidates,
            'count' => $candidateCount,
        ]);
    }


        public function allEmployers()
        {
            $employers = User::where('role', 'employer')->with('employer')->paginate(5);
            $employerCount = User::where('role', 'employer')->count();

            return response()->json([
                'data' => $employers,
                'count' => $employerCount,
            ]);
        }

        public function trashed()
        {
            $trashedUsers = User::onlyTrashed()->with('employer', 'profile')->get();
            return response()->json($trashedUsers);
        }
    }




