<?php

namespace App\Http\Controllers;

use App\Models\setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = setting::all();
        return view('admin.setting.index',compact('settings'),[
            'title' => 'Thiết lập'  
        ]);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
        ]);
    
        // Tạo bản ghi mới
        Setting::create([
            'key' => $request->key,
            'value' => $request->value,
        ]);
    
        return redirect()->back()->with('success', 'Thêm mới thành công!');
    }

    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
        ]);
    
        // Tìm bản ghi cần cập nhật
        $setting = Setting::find($id);
    
        if (!$setting) {
            return redirect()->back()->with('error', 'Bản ghi không tồn tại.');
        }
    
        // Cập nhật dữ liệu
        $setting->update([
            'key' => $request->key,
            'value' => $request->value,
        ]);
    
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }
    



    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request)
    // {
    //     // Xác thực dữ liệu
    //     $request->validate([
    //         'money' => 'required|numeric|min:0',
    //     ]);

    //     // Tìm bản ghi thiết lập với key là 'money'
    //     $setting = Setting::where('key', 'money')->first();

    //     if (!$setting) {
    //         // Nếu không tồn tại, tạo mới
    //         $setting = new Setting();
    //         $setting->key = 'money';
    //     }

    //     // Cập nhật giá trị
    //     $setting->value = $request->input('money');
    //     $setting->save();

    //     // Chuyển hướng về trang thiết lập với thông báo thành công
    //     return redirect()->route('settings.index')->with('success', 'Cập nhật phí đăng bài tuyển dụng thành công!');
    // }

}
