@extends('layout')
@section('title', 'สนาม')
@section('content')

    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('stadiums.create') }}">เพิ่มข้อมูล</a></button>
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
                    <th>รหัสสนาม</th>
                    <th>ชื่อสนาม</th>
                    <th>เมือง</th>
                    <th>ความจุ</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($stadiums as $st)
                    <tr>                   
                        <td>{{ $st->stadium_id }}</td>
                        <td>{{ $st->stadium_name }}</td>
                        <td>{{ $st->city }}</td>
                        <td>{{ $st->capacity }}</td>
                        <td>
                        <a href="{{ route('stadiums.edit',$st->stadium_id) }}"><button class="btn btn-warning" >แก้ไข</button>

                        <form action="{{ route('stadiums.destroy',$st->stadium_id) }}" method="POST">
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
