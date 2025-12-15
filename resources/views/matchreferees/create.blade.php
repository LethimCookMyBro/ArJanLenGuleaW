@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    <form action="{{ route('matchreferees.store'); }}" method="POST">
        @csrf
        @method('POST')

        <table class="table-bordered">
            <tr>
                <td>
                    <strong>รหัสผู้ตัดสินแมทช์:</strong>
                </td>

                <td>
                    <input type="text" name="match_referee_id"  class="form-control"placeholder="รหัสผู้ตัดสินของแมทช์">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>รหัสแมทช์:</strong>
                </td>
                <td>
                     <select name="match_id">
                        @foreach ($matches as $match)
                            <option value="{{ $match->match_id }}">{{  $match->match_id }}&nbsp;&nbsp;{{ $match->team1_id }}&nbsp;&nbsp;
                                           {{ $match->team2_id }}&nbsp;&nbsp;{{ $match->match_date }}&nbsp;&nbsp;{{ $match->match_time }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>รหัสผู้ตัดสิน:</strong>
                </td>
                <td>
                    <input type="text" name="referee_id" class="form-control" placeholder="รหัสผู้ตัดสิน">
                </td>
            </tr>
             <tr>
                <td>
                    <strong>หน้าที่:</strong>
                </td>
                <td>
                    <input type="text" name="role" class="form-control" placeholder="หน้าที่">
                </td>
            </tr>


            <tr>
                <td>
                    <div class="card-footer ml-auto mr-auto" align=center>
                        <a href="{{ route('matchreferees.index') }} " class="btn btn-danger">ยกเลิก</a>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

@endsection
