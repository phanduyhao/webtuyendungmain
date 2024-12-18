<?php

namespace App\Http\Controllers;

use App\Models\MailHistory;
use App\Models\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    public function updateNotifyStatus(Request $request)
    {
        $userId = $request->user_id;  // Lấy user_id từ request

        // Cập nhật tất cả các bản ghi trong bảng Notifies có user_id của Application
        $updatedCount = Notify::whereHas('Application', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->whereNull('status')->update(['status' => 1]);

        // Kiểm tra xem có bản ghi nào được cập nhật không
        if ($updatedCount > 0) {
            return response()->json(['success' => true, 'message' => 'Cập nhật thông báo thành công.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Không có thông báo nào cần cập nhật.']);
        }
    }

    public function mailHistoryCompany(){
        $mails = MailHistory::where('company_id',Auth::user()->id)->orderByDesc('id')->paginate(10);
        return view('company.mailHistory',compact('mails'),[
            'title' => 'Lịch sử gửi mail'
        ]);
    }
}
