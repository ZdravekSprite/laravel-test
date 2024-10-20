<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render('User/Index', [
      'users' => User::all()->toArray(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = $request->email;
    $user->save();
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    $user = User::findOrFail($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    $request->validate([
      'password' => ['required', 'current-password'],
    ]);
    $user = User::findOrFail($request->id);;
    $user->delete();
  }
}
