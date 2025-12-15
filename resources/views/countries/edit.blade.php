@extends('layout')
@section('title', 'ระบบร้านหนังสือ')
@section('content')
    @foreach($countries as $co)
    @endforeach
    <form action="{{ route('countries.update',$co->country_id); }}" method="POST">
        @csrf
        @method('PUT')

        <table class="table-bordered"> 
             <tr>
                <td>
                    <strong>รหัสประเทศประเทศ:</strong>
                </td>
                <td>
                    <input type="text" name="country_id"  readonly  value="{{ $co->country_id }}" class="form-control" placeholder="รหัสประเทศ">
                </td>
            </tr>        
            <tr>
                <td>
                    <strong>ชื่อประเทศ:</strong>
                </td>
                <td>
                    <input type="text" name="country_name"  value="{{ $co->country_name }}" class="form-control" placeholder="ขื่อประเทศ">
                </td>
            </tr>
             <tr>
                <td>
                    <strong>ชื่อทวีป:</strong>
                </td>

                <td>
                    <input type="text" name="continent" value="{{ $co->continent }}" class="form-control"
                        placeholder="ชื่อทวีป">
                </td>
            </tr>
             <tr>
                <td>
                    <strong>อันดับฟีฟ่า:</strong>
                </td>
                <td>
                    <input type="text"  name="fifa_ranking" value="{{ $co->fifa_ranking }}" class="form-control"
                        placeholder="อันดับฟีฟ่า">
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
