<?php

namespace App\Http\Controllers;

use App\Models\Video;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PageController extends Controller
{
    public function uploadpage(){
        $data = Video::all();
        return view('upload.uploadpage',compact('data'));
    }
    public function uploadvideo(Request $request){

        $data = new Video();
        $file = $request->file;
        $filename = time(). '.' . $file->getClientOriginalExtension();
        $request->file->move('assets',$filename);
        $data->file = $filename;

      $data->save();
      return redirect('uploadpage')->with('success','تم رفع الفيديو بنجاح');
    }

    public function download(Request $request , $file){

        return response()->download(public_path('assets/'.$file));
    }
    public function view($id){
        $data = Video::find($id);
        return view('upload.view',compact('data'));


    }
    public function destroy(Request $request){


        $video = Video::findOrFail($request->id);
            $video->delete();
            session()->flash('delete', 'تم حذف الملف بنجاح');
            return back();

    }
}
