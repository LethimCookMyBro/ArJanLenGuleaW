@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    @foreach($stadiums as $st)
    @endforeach
    <form action=" {{ route('stadiums.update',$st->stadium_id); }} " method="POST">
        @csrf
        @method('PUT')

        <table class="table-bordered">
             <tr>
                <td>
                    <strong>รหัสสนาม:</strong>
                </td>

                <td>
                    <input type="text" readonly name="stadium_id" value="{{ $st->stadium_id }}" class="form-control" placeholder="รหัสสนาม">
                </td>
            </tr>         
            <tr>
                <td>
                    <strong>ชื่อสนาม:</strong>
                </td>
                <td>
                    <input type="text" name="stadium_name"  value="{{ $st->stadium_name }}" class="form-control" placeholder="ขื่อสนาม">
                </td>
            </tr>
             <tr>
                <td>
                    <strong>ชื่อเมือง:</strong>
                </td>

                <td>
                    <input type="text" name="city" value="{{ $st->city }}" class="form-control"placeholder="ชื่อเมือง">
                </td>
            </tr>
             <tr>
                <td>
                    <strong>ความจุ:</strong>
                </td>
                <td>
                    <input type="text"  name="capacity" value="{{ $st->capacity}}" class="form-control"placeholder="">
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
