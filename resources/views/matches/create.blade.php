@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    <form action="{{ route('matches.store'); }}" method="POST">
        @csrf
        @method('POST')

        <table class="table-bordered">
            <tr>
                <td>
                    <strong>รหัสแมทช์:</strong>
                </td>

                <td>
                    <input type="text" name="match_id"  class="form-control" placeholder="รหัสแมทช์">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>รหัสสนาม:</strong>
                </td>
                <td>
                    <select name="stadium_id">
                        @foreach($stadiums as $stadium)
                            <option value="{{ $stadium->stadium_id }}">{{ $stadium->stadium_name }}&nbsp;&nbsp;{{ $stadium->city }}&nbsp;&nbsp;{{ $stadium->capacity }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ทีม1:</strong>
                </td>
                <td>
                    <select name="team1_id">
                        @foreach ($teams as $team)
                            <option value="{{ $team->team_id }}">{{  $team->team_id }}&nbsp;&nbsp;{{ $team->coach_name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ทีม2:</strong>
                </td>
                <td>
                    <select name="team2_id">
                        @foreach ($teams as $team)
                            <option value="{{ $team->team_id }}">{{  $team->team_id }}&nbsp;&nbsp;{{ $team->coach_name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>วันที่:</strong>
                </td>
                <td>
                    <input type="text" name="match_date" class="form-control" placeholder="yy/mm/dd">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>เวลา:</strong>
                </td>
                <td>
                    <input type="text" name="match_time" class="form-control" placeholder="hh:mm:ss">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>สถานะ:</strong>
                </td>
                <td>
                    <input type="text" name="stage" class="form-control" placeholder="สถานะ">
                </td>
            </tr>   

            <tr>
                <td>
                    <div class="card-footer ml-auto mr-auto" align=center>
                         <a href="{{ route('matches.index') }} " class="btn btn-danger">ยกเลิก</a>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

@endsection
