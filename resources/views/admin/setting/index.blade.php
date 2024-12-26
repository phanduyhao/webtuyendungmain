@extends('admin.main')

@section('contents')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">Gói đăng bài</h3>

        <!-- Hiển thị thông báo thành công -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Hiển thị lỗi -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thời hạn ( Ngày )</th>
                    <th>Số tiền</th>
                    <th>Thao tác</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($settings as $setting)
                    <tr data-id="{{ $setting->id }}">
                        <form action="{{ route('settings.update', $setting->id) }}" method="POST">
                            @csrf
                        <td>{{ $loop->iteration }}</td>
                        <td class="">
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-dark" placeholder="VD: 30" name="key" value="{{ $setting->key ?? '' }}"> 
                                <span class="ms-2">Ngày</span>
                            </div>
                        </td>
                        <td class="">
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-dark" placeholder="VD: 40000" name="value" value="{{ $setting->value ?? '' }}">
                                <span class="ms-2"> VNĐ</span>
                            </td>
                        </div>
                        <td> 
                            
                                <button type="submit" class="text-dark fw-bold btn btn-info">Cập nhật</button>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </form>

                    </tr>
                @endforeach
                <tbody class="table-border-bottom-0 mt-5">
                    <tr class="">
                        <form action="{{ route('settings.store') }}" method="POST">
                            @csrf
                        <td></td>
                        <td class="">
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control" placeholder="VD: 30" name="key" value=""> 
                                <span class="ms-2">Ngày</span>
                            </div>
                        </td>
                        <td class="">
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control" placeholder="VD: 40000" name="value" value="">
                                <span class="ms-2"> VNĐ</span>
                            </td>
                        </div>
                        <td> 
                                <button type="submit" class="text-dark fw-bold btn btn-success">Thêm mới</button>
                            
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </form>

                    </tr>
                </tbody>
             
            </tbody>

        </table>
    </div>
@endsection
