<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profiles;

class ProfileController extends Controller
{
//以下を追記
 public function add(){
     return view('admin.profile.create');
     
 }
 public function create(Request $request){
     
    //以下を追記
    //Varidationを行う
    $this->validate($request, Profiles::$rules);
    
    $profiles = new Profiles;
    $form = $request->all();
    
    //フォームから送信されてきた_tokenを削除する
    unset($form['_token']);
    
    //データベースに保存する
    $profiles->fill($form);
    $profiles->save();
    
    return redirect('admin/profile/create');
     
     
 }
 public function edit(){
     return view('admin.profile.edit');
     
 }
 public function update(){
     return redirect('admin/profile/edit');
     
 }
}


