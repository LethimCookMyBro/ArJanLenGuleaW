@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    @foreach($goals as $go)
    @endforeach
    <form action=" {{ route('goals.update',$go->goal_id); }} " method="POST">
        @csrf
        @method('PUT')

        <table class="table-bordered">
            <tr>
                <td>
                    <strong>รหัสทำประตู:</strong>
                </td>

                <td>
                    <input type="text" name="goal_id" readonly value="{{ $go->goal_id }}" class="form-control"placeholder="รหัสทำประตู">
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
                                           {{ $match->team2_id }}&nbsp;&nbsp;{{ $match->match_time }}&nbsp;&nbsp;{{ $match->match_date }}&nbsp;&nbsp;{{ $match->stage }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>รหัสนักเตะ:</strong>
                </td>
                <td>
                   <select name="player_id">
                        @foreach ($players as $player)
                            <option value="{{ $player->player_id }}">{{  $player->first_name }}&nbsp;&nbsp;{{ $player->last_name }}&nbsp;&nbsp;{{ $player->position }}&nbsp;&nbsp;{{ $player->jersey_number }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>เวลา:</strong>
                </td>
                <td>
                    <input type="text" name="goal_time" value="{{ $go->goal_time }}" class="form-control" placeholder="เวลา">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ลูกโทษ:</strong>
                </td>
                <td>
                    <input type="text" name="is_penalty"  value="{{ $go->is_penalty }}" class="form-control" placeholder="ลูกโทษ">
                </td>
            </tr>
            <tr>
                <td>
                    <div class="card-footer ml-auto mr-auto" align=center>
                         <a href="{{ route('goals.index') }} " class="btn btn-danger">ยกเลิก</a>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

@endsection
