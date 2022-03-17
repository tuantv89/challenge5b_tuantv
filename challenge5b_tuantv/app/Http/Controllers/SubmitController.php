<?php

namespace App\Http\Controllers;

use App\Models\Submit;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmitController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request,$id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = Test::find($id);
        $request->validate([
            'sub' => 'required|file|max:15360',
        ]);
        $submit_name = $request->file('sub');
        $file_name = time().'_submit_' . $submit_name->getClientOriginalName();
        $submit_name->storeAs('public/tests/'.$find->name_test."/", $file_name, 'local');
        $data_create = [
            'user_id' => Auth::id(),
            'username' => Auth::user()->username,
            'test_id' => $find->id,
            'test_name' => $find->name_test,
            'link_submit' => $file_name,
            'is_active'=>1,
        ];
        $create = Submit::create($data_create);
        if ($create){
            return redirect()->route('test.detail',['id'=>$find->id])->with("success","Thêm thành công");
        }
        return back()->withErrors(["error"=>"Thêm thất bại"]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function download($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = Submit::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Bài nộp không tồn tại"]);
        }
        if (Auth::user()->role_id==1 || Auth::id()==$find->user_id){
            $filename = $find->link_submit;
            $dir_download = 'public/tests/'.$find->test_name."/".$filename;
            if (Storage::exists($dir_download)) {
                return Storage::download($dir_download);
            }
            return back()->withErrors(['error' => "Không tồn tại file"]);
        }
        return back()->withErrors(['error' => "Không đủ quyền"]);
    }
}
