@extends('layout')
@section('title', 'นักกีฬา')
@section('content')

    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('players.create') }}">เพิ่มข้อมูล</a></button>
            </li>
        </ul>
    </div>
    <div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('failed'))
            <div class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
    </div>
    <div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>รหัสนักเตะ</th>
                    <th>รหัสทีม</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>ตำแหน่ง</th>
                    <th>เลขเสื้อ</th>
                    <th>วันเกิด</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($players as $player)
                    <tr>
                        <td>{{ $player->player_id}}</td>
                        <td>{{ $player->team_id }}</td>
                        <td>{{ $player->first_name }}</td>
                        <td>{{ $player->last_name}}</td>
                        <td>{{ $player->position }}</td>
                        <td>{{ $player->jersey_number }}</td>
                        <td>{{ $player->date_of_birth }}</td>
                        <td>
                        <a href="{{ route('players.edit',$player->player_id) }}"><button class="btn btn-warning" >แก้ไข</button>

                        <form action="{{ route('players.destroy',$player->player_id) }}" method="POST">
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
