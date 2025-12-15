@extends('layout')
@section('title', 'กรรมการ')
@section('content')

    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('referees.create') }}">เพิ่มข้อมูล</a></button>
            </li>
        </ul>
    </div>
    <div>
        @if(session('success'))
            <div class ="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('failed'))
            <div class ="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
    </div>
    <div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>รหัสกรรมการ</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>รหัสประเทศ</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($referees as $ref)
                    <tr>
                        <td>{{ $ref->referee_id }}</td>
                        <td>{{ $ref->first_name }}</td>
                        <td>{{ $ref->last_name }}</td>
                        <td>{{ $ref->country_id }}</td>
                        <td>
                        <a href="{{ route('referees.edit',$ref->referee_id) }}"><button class="btn btn-warning" >แก้ไข</button>

                        <form action="{{ route('referees.destroy',$ref->referee_id) }}" method="POST">
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
