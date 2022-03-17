<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(){
    }

    /**
     * @param Request $request
     * @param $id
     * @return void
     */
    public function storeV2(Request $request, $id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error" => "Người dùng không tồn tại"]);
        }
        $request->validate([
            'url' => "required",
        ]);
        $image_name = time() . '-url-'.basename($request->url);
        $dir_upload = 'storage/avatars/'.$image_name;
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $request->url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTP_CONTENT_DECODING, false);
        $source = curl_exec( $ch );
        $info = curl_getinfo($ch);
        curl_close( $ch );
        file_put_contents( $dir_upload, $source );
        $filePath = 'public/avatars/'. $find->avatar;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        $update_url = $find->update([
            "avatar" => $image_name,
            "url" => $request->url,
        ]);
        if ($update_url){
            return redirect()->route('user.index')->with("success","Cập nhật Người dùng thành công");
        }
        return back()->withErrors(["error"=>"Cập nhật Người dùng thất bại"]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function updateV2($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Người dùng không tồn tại"]);
        }
        return view("users.updateV2",["id"=>$id, "user"=>$find]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request,$id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Người dùng không tồn tại"]);
        }
        // $request->validate([
        //     'avatar' => 'mimes:png,svg,gif,jpg,jpeg|max:15360|image',
        // ]);
        if (Auth::user()->role_id==1){
            $data_update = [
                'username' => empty($request->username)? $find->username : $request->username,
                'password' => empty($request->password)? $find->password : Hash::make($request->password),
                'full_name' => empty($request->full_name)? $find->full_name : $request->full_name,
                'email' => empty($request->email)? $find->email : $request->email,
                'phone' => empty($request->phone)? $find->phone : $request->phone,
                'is_active' => $request->is_active,
            ];
            }
            else {
                 $data_update = [
                'username' =>  $find->username ,
                'password' => empty($request->password)? $find->password : Hash::make($request->password),
                'full_name' => $find->full_name ,
                'email' => empty($request->email)? $find->email : $request->email,
                'phone' => empty($request->phone)? $find->phone : $request->phone,
                'is_active' => $request->is_active,
            ];
            }
        // if ($request->hasFile('avatar')) {
            $filePath = 'public/avatars/';
            // if (Storage::exists($filePath)) {
            //     Storage::delete($filePath);
            // }
           // $avatar = $request->file('avatar');
          //  $file_name = time().'_image_' . $avatar->getClientOriginalName();

           // move($filePath,$file_name);
           // $avatar->storeAs('public/avatars', $file_name, 'local');
            $data_update['avatar'] = $find->avatar;

        //}

        $update = $find->update($data_update);
        if ($update){
            return redirect()->route('user.index')->with("success","Cập nhật Người dùng thành công");
        }
        return back()->withErrors(["error"=>"Cập nhật Người dùng thất bại"]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Người dùng không tồn tại"]);
        }
        return view("users.update",['user' => $find]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function detail(Request $request,$id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"Id phải là số"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Người dùng không tồn tại"]);
        }
        $comments = Comment::where("user_id1",$id)->get();
        $com = "";
        if (isset($_GET['comment_id'])){
            if (!is_numeric($request->comment_id)) {
                return back()->withErrors(["error"=>"Comment Id phải là số"]);
            }
            $com = Comment::findOrFail($request->comment_id);
        }
        $owenr = User::find($find->owenr_id);
        return view("users.detail",['user' => $find,"owenr" => $owenr, "comments" => $comments, "com" => $com]);
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
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Người dùng không tồn tại"]);
        }
        $filePath = 'public/avatars/'. $find->avatar;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        if ($find->delete()){
            return redirect()->route('user.index')->with("success","Xóa Người dùng thành công");
        }
        return back()->withErrors(["error"=>"Xóa Người dùng thất bại"]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $users = User::all();
        return view("users.index", ["users" => $users]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request){
        if (Auth::user()->role_id!=1){
            return back()->withErrors(["error"=>"Không phải là Giảng viên"]);
        }
        $validate = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'full_name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'avatar' => 'mimes:png,svg,gif,jpg,jpeg|max:15360|image',
        ]);
        $data_create = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'owenr_id' => Auth::id(),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active,
        ];

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $file_name = time().'_image_' . $avatar->getClientOriginalName();
            $avatar->storeAs('public/avatars', $file_name, 'local');
            $data_create['avatar'] = $file_name;
        }

        $register = User::create($data_create);
        if ($register){
            return redirect()->route('user.index')->with("success","Thêm mới Người dùng thành công");
        }
        return back()->withErrors(["error"=>"Thêm mới Người dùng thất bại"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'error' => 'Username hoặc Password không đúng',
            ]);
        }
        $request->session()->regenerate();
        return redirect()->route('home');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function me(){
        return Auth::user();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with("success","Đăng xuất thành công");
    }
}
