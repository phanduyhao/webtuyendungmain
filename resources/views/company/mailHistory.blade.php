@extends('layout.layout')

@section('content')
<section class="section-hero overlay inner-page bg-image" style="background-image: url('/temp/assets/images/hero_1.jpg');" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-white font-weight-bold">Lịch sử gửi mail</h1>
                <div class="custom-breadcrumbs">
                    <a href="/">Trang chủ</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong>Lịch sử gửi mail</strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="site-section">
    <div class="container">
        <table class="table text-dark table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Người ứng tuyển</th>
                    <th>Email</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Ngày gửi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mails as $mail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{$mail->User->name}}
                        </td>
                        <td>
                            {{$mail->User->email}}
                        </td>
                        <td>{{ $mail->title }}</td>
                        <td>{{ $mail->mail_content }}</td>
                        <td>{{ $mail->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>
</section>
@endsection
