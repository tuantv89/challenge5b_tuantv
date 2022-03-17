<?php

namespace App\Http\Controllers;

use App\Models\Submit;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function __construct()
    {
    }

    public function detail($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = Test::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Test không tồn tại"]);
        }
        if (Auth::user()->role_id==1) {
            $submits = Submit::where('test_id',$id)->get();
        } else {
            $submits = Submit::where('user_id',Auth::id())->where('test_id',$id)->get();
        }
        return view('tests.detail',['test'=>$find, 'submits'=>$submits]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        if (Auth::user()->role_id!=1){
            return back()->withErrors(["error"=>"Không phải là Giảng viên"]);
        }
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = Test::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Test không tồn tại"]);
        }
        $filePath = 'public/tests/'.$find->name_test."/". $find->links;
        if (Storage::exists($filePath)) {
            Storage::deleteDirectory('public/tests/'.$find->name_test);
        }
        if ($find->delete()){
            return redirect()->route('test.index')->with("success","Xóa thành công");
        }
        return back()->withErrors(["error"=>"Xóa thất bại"]);
    }

    public function download($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = Test::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Test không tồn tại"]);
        }
        $filename = $find->links;
        $dir_download = 'public/tests/'.$find->name_test."/".$filename;
        if (Storage::exists($dir_download)) {
            return Storage::download($dir_download);
        }
        return back()->withErrors(['error' => "Không tồn tại file"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        if (Auth::user()->role_id!=1){
            return back()->withErrors(["error"=>"Không phải là Giảng viên"]);
        }
        $request->validate([
            'name_test' => 'required',
            'test' => 'required|file|max:15360',
        ]);
        $test_name = $request->file('test');
        $file_name = time().'_test_' . $test_name->getClientOriginalName();
        $test_name->storeAs('public/tests/'.$request->get('name_test')."/", $file_name, 'local');
        $data_create = [
            'name_test' => $request->get('name_test'),
            'links' => $file_name,
            'user_id' => Auth::id(),
            'username' => Auth::user()->username,
            'is_active' => $request->get('status'),
        ];
        $create = Test::create($data_create);
        if ($create){
            return redirect()->route('test.index')->with("success","Thêm thành công");
        }
        return back()->withErrors(["error"=>"Thêm thất bại"]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(){
        if (Auth::user()->role_id!=1){
            return back()->withErrors(["error"=>"Không phải là Giảng viên"]);
        }
        return view('tests.create');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $tests = Test::all();
        return view('tests.index',['tests'=> $tests]);
    }
}
