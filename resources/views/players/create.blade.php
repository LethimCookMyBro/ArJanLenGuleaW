@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    <form action="{{ route('players.store'); }}" method="POST">
        @csrf
        @method('POST')

        <table class="table-bordered">
            <tr>
                <td>
                    <strong>รหัสนักเตะ:</strong>
                </td>

                <td>
                    <input type="text" name="player_id" class="form-control"placeholder="รหัสนักเตะ">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>รหัสทีม:</strong>
                </td>
                <td>
                   <select name="team_id">
                        @foreach ($teams as $team)
                            <option value="{{ $team->team_id }}">{{  $team->team_id }}&nbsp;&nbsp;{{ $team->coach_name }}</option>
                        @endforeach
                    </select>
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
                    <strong>นามสกุล</strong>
                </td>
                <td>
                    <input type="text" name="last_name" class="form-control" placeholder="นามสกุล">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ตำแหน่ง:</strong>
                </td>
                <td>
                    <input type="text" name="position" class="form-control" placeholder="ตำแหน่ง">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>เลขเสื้อ:</strong>
                </td>
                <td>
                    <input type="text" name="jersey_number" class="form-control" placeholder="เลขเสื้อ">
                </td>
            </tr>
            <tr>
                <td>    
                    <strong>วันเกิด:</strong>
                </td>
                <td>
                    <input type="text" name="date_of_birth" class="form-control" placeholder="yy/mm/dd">
                </td>
            </tr>


            <tr>
                <td>
                    <div class="card-footer ml-auto mr-auto" align=center>
                        <a href="{{ route('players.index') }} " class="btn btn-danger">ยกเลิก</a>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

@endsection
