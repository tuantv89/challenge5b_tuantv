<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChallengeController extends Controller
{

    public function answer(Request $request, $id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = Challenge::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Challenge không tồn tại"]);
        }
        $result="";
        $check = isset($_POST['submit']);
        $answer = $request->get('answer');
        if ($answer==$find->link || $answer.'.txt' == $find->link){
            $dir_download = 'public/challenges/'. $find['link'];
            $result = Storage::get($dir_download);
            $check=true;
        }
        else {
            $check=false;
        }
        return view('challenges.answer',['challenge' => $find,'answer' => $result,'check'=>$check]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = Challenge::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Challenge không tồn tại"]);
        }
        $filePath = 'public/challenges/'. $find->link;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        if ($find->delete()){
            return redirect()->route('challenge.index')->with("success","Xóa thành công");
        }
        return back()->withErrors(["error"=>"Xóa thất bại"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'suggest' => 'required',
            'challenge' => 'required|mimes:txt|file|max:15360',
        ]);

        $challenge_name = $request->file('challenge');
        $file_name = $challenge_name->getClientOriginalName();
        $challenge_name->storeAs('public/challenges/', $file_name, 'local');
        $data_create = [
            'user_id' => Auth::id(),
            'username' => Auth::user()->username,
            'title' => $request->get('title'),
            'suggest' => $request->get('suggest'),
            'link' => $file_name,
            'is_active' => 1,
        ];
        if (Challenge::create($data_create)){
            return redirect()->route('challenge.index')->with("success","Thêm thành công");
        }
        return back()->withErrors(["error"=>"Thêm thất bại"]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(){
        return view('challenges.create');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $challenges = Challenge::all();
        return view('challenges.index',['challenges' => $challenges]);
    }
}
