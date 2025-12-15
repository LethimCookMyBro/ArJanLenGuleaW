@extends('layout')
@section('title', 'ตารางการทำประตู')
@section('content')


    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('goals.create') }}">เพิ่มข้อมูล</a></button>
            </li>
        </ul>
    </div>
    <div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('failed'))
                <div class="alert alert-danger">
                    {{ session('failed') }}
                </div>
            @endif
        </div>
    <div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>รหัสทำประตู</th>
                    <th>รหัสแมทช์</th>
                    <th>รหัสนักเตะ</th>
                    <th>เวลา</th>
                    <th>ลูกโทษ</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($goals as $go)
                    <tr>                   
                        <td>{{ $go->goal_id }}</td>
                        <td>{{ $go->match_id }}</td>
                        <td>{{ $go->player_id }}</td>
                         <td>{{ $go->goal_time }}</td>
                        <td>{{ $go->is_penalty }}</td>
                        <td>
                        <a href="{{ route('goals.edit',$go->goal_id) }}"><button class="btn btn-warning" >แก้ไข</button>

                        <form action="{{ route('goals.destroy',$go->goal_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                        </td>
                        
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
@endsection
