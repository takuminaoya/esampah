<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

class ProfilController extends Controller
{
    
    public function index()
    {
        if(Auth::user()->level == false){
            $user = User::where('id',Auth::id())->first();
        }else{
            $user = Pegawai::where('id',Auth::id())->first();
        }
        
        return view('profil.index',compact('user'));
    }

    public function editpass(Request $request){
        $user_id = Auth::id();
        if(Auth::user()->level == false){
             $password = User::where('id',$user_id)->value('password');
        }else{
            $password = Pegawai::where('id',$user_id)->value('password');
        }

        $request->validate([
            'password_baru'=>'required|min:3|max:255',
            'password_lama'=>'required|min:3|max:255',
            'konfirmasi'=>'required||min:3|max:255',
        ]);
        
        if(password_verify($request->password_lama, $password) && 
        $request->password_baru == $request->konfirmasi){
            if(Auth::user()->level == false){
                User::where('id',$user_id)->update([
                    'password'=>bcrypt($request->password_baru)
                ]);
            }else{
                Pegawai::where('id',$user_id)->update([
                    'password'=>bcrypt($request->password_baru)
                ]);
            }
        }else{
            return redirect()->back()
            ->with('status','error')
            ->with('message','Password gagal diubah');
        }
        return redirect()->back()
            ->with('status','success')
            ->with('message','Password berhasil diubah');
    }
}
