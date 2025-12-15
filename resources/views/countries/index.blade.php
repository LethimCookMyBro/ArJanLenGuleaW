@extends('layout')
@section('title', 'ตารางประเทศ')
@section('content')

    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('countries.create') }}">เพิ่มข้อมูล</a></button>
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
                    <th>รหัสประเทศ</th>
                    <th>ชื่ออประเทศ</th>
                    <th>ทวีป</th>
                    <th>อันดับฟีฟ่า</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($countries as $co)
                    <tr>
                        <td>{{ $co->country_id }}</td>
                        <td>{{ $co->country_name }}</td>
                        <td>{{ $co->continent }}</td>
                        <td>{{ $co->fifa_ranking }}</td>
                        <td>
                        <a href="{{ route('countries.edit',$co->country_id) }}"><button class="btn btn-warning">แก้ไข</button>

                        <form action="{{ route('countries.destroy',$co->country_id) }}" method="POST">
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
