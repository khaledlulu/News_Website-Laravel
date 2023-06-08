<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = admin::with('user')->orderBy('id', 'asc')->Paginate(10);
        return response()->view('cms.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return response()->view('cms.admin.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobil' => 'required',
            'birth_date' => 'required',
            'image' => 'required',
        ], []);

        if (!$validator->fails()) {

            $admins = new admin();
            $admins->email = $request->get('email');
            $admins->password = Hash::make($request->get('password'));

            $isSaved = $admins->save();

            return ['redirect' => route('admins.index')];

            if ($isSaved) {
                $users = new User();
                if (request()->hasFile('image')) {

                    $image = $request->file('image');;
                    $imageName = time() . 'image.' . $image->getClientOriginalExtension();
                    $image->move('images/admins', $imageName);
                    $users->image = $imageName;
                }

                $users->first_name = $request->get('first_name');
                $users->last_name = $request->get('last_name');
                $users->mobil = $request->get(' mobil');
                $users->status = $request->get('status');
                $users->gender = $request->get('gender');
                $users->birth_date = $request->get('birth_date');
                $users->country_id = $request->get('country_id');
                $users->actor()->associate($admins);
                $isSaved = $users->save();
                return response()->json(['icon' => 'success', 'title' => 'Crated is successfully'], 200);
            } else {
                return response()->json(['icon' => 'error', 'title' => 'Crated is falid'], 400);
            }
        } else {
            return response()->json([
                'icon' => 'error', 'title' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries = Country::all();
        $admins = admin::with('user')->findOrFail($id);
        return response()->view('cms.admin.edit', compact('countries', 'admins'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}