# 🔧 FUNCTION.MD - ระบบค้นหานักกีฬา (Search Players)

---

## 📋 ไฟล์ที่ต้องแก้ไข (3 ไฟล์)

| #   | ไฟล์                                         | แก้อะไร                 |
| --- | -------------------------------------------- | ----------------------- |
| 1   | `app/Http/Controllers/PlayersController.php` | เพิ่ม function search() |
| 2   | `routes/web.php`                             | เพิ่ม 1 บรรทัด route    |
| 3   | `resources/views/players/index.blade.php`    | เพิ่มช่องค้นหา          |

---

## 1️⃣ PlayersController.php (โค้ดทั้งไฟล์)

**ที่อยู่:** `app/Http/Controllers/PlayersController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = DB::table('Players')->get();
        return view('players.index', compact('players'));
    }

    /**
     * Search players by name.
     * ค้นหานักกีฬาจากชื่อหรือนามสกุล
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        if ($keyword) {
            $players = DB::table('Players')
                ->where('first_name', 'like', '%' . $keyword . '%')
                ->orWhere('last_name', 'like', '%' . $keyword . '%')
                ->get();
        } else {
            $players = DB::table('Players')->get();
        }

        return view('players.index', compact('players', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = DB::table('Teams')->get();
        return view('players.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'player_id' => 'required',
            'team_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'position' => 'required',
            'jersey_number' => 'required',
            'date_of_birth' => 'required',
        ]);
        try{
        DB::table('Players')->insert([
            'player_id' => $request->player_id,
            'team_id' => $request->team_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('players.index')->with('success', 'Player created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('players.index')->with('failed', 'Failed to create player.');
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
        $players = DB::table('Players')->where('player_id', $id)->get();
        $teams = DB::table('Teams')->get();
        return view('players.edit', compact('players', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'team_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'position' => 'required',
            'jersey_number' => 'required',
            'date_of_birth' => 'required',
        ]);
        try{
        DB::table('Players')->where('player_id', $id)->update([
            'team_id' => $request->team_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('players.index')->with('success', 'Player updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('players.index')->with('failed', 'Failed to update player.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        DB::table('Players')->where('player_id', $id)->delete();
        return redirect()->route('players.index')->with('success', 'Player deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->route('players.index')->with('failed', 'Failed to deleted player.');
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
Route::get('/players/search', [PlayersController::class, 'search'])->name('players.search');

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

## 3️⃣ players/index.blade.php (โค้ดทั้งไฟล์)

**ที่อยู่:** `resources/views/players/index.blade.php`

```blade
@extends('layout')
@section('title', 'นักกีฬา')
@section('content')

    <!-- Search Form -->
    <div class="mb-3">
        <form action="{{ route('players.search') }}" method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="keyword" class="form-control"
                       value="{{ $keyword ?? '' }}" placeholder="ค้นหาชื่อหรือนามสกุล...">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">ค้นหา</button>
                <a href="{{ route('players.index') }}" class="btn btn-secondary">รีเซ็ต</a>
            </div>
        </form>
    </div>

    <div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <button class="btn btn-success"><a href="{{ route('players.create') }}">เพิ่มข้อมูล</a></button>
            </li>
        </ul>
    </div>
    <div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('failed'))
            <div class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
    </div>
    <div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>รหัสนักเตะ</th>
                    <th>รหัสทีม</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>ตำแหน่ง</th>
                    <th>เลขเสื้อ</th>
                    <th>วันเกิด</th>
                    <th colspan=2>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($players as $player)
                    <tr>
                        <td>{{ $player->player_id}}</td>
                        <td>{{ $player->team_id }}</td>
                        <td>{{ $player->first_name }}</td>
                        <td>{{ $player->last_name}}</td>
                        <td>{{ $player->position }}</td>
                        <td>{{ $player->jersey_number }}</td>
                        <td>{{ $player->date_of_birth }}</td>
                        <td>
                        <a href="{{ route('players.edit',$player->player_id) }}"><button class="btn btn-warning" >แก้ไข</button>

                        <form action="{{ route('players.destroy',$player->player_id) }}" method="POST">
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
    // รับค่า keyword จาก URL เช่น ?keyword=john
    $keyword = $request->get('keyword');

    if ($keyword) {
        // ค้นหาจาก first_name หรือ last_name ที่มีคำนี้
        $players = DB::table('Players')
            ->where('first_name', 'like', '%' . $keyword . '%')
            ->orWhere('last_name', 'like', '%' . $keyword . '%')
            ->get();
    } else {
        $players = DB::table('Players')->get();
    }

    // ส่ง $players และ $keyword ไป View
    return view('players.index', compact('players', 'keyword'));
}
```

| โค้ด                            | ความหมาย                       |
| ------------------------------- | ------------------------------ |
| `$request->get('keyword')`      | รับค่าจาก ?keyword=xxx ใน URL  |
| `'like', '%'.$keyword.'%'`      | ค้นหาที่มีคำนี้อยู่ตรงไหนก็ได้ |
| `orWhere`                       | หรือค้นหาจาก column อื่น       |
| `compact('players', 'keyword')` | ส่งตัวแปรไป View               |

---

## ⚠️ หมายเหตุ

-   `create.blade.php`, `edit.blade.php`, `show.blade.php` **ไม่ต้องแก้ไข** เพราะไม่เกี่ยวกับระบบค้นหา
-   ระบบค้นหาทำงานกับ `index.blade.php` เท่านั้น
