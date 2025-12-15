@extends('layout')
@section('title', 'ตรารางกรรมการกับเกม')
@section('content')

    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('matchreferees.create') }}">เพิ่มข้อมูล</a></button>
            </li>
        </ul>
    </div>
    <div>
        @if(@session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(@session('failed'))
            <div class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
    </div>
    <div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>รหัสผู้ตัดสินแมทช์</th>
                    <th>รหัสแมทช์</th>
                    <th>รหัสผู้ตัดสิน</th>
                    <th>หน้าที่</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($matchreferees as $mrefer)
                    <tr>
                        <td>{{ $mrefer->match_referee_id }}</td>
                        <td>{{ $mrefer->match_id }}</td>
                        <td>{{ $mrefer->referee_id }}</td>
                        <td>{{ $mrefer->role }}</td>
                        <td>
                        <a href="{{ route('matchreferees.edit',$mrefer->match_referee_id) }}"><button class="btn btn-warning" >แก้ไข</button>

                        <form action="{{ route('matchreferees.destroy',$mrefer->match_referee_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
    
                    </tr>
                    @endforeach             
            </tbody>
        </table>
    </div>
@endsection
