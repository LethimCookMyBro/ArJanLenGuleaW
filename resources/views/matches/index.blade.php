@extends('layout')
@section('title', 'ตารางแข่งขัน')
@section('content')

    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('matches.create') }}">เพิ่มข้อมูล</a></button>
            </li>
        </ul>
    </div>
    <div>
        @if (session('success'))
            <div class ="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('failed'))
            <div class ="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
    <div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>รหัสแมทช์</th>
                    <th>รหัสสนาม</th>
                    <th>ทีม1</th>
                    <th>ทีม2</th>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>สถานะ</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($matches as $match)
                    <tr>
                        <td>{{ $match->match_id }}</td>
                        <td>{{ $match->stadium_id }}</td>
                        <td>{{ $match->team1_id }}</td>
                        <td>{{ $match->team2_id }}</td>
                        <td>{{ $match->match_date }}</td>
                        <td>{{ $match->match_time }}</td>
                        <td>{{ $match->stage }}</td>
                        <td>
                        <a href="{{ route('matches.edit',$match->match_id) }}"><button class="btn btn-warning" >แก้ไข</button>
                       
                        <form action="{{ route('matches.destroy',$match->match_id) }}" method="POST">
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
