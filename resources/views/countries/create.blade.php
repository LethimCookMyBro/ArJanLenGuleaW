@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    <form action=" {{ route('countries.store'); }} " method="POST">
        @csrf
        @method('POST')

        <table class="table-bordered">
            <tr>
                <td>
                    <strong>รหัสประเทศ:</strong>
                </td>

                <td>
                    <input type="text" name="country_id"  class="form-control"placeholder="รหัสประเทศ">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ชื่ออประเทศ:</strong>
                </td>
                <td>
                    <input type="text" name="country_name" class="form-control" placeholder="ชื่ออประเทศ">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ทวีป:</strong>
                </td>
                <td>
                    <input type="text" name="continent" class="form-control" placeholder="ทวีป">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>อันดับฟีฟ่า:</strong>
                </td>
                <td>
                    <input type="text" name="fifa_ranking" class="form-control" placeholder="อันดับฟีฟ่า">
                </td>
            </tr>


            <tr>
                <td>
                    <div class="card-footer ml-auto mr-auto" align=center>
                         <a href="{{ route('countries.index') }} " class="btn btn-danger">ยกเลิก</a>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

@endsection
