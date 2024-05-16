<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\Handler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Employer;
use Illuminate\Http\Request;
use App\Http\Resources\EmployerResource;
use App\Http\Helpers\UploadImages;
use App\Http\Requests\StoreEmployerRequest;
use App\Http\Requests\UpdateEmployerRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;

class EmployerController extends Controller
{

    private $uploader;
    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
        $this->uploader = new UploadImages();
    }
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $validator = Validator::make($request->all(), [
            'per_page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $employers = Employer::paginate($perPage);
        return EmployerResource::collection($employers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployerRequest $request)
    {
        try{
            $user_data = $request->only(['name', 'email', 'password']);
            $user_data['role'] = 'employer';
            $user_data['profile_photo_path'] = $this->uploader->file_operations($request);
            $user = User::create($user_data);
            $user->save();
            //dd($user);
            $employer_data = $request->only(['industry', 'branches', 'branding_elements']);
            $employer_data['user_id'] = $user->id;
            $employer = Employer::create($employer_data);
            $employer->save();
            return new EmployerResource($employer);
        } catch (Exception $e) {
            return $this->handler->render($request, $e);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            $employer = Employer::where('user_id', $id)->with('posts')->first();

            if (!$employer) {
                throw new NotFoundHttpException('Employer not found');
            }

            return new EmployerResource($employer);
        } catch (Exception $e) {
            return $this->handler->render($request, $e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployerRequest $request, Employer $employer)
    {
        try{
            Gate::authorize('update', $employer);
            $user = $employer->user;
            $user->name = $request['name'] ?? $user->name;
            $user->email = $request['email'] ?? $user->email;
            $user->password = $request['password'] ?? $user->password;

            $user->profile_photo_path = $this->uploader->file_operations($request);
            $user->update();

            $employer->industry = $request['industry'] ?? $employer->industry;
            $employer->branding_elements = $request['branding_elements'] ?? $employer->branding_elements;
            $employer->branches = $request['branches'] ?? $employer->branches;

            $employer->update();

            return response()->json(["message" => 'Employer updated successfully','data'=> new EmployerResource($employer)]);
        } catch (\Exception $e) {
            return $this->handler->render($request, $e);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Employer $employer)
    {
        try{
            Gate::authorize('delete', $employer);
            $employer->delete();
            $employer->user->delete();
            return response()->json(["message" => 'employer deleted successfully']);
        } catch (Exception $e) {
            return $this->handler->render($request, $e);
        }
    }
}