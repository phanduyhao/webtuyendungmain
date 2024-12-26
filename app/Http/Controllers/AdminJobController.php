<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminJobController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 20;
    
        // Tạo query cơ bản để lấy các công việc chưa bị xóa
        $query = Job::query();
    
        // Kiểm tra điều kiện tìm kiếm theo từng trường
        if ($request->filled('search_poster')) {
            $query->whereHas('User', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_poster . '%');
            });
        }
        
        if ($request->filled('search_company')) {
            $query->whereHas('Company', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_company . '%');
            });
        }
        
        if ($request->filled('search_title')) {
            $query->where('title', 'LIKE', '%' . $request->search_title . '%');
        }
        
        if ($request->filled('search_position')) {
            $query->where('position', 'LIKE', '%' . $request->search_position . '%');
        }
        
        if ($request->filled('search_location')) {
            $query->where('location', 'LIKE', '%' . $request->search_location . '%');
        }
        
        if ($request->filled('search_type')) {
            $query->where('type', 'LIKE', '%' . $request->search_type . '%');
        }
        
        if ($request->filled('search_salary')) {
            $query->where('salary', 'LIKE', '%' . $request->search_salary . '%');
        }
    
        // Lấy danh sách công việc với phân trang và giữ các tham số tìm kiếm trong liên kết phân trang
        $Jobs = $query->orderByDesc('id')->where('status',true)->paginate($perPage)->appends($request->all());
    
        return view('admin.Job.index', compact('Jobs'), [
            'title' => 'Công việc đã duyệt'
        ]);
    }

    public function loading(Request $request)
    {
        $perPage = 20;
    
        // Tạo query cơ bản để lấy các công việc chưa bị xóa
        $query = Job::query();
    
        // Kiểm tra điều kiện tìm kiếm theo từng trường
        if ($request->filled('search_poster')) {
            $query->whereHas('User', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_poster . '%');
            });
        }
        
        if ($request->filled('search_company')) {
            $query->whereHas('Company', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_company . '%');
            });
        }
        
        if ($request->filled('search_title')) {
            $query->where('title', 'LIKE', '%' . $request->search_title . '%');
        }
        
        if ($request->filled('search_position')) {
            $query->where('position', 'LIKE', '%' . $request->search_position . '%');
        }
        
        if ($request->filled('search_location')) {
            $query->where('location', 'LIKE', '%' . $request->search_location . '%');
        }
        
        if ($request->filled('search_type')) {
            $query->where('type', 'LIKE', '%' . $request->search_type . '%');
        }
        
        if ($request->filled('search_salary')) {
            $query->where('salary', 'LIKE', '%' . $request->search_salary . '%');
        }
    
        // Lấy danh sách công việc với phân trang và giữ các tham số tìm kiếm trong liên kết phân trang
        $Jobs = $query->orderByDesc('id')->where('status',null)->paginate($perPage)->appends($request->all());
    
        return view('admin.Job.loading', compact('Jobs'), [
            'title' => 'Công việc đang chờ duyệt'
        ]);
    }

    public function canceled(Request $request)
    {
        $perPage = 20;
    
        // Tạo query cơ bản để lấy các công việc chưa bị xóa
        $query = Job::query();
    
        // Kiểm tra điều kiện tìm kiếm theo từng trường
        if ($request->filled('search_poster')) {
            $query->whereHas('User', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_poster . '%');
            });
        }
        
        if ($request->filled('search_company')) {
            $query->whereHas('Company', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_company . '%');
            });
        }
        
        if ($request->filled('search_title')) {
            $query->where('title', 'LIKE', '%' . $request->search_title . '%');
        }
        
        if ($request->filled('search_position')) {
            $query->where('position', 'LIKE', '%' . $request->search_position . '%');
        }
        
        if ($request->filled('search_location')) {
            $query->where('location', 'LIKE', '%' . $request->search_location . '%');
        }
        
        if ($request->filled('search_type')) {
            $query->where('type', 'LIKE', '%' . $request->search_type . '%');
        }
        
        if ($request->filled('search_salary')) {
            $query->where('salary', 'LIKE', '%' . $request->search_salary . '%');
        }
    
        // Lấy danh sách công việc với phân trang và giữ các tham số tìm kiếm trong liên kết phân trang
        $Jobs = $query->orderByDesc('id')->where('status',false)->paginate($perPage)->appends($request->all());
    
        return view('admin.Job.canceled', compact('Jobs'), [
            'title' => 'Công việc đã hủy'
        ]);
    }

    public function approve(Request $request, $id)
    {
        // Tìm công việc theo ID
        $job = Job::find($id);

        if (!$job) {
            return redirect()->back()->with('error', 'Công việc không tồn tại.');
        }

        // Cập nhật trạng thái công việc
        $job->status = true; // Duyệt
        $job->save();

        return redirect()->back()->with('success', 'Công việc đã được duyệt thành công.');
    }

    public function cancel(Request $request, $id)
    {
        // Tìm công việc theo ID
        $job = Job::find($id);
    
        if (!$job) {
            return redirect()->back()->with('error', 'Công việc không tồn tại.');
        }
    
        // Cập nhật trạng thái công việc
        $job->status = false; // Hủy
        $job->save();
    
        return redirect()->back()->with('success', 'Công việc đã bị hủy.');
    }
    
    // public function jobDetailForAdmin($slug)
    // {

    //     // Tìm job theo slug
    //     $job = Job::where('slug', $slug)->first();

    //     // Kiểm tra nếu không tìm thấy job
    //     if (!$job) {
    //         return redirect()->back()->with('error', 'Job not found!');
    //     }
    
    //     $user = null;
    //     $company = null;
    
    //     if ($job->user_id != null) {
    //         $user = User::find($job->user_id);
    
    //         // Kiểm tra nếu tìm thấy user, lấy company tương ứng
    //         if ($user) {
    //             $company = Company::where('user_id', $user->id)->first();
    //         }
    //     }
    
    //     $hasApplyJob = Application::where('user_id', Auth::id())
    //         ->where('job_id', $job->id)
    //         ->first();
    //     $job_referencts = Job::Where('Hide','!=',true)->orWhereNull('Hide')->where('job_categories_id',$job->job_categories_id)->take(6)->get();
    //     return view('job.jobDetail', compact('job', 'user', 'company', 'hasApplyJob', 'favourite','job_referencts'), [
    //         'title' => $job->title
    //     ]);
    // }
}
