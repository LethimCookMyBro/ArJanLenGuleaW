@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    <form action=" {{ route('stadiums.store'); }} " method="POST">
        @csrf
        @method('POST')

         <table class="table-bordered">
            <tr>
                <td>
                    <strong>รหัสสนาม:</strong>
                </td>

                <td>
                    <input type="text" name="stadium_id" class="form-control" placeholder="รหัสสนาม">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ชื่อสนาม:</strong>
                </td>
                <td>
                    <input type="text" name="stadium_name" class="form-control" placeholder="ชื่อสนาม">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>เมือง:</strong>
                </td>
                <td>
                    <input type="text" name="city" class="form-control" placeholder="เมือง">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ความจุ:</strong>
                </td>
                <td>
                    <input type="text" name="capacity" class="form-control" placeholder="ความจุ">
                </td>
            </tr>


            <tr>
                <td>
                    <div class="card-footer ml-auto mr-auto" align=center>
                       <a href="{{ route('stadiums.index') }} " class="btn btn-danger">ยกเลิก</a>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

@endsection
