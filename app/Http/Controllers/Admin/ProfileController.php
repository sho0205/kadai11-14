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
 
//以下を追記
 public function index(Request $request){
     
    $cond_title = $request->cond_title;
    
    if($cond_title != ''){
       //検索されたら検索結果を取得する
       $posts = Profiles::where('title',$cond_title)->get();
    }else{
       //それ以外はすべてのニュースを取得する
       $posts = Profiles::all();
    }
    return view('admin.profile.index',['posts' => $posts, 'cond_title' => $cond_title]);
 }
 
//以下を追記
 public function edit(Request $request){
  
   //Profile Model からデータを取得する
    $profiles = Profiles::find($request->id);
    if(empty($profiles)){
     abort(404);
    }
    return view('admin.profile.edit',['profiles_form' => $profiles]);
 }
 
//以下を追記 
 public function update(Request $request){
  
   //Validationをかける
    $this->validate($request,Profiles::$rules);
    
   //Profiles Modelからデータを取得する
    $profiles = Profiles::find($request->id);
    
   //送信されてきたフォームデータを格納する
    $profiles_form = $request->all();
    
    unset($profiles_form['_token']);
    
    //該当するデータを上書きして保存する
    $profiles->fill($profiles_form)->save();
  
    return redirect('admin/profile/');
 }
 
//以下を追記
 public function delete(Request $request){
     
     //該当するProfiles Modelを取得する
     $profiles = Profiles::find($request->id);
     //削除する
     $profiles->delete();
     return redirect('admin/profile/');
     
 }
}


