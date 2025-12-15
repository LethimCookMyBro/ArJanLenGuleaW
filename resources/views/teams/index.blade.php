@extends('layout')
@section('title', 'ตารางทีม')
@section('content')

    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('teams.create') }}">เพิ่มข้อมูล</a></button>
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
                    <th>รหัสทีม</th>
                    <th>รหัสประเทศ</th>
                    <th>ชื่อโค้ช</th>
                    <th>ขื่อกลุ่ม</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($teams as $team)
                    <tr>                   
                        <td>{{ $team->team_id }}</td>
                        <td>{{ $team->country_id }}</td>
                        <td>{{ $team->coach_name }}</td>
                        <td>{{ $team->group_name }}</td>
                        <td>
                        <a href="{{ route('teams.edit',$team->team_id) }}"><button class="btn btn-warning" >แก้ไข</button>

                        <form action="{{ route('teams.destroy',$team->team_id) }}" method="POST">
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
