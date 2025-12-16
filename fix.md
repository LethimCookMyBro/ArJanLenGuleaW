# 🔧 FIX.MD - เพิ่มระบบค้นหาสนาม (Search)

---

## 📋 ไฟล์ที่ต้องแก้ไข (3 ไฟล์)

| #   | ไฟล์                                          | แก้อะไร                 |
| --- | --------------------------------------------- | ----------------------- |
| 1   | `app/Http/Controllers/StadiumsController.php` | เพิ่ม function search() |
| 2   | `routes/web.php`                              | เพิ่ม 1 บรรทัด route    |
| 3   | `resources/views/stadiums/index.blade.php`    | เพิ่มช่องค้นหา          |

---

## 1️⃣ StadiumsController.php (โค้ดทั้งไฟล์)

**ที่อยู่:** `app/Http/Controllers/StadiumsController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StadiumsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stadiums = DB::table('Stadiums')->get();
        return view('stadiums/index',compact('stadiums'));
    }

    /**
     * Search stadiums by name or city.
     * ค้นหาสนามจากชื่อหรือเมือง
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        if ($keyword) {
            $stadiums = DB::table('Stadiums')
                ->where('stadium_name', 'like', '%' . $keyword . '%')
                ->orWhere('city', 'like', '%' . $keyword . '%')
                ->get();
        } else {
            $stadiums = DB::table('Stadiums')->get();
        }

        return view('stadiums/index', compact('stadiums', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stadiums/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stadium_id' => 'required',
            'stadium_name' => 'required',
            'city' => 'required',
            'capacity' => 'required',
        ]);
        try{
        DB::table('Stadiums')->insert([
             'stadium_id' => $request->stadium_id,
             'stadium_name' => $request->stadium_name,
             'city' =>  $request->city,
             'capacity' =>  $request->capacity,
        ]);

        return redirect()->route('stadiums.index')->with('success','Stadiums create successfully.');
        }catch(\Exception $e){
            return redirect()->route('stadiums.index')->with('failed','Failed to create stadiums.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stadiums = DB::table('Stadiums')->where('stadium_id',$id)->get();
        return view('stadiums/edit',compact('stadiums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'stadium_name' => 'required',
            'city' => 'required',
            'capacity' => 'required',
        ]);
        try{
        DB::table('Stadiums')->where('stadium_id',$id)->update([
            'stadium_name' => $request->stadium_name,
            'city' =>  $request->city,
            'capacity' =>  $request->capacity,
        ]);
        return redirect()->route('stadiums.index')->with('success','Stadiums update successfully.');
        }catch(\Exception $e){
            return redirect()->with('failed','Failed to update stadiums.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        DB::table('Stadiums')->where('stadium_id',$id)->delete();
        return redirect()->route('stadiums.index')->with('success','Stadiums delete successfully.');
        }catch(\Exception $e){
            return redirect()->route('stadiums.index')->with('failed','Failed to delete stadiums.');
        }
    }
}
```

---

## 2️⃣ routes/web.php (โค้ดทั้งไฟล์)

**ที่อยู่:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\StadiumsController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\RefereesController;
use App\Http\Controllers\MatchRefereesController;

// ⬇️ route search ต้องอยู่ก่อน resource
Route::get('/stadiums/search', [StadiumsController::class, 'search'])->name('stadiums.search');

Route::resource('players', PlayersController::class);
Route::resource('teams', TeamsController::class);
Route::resource('matches', MatchesController::class);
Route::resource('countries', CountriesController::class);
Route::resource('stadiums', StadiumsController::class);
Route::resource('goals', GoalsController::class);
Route::resource('referees', RefereesController::class);
Route::resource('matchreferees', MatchRefereesController::class);

Route::get('/', [PlayersController::class, 'index']);
```

---

## 3️⃣ stadiums/index.blade.php (โค้ดทั้งไฟล์)

**ที่อยู่:** `resources/views/stadiums/index.blade.php`

```blade
@extends('layout')
@section('title', 'สนาม')
@section('content')

    <!-- Search Form -->
    <div class="mb-3">
        <form action="{{ route('stadiums.search') }}" method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="keyword" class="form-control"
                       value="{{ $keyword ?? '' }}" placeholder="ค้นหาชื่อสนามหรือเมือง...">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">ค้นหา</button>
                <a href="{{ route('stadiums.index') }}" class="btn btn-secondary">รีเซ็ต</a>
            </div>
        </form>
    </div>

    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('stadiums.create') }}">เพิ่มข้อมูล</a></button>
            </li>
        </ul>
    </div>
    <div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('failed'))
            <div class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
    </div>
    <div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>รหัสสนาม</th>
                    <th>ชื่อสนาม</th>
                    <th>เมือง</th>
                    <th>ความจุ</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($stadiums as $st)
                    <tr>
                        <td>{{ $st->stadium_id }}</td>
                        <td>{{ $st->stadium_name }}</td>
                        <td>{{ $st->city }}</td>
                        <td>{{ $st->capacity }}</td>
                        <td>
                        <a href="{{ route('stadiums.edit',$st->stadium_id) }}"><button class="btn btn-warning" >แก้ไข</button>

                        <form action="{{ route('stadiums.destroy',$st->stadium_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                        </td>

                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
@endsection
```

---

## 📝 อธิบายโค้ด search() (สำหรับตอบอาจารย์)

```php
public function search(Request $request)
{
    // รับค่า keyword จาก URL เช่น ?keyword=bangkok
    $keyword = $request->get('keyword');

    if ($keyword) {
        // ค้นหาจาก stadium_name หรือ city ที่มีคำนี้
        $stadiums = DB::table('Stadiums')
            ->where('stadium_name', 'like', '%' . $keyword . '%')
            ->orWhere('city', 'like', '%' . $keyword . '%')
            ->get();
    } else {
        $stadiums = DB::table('Stadiums')->get();
    }

    // ส่ง $stadiums และ $keyword ไป View
    return view('stadiums/index', compact('stadiums', 'keyword'));
}
```

| โค้ด                             | ความหมาย                       |
| -------------------------------- | ------------------------------ |
| `$request->get('keyword')`       | รับค่าจาก ?keyword=xxx ใน URL  |
| `'like', '%'.$keyword.'%'`       | ค้นหาที่มีคำนี้อยู่ตรงไหนก็ได้ |
| `orWhere`                        | หรือค้นหาจาก column อื่น       |
| `compact('stadiums', 'keyword')` | ส่งตัวแปรไป View               |
