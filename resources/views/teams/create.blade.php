@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    <form action=" {{ route('teams.store'); }} " method="POST">
        @csrf
        @method('POST')

       <table class="table-bordered">         
            <tr>
                <td>
                    <strong>รหัสทีม:</strong>
                </td>
                <td>
                    <input type="text" name="team_id" class="form-control" placeholder="รหัสทีม">
                </td>
            </tr>
             <tr>
                <td>
                    <strong>รหัสประเทศ:</strong>
                </td>

                <td>
                    <select name="country_id">
                        @foreach ($countries as $co)
                            <option value="{{ $co->country_id }}">{{  $co->country_id }}&nbsp;&nbsp;{{ $co->country_name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
             <tr>
                <td>
                    <strong>ชื่อโค้ช:</strong>
                </td>
                <td>
                    <input type="text"  name="coach_name"  class="form-control"placeholder="ชื่อโค้ช">
                </td>
            </tr>
            <tr>
                 <tr>
                <td>
                    <strong>กลุ่ม:</strong>
                </td>
                <td>
                    <input type="text"  name="group_name" class="form-control"placeholder="ชื่อกลุ่ม">
                </td>
            </tr>
            <tr>
                <td>
                    <div class="card-footer ml-auto mr-auto" align=center>
                        <a href="{{ route('teams.index') }} " class="btn btn-danger">ยกเลิก</a>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

@endsection
