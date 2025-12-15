@extends('layout')
@section('title','รายละเอียดใบสั่งซื้อ')
@section('content')

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="" class="form-horizontal">
            @csrf
            @method('put')
 
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Show Student') }}</h4>
                <p class="card-category">{{ __('นิสิต') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                <table width=100%>
                <tr>
                    <td width=50%>
                        <label class="col-sm-2 col-form-label"><strong>รหัสนิสิต:</strong></label>
                        <div class="col-sm-7">
                            <div class="form-group">
                            <input type="text" readonly name="student_code" class="form-control" value="67161111">
                            </div>
                        </div>
                    </td>
                    <td witdth=50%>
                        <label class="col-sm-2 col-form-label"><strong>ชื่อ-นามสกุล :</strong></label>
                        <div class="col-sm-7">
                            <div class="form-group">
                            <input type="text" readonly name="student_name" class="form-control" value="นายรัก ประเทศไทย">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width=50%>
                        <label class="col-sm-2 col-form-label"><strong>เกรดเฉลี่ย:</strong></label>
                        <div class="col-sm-7">
                            <div class="form-group">
                            <input type="text" readonly name="gpa" class="form-control" value="3.96">
                            </div>
                        </div>
                    </td>
                    <td witdth=50%>
                        <label class="col-sm-2 col-form-label"><strong>รหัสสาขา :</strong></label>
                        <div class="col-sm-7">
                            <div class="form-group">
                            <input type="text" readonly name="dept_code" class="form-control" value="M001">
                            </div>
                        </div>
                    </td>
                    <td witdth=50%>
                        <label class="col-sm-2 col-form-label"><strong>รหัสอาจารย์ :</strong></label>
                        <div class="col-sm-7">
                            <div class="form-group">
                            <input type="text" readonly name="advisor_code" class="form-control" value="T001">
                            </div>
                        </div
                    </td>                    
                </tr>
                </table>
                
                </div>  
              </div>

              <div class="card-body ">              
                <div class="row">
                    <table width=100%>
                    <thead>
                        <td width=10% align=center>ลำดับ</td>
                        <td width=15% align=center>รหัสนิสิต</td>
                        <td width=30% align=center>ชื่อ-นามสกุล</td>
                        <td width=10% align=center>เกรดเฉลี่ย</td>
                        <td width=10% align=center>รหัสสาขา</td>
                        <td width=7% align=center>รหัสอาจารย์</td>
                    </thead>

                    <tr>
                        <td align=center>1</td>
                        <td align=center>67161111</td>
                        <td>นายรัก ประเทศไทย</td>
                        <td align=center>3.96</td>
                        <td align=center>M001</td>
                        <td align=center>T001</td>
                    </tr>

                    <tr>
                        <td colspan=6 align=right>รวม</td>
                        <td align=center>1  คน</td>     
                    </tr>       
                </table>
                </div> 

              <div class="card-footer ml-auto mr-auto">
                <button type="reset" class="btn btn-primary">กลับ</button>            

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection