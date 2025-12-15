@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    <form action=" {{ route('referees.store'); }} " method="POST">
        @csrf
        @method('POST')

        <table class="table-bordered">
            <tr>
                <td>
                    <strong>รหัสกรรมการ:</strong>
                </td>
                <td>
                    <input type="text" name="referee_id" class="form-control" placeholder="รหัสกรรมการ">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ชื่อ:</strong>
                </td>
                <td>
                    <input type="text" name="first_name" class="form-control" placeholder="ชื่อ">
                </td>
            </tr>
             <tr>
                <td>
                    <strong>นามสกุล:</strong>
                </td>
                <td>
                    <input type="text" name="last_name" class="form-control" placeholder="นามสกุล">
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
                    <div class="card-footer ml-auto mr-auto" align=center>
                        <a href="{{ route('referees.index') }} " class="btn btn-danger">ยกเลิก</a>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

@endsection
