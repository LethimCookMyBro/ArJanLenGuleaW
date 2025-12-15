# 📖 LEARN.MD - อธิบายโค้ดละเอียดทุกไฟล์และการเชื่อมต่อ

> เอกสารนี้อธิบายโค้ดทุกไฟล์ในโปรเจค Laravel อย่างละเอียด รวมถึงการเชื่อมต่อระหว่างไฟล์และตัวแปรทั้งหมด

---

## สารบัญ

1. [ภาพรวมโปรเจค](#1-ภาพรวมโปรเจค)
2. [โครงสร้างไฟล์ทั้งหมด](#2-โครงสร้างไฟล์ทั้งหมด)
3. [Routes - จุดเริ่มต้นการเชื่อมต่อ](#3-routes---จุดเริ่มต้นการเชื่อมต่อ)
4. [Controllers - อธิบายโค้ดทุกบรรทัด](#4-controllers---อธิบายโค้ดทุกบรรทัด)
5. [Views - หน้าเว็บทั้งหมด](#5-views---หน้าเว็บทั้งหมด)
6. [การเชื่อมต่อระหว่าง Entity](#6-การเชื่อมต่อระหว่าง-entity)
7. [Flow การทำงานทั้งหมด](#7-flow-การทำงานทั้งหมด)
8. [สรุปตัวแปรสำคัญ](#8-สรุปตัวแปรสำคัญ)

---

## 1. ภาพรวมโปรเจค

โปรเจคนี้เป็น **ระบบจัดการฟุตบอล (Football Management System)** พัฒนาด้วย Laravel Framework ใช้รูปแบบ **MVC (Model-View-Controller)**

### เทคโนโลยีที่ใช้

-   **PHP**: ^8.2
-   **Laravel**: ^12.0
-   **Bootstrap**: 5.0.2 (สำหรับ UI)
-   **Database**: MySQL หรือ SQLite

### Entity ทั้งหมด (8 ตาราง)

| ตาราง           | ความหมาย          | Primary Key        |
| --------------- | ----------------- | ------------------ |
| `Countries`     | ประเทศ            | `country_id`       |
| `Teams`         | ทีม               | `team_id`          |
| `Players`       | นักกีฬา           | `player_id`        |
| `Stadiums`      | สนาม              | `stadium_id`       |
| `Matches`       | การแข่งขัน        | `match_id`         |
| `Goals`         | ประตู             | `goal_id`          |
| `Referees`      | กรรมการ           | `referee_id`       |
| `MatchReferees` | กรรมการประจำแมตช์ | `match_referee_id` |

---

## 2. โครงสร้างไฟล์ทั้งหมด

```
project-main/
├── app/
│   └── Http/
│       └── Controllers/           # ⭐ Logic ทั้งหมดอยู่ที่นี่
│           ├── Controller.php           # Base controller
│           ├── PlayersController.php    # จัดการนักกีฬา
│           ├── TeamsController.php      # จัดการทีม
│           ├── MatchesController.php    # จัดการแมตช์
│           ├── CountriesController.php  # จัดการประเทศ
│           ├── StadiumsController.php   # จัดการสนาม
│           ├── GoalsController.php      # จัดการประตู
│           ├── RefereesController.php   # จัดการกรรมการ
│           └── MatchRefereesController.php # จัดการกรรมการในแมตช์
│
├── routes/
│   └── web.php                    # ⭐ กำหนด URL ทั้งหมด
│
├── resources/
│   └── views/                     # ⭐ หน้าเว็บทั้งหมด
│       ├── layout.blade.php       # Template หลัก
│       ├── players/               # Views ของ Players
│       │   ├── index.blade.php    # หน้ารายการ
│       │   ├── create.blade.php   # ฟอร์มเพิ่ม
│       │   └── edit.blade.php     # ฟอร์มแก้ไข
│       ├── teams/
│       ├── matches/
│       ├── countries/
│       ├── stadiums/
│       ├── goals/
│       ├── referees/
│       └── matchreferees/
│
└── database/
    └── migrations/                # สร้างตารางในฐานข้อมูล
```

---

## 3. Routes - จุดเริ่มต้นการเชื่อมต่อ

### ไฟล์: `routes/web.php`

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

### อธิบายทีละบรรทัด

| บรรทัด | โค้ด                                                    | อธิบาย                                                     |
| ------ | ------------------------------------------------------- | ---------------------------------------------------------- |
| 3      | `use Illuminate\Support\Facades\Route;`                 | **Import** คลาส Route ของ Laravel เพื่อใช้กำหนดเส้นทาง URL |
| 4-11   | `use App\Http\Controllers\...`                          | **Import** Controller ทั้ง 8 ตัวเพื่อใช้งาน                |
| 13     | `Route::resource('players', PlayersController::class);` | **สร้าง 7 routes อัตโนมัติ** สำหรับ CRUD (ดูตารางด้านล่าง) |
| 22     | `Route::get('/', [..., 'index']);`                      | เมื่อเข้า `/` ให้ไปหน้า `players.index`                    |

### Routes ที่ `Route::resource()` สร้างอัตโนมัติ (ต่อ 1 resource)

| HTTP Method | URL                  | Action      | Route Name        | ใช้ทำอะไร                  |
| ----------- | -------------------- | ----------- | ----------------- | -------------------------- |
| GET         | `/players`           | `index()`   | `players.index`   | แสดงรายการทั้งหมด          |
| GET         | `/players/create`    | `create()`  | `players.create`  | แสดงฟอร์มเพิ่ม             |
| POST        | `/players`           | `store()`   | `players.store`   | บันทึกข้อมูลใหม่           |
| GET         | `/players/{id}`      | `show()`    | `players.show`    | แสดงรายละเอียด (ไม่ได้ใช้) |
| GET         | `/players/{id}/edit` | `edit()`    | `players.edit`    | แสดงฟอร์มแก้ไข             |
| PUT/PATCH   | `/players/{id}`      | `update()`  | `players.update`  | อัปเดตข้อมูล               |
| DELETE      | `/players/{id}`      | `destroy()` | `players.destroy` | ลบข้อมูล                   |

### การเชื่อมต่อ: Routes → Controllers

```
┌─────────────────────────────────────────────────────────────────────────┐
│                        การเชื่อมต่อ Routes → Controllers                  │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│   URL: /players                                                         │
│        ↓                                                                │
│   Route::resource('players', PlayersController::class)                  │
│        ↓                                                                │
│   เรียก PlayersController.php                                          │
│        ↓                                                                │
│   เลือก method ตาม HTTP: GET→index(), POST→store(), PUT→update()       │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 4. Controllers - อธิบายโค้ดทุกบรรทัด

### 4.1 PlayersController.php - ตัวอย่างหลัก

```php
<?php
// บรรทัด 1: เปิด PHP tag

namespace App\Http\Controllers;
// บรรทัด 3: กำหนด namespace (ที่อยู่ของไฟล์ในโครงสร้าง Laravel)
// หมายความว่าไฟล์นี้อยู่ใน app/Http/Controllers/

use Illuminate\Http\Request;
// บรรทัด 5: Import คลาส Request
// ใช้รับข้อมูลจากฟอร์ม เช่น $request->first_name

use DB;
// บรรทัด 6: Import DB Facade
// ใช้สำหรับ Query ฐานข้อมูลโดยตรง เช่น DB::table('Players')->get();

class PlayersController extends Controller
// บรรทัด 7: สร้างคลาส PlayersController สืบทอดจาก Controller
{
```

### 4.1.1 Method: `index()` - แสดงรายการทั้งหมด

```php
public function index()
{
    $players = DB::table('Players')->get();
    // ดึงข้อมูลทั้งหมดจากตาราง Players
    // $players = Collection ของข้อมูลนักกีฬาทั้งหมด
    // SQL ที่เกิดขึ้น: SELECT * FROM Players

    return view('players.index', compact('players'));
    // ส่งไปหน้า resources/views/players/index.blade.php
    // compact('players') = ['players' => $players]
    // ตัวแปร $players จะใช้ได้ใน View
}
```

**การเชื่อมต่อ:**

```
index() → DB::table('Players')->get() → ได้ $players
         ↓
view('players.index', compact('players'))
         ↓
resources/views/players/index.blade.php (ใช้ $players แสดงตาราง)
```

### 4.1.2 Method: `create()` - แสดงฟอร์มเพิ่มข้อมูล

```php
public function create()
{
    $teams = DB::table('Teams')->get();
    // ดึงข้อมูลทีมทั้งหมดจากตาราง Teams
    // ใช้สำหรับ dropdown ให้เลือกทีม
    // SQL: SELECT * FROM Teams

    return view('players.create', compact('teams'));
    // ส่งไปหน้า create.blade.php พร้อมตัวแปร $teams
}
```

**ทำไมต้องดึง Teams?**

-   เพราะนักกีฬาต้องสังกัดทีม
-   ใน View จะมี `<select>` ให้เลือกทีม
-   `$teams` ใช้วนลูปสร้าง `<option>`

### 4.1.3 Method: `store()` - บันทึกข้อมูลใหม่

```php
public function store(Request $request)
// $request = ข้อมูลที่ส่งมาจากฟอร์ม (POST)
{
    $request->validate([
    // ตรวจสอบข้อมูลก่อนบันทึก
    // ถ้าไม่ผ่าน จะ redirect กลับพร้อม error
        'player_id' => 'required',      // ห้ามว่าง
        'team_id' => 'required',        // ห้ามว่าง
        'first_name' => 'required',     // ห้ามว่าง
        'last_name' => 'required',      // ห้ามว่าง
        'position' => 'required',       // ห้ามว่าง
        'jersey_number' => 'required',  // ห้ามว่าง
        'date_of_birth' => 'required',  // ห้ามว่าง
    ]);

    try {
    // ใช้ try-catch จับ error กรณี insert ไม่สำเร็จ

        DB::table('Players')->insert([
        // แทรกข้อมูลใหม่เข้าตาราง Players
        // SQL: INSERT INTO Players (player_id, team_id, ...) VALUES (...)

            'player_id' => $request->player_id,
            // $request->player_id = ค่าจาก input name="player_id"

            'team_id' => $request->team_id,
            // $request->team_id = ค่าจาก select name="team_id"

            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('players.index')
                         ->with('success', 'Player created successfully.');
        // redirect ไปหน้า index พร้อม flash message "success"

    } catch (\Exception $e) {
        return redirect()->route('players.index')
                         ->with('failed', 'Failed to create player.');
        // ถ้ามี error ส่ง message "failed"
    }
}
```

**การเชื่อมต่อ Form → store():**

```
Form (POST /players)
     ↓
  @csrf token (ป้องกัน CSRF attack)
     ↓
  input name="first_name" value="John"
     ↓
  Controller รับเป็น $request->first_name
     ↓
  validate() ตรวจสอบ
     ↓
  DB::table('Players')->insert([...])
     ↓
  redirect()->route('players.index')
```

### 4.1.4 Method: `edit($id)` - แสดงฟอร์มแก้ไข

```php
public function edit(string $id)
// $id = ค่าจาก URL เช่น /players/5/edit → $id = "5"
{
    $players = DB::table('Players')->where('player_id', $id)->get();
    // ดึงนักกีฬาที่มี player_id ตรงกับ $id
    // SQL: SELECT * FROM Players WHERE player_id = 5
    // $players = Collection (array ของผลลัพธ์)

    $teams = DB::table('Teams')->get();
    // ดึงทีมทั้งหมด สำหรับ dropdown

    return view('players.edit', compact('players', 'teams'));
    // ส่งทั้ง $players และ $teams ไป View
    // compact('players', 'teams') = ['players' => $players, 'teams' => $teams]
}
```

### 4.1.5 Method: `update($request, $id)` - อัปเดตข้อมูล

```php
public function update(Request $request, string $id)
// $request = ข้อมูลจากฟอร์ม
// $id = ID ที่จะแก้ไข (จาก URL)
{
    $request->validate([
        'team_id' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'position' => 'required',
        'jersey_number' => 'required',
        'date_of_birth' => 'required',
    ]);
    // ⚠️ ไม่ validate player_id เพราะไม่ให้แก้ (readonly)

    try {
        DB::table('Players')->where('player_id', $id)->update([
        // SQL: UPDATE Players SET team_id=?, first_name=?, ... WHERE player_id=5

            'team_id' => $request->team_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('players.index')
                         ->with('success', 'Player updated successfully.');
    } catch (\Exception $e) {
        return redirect()->route('players.index')
                         ->with('failed', 'Failed to update player.');
    }
}
```

### 4.1.6 Method: `destroy($id)` - ลบข้อมูล

```php
public function destroy(string $id)
{
    try {
        DB::table('Players')->where('player_id', $id)->delete();
        // SQL: DELETE FROM Players WHERE player_id = 5

        return redirect()->route('players.index')
                         ->with('success', 'Player deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->route('players.index')
                         ->with('failed', 'Failed to deleted player.');
        // อาจ fail ถ้ามี Foreign Key constraint
    }
}
```

---

### 4.2 TeamsController.php - มี Foreign Key กับ Countries

```php
public function create()
{
    $countries = DB::table('Countries')->get();
    // ดึงประเทศทั้งหมด เพราะทีมต้องสังกัดประเทศ
    return view('teams.create', compact('countries'));
}

public function store(Request $request)
{
    $request->validate([
        'team_id' => 'required',
        'country_id' => 'required',  // ⭐ Foreign Key ไปยัง Countries
        'coach_name' => 'required',
        'group_name' => 'required',
    ]);

    DB::table('Teams')->insert([
        'team_id' => $request->team_id,
        'country_id' => $request->country_id,
        'coach_name' =>  $request->coach_name,
        'group_name' =>  $request->group_name,
    ]);
}
```

**การเชื่อมต่อ Teams ↔ Countries:**

```
Teams.country_id → Countries.country_id

เวลาสร้างทีม:
1. ดึงประเทศทั้งหมด: $countries = DB::table('Countries')->get()
2. แสดง dropdown: <select name="country_id">
3. เก็บ country_id ในตาราง Teams
```

---

### 4.3 MatchesController.php - มี 2 Foreign Keys

```php
public function create()
{
    $stadiums = DB::table('Stadiums')->get();  // สนามแข่ง
    $teams = DB::table('Teams')->get();         // ทีม (ใช้ 2 ทีม)
    return view('matches/create', compact('stadiums', 'teams'));
}

public function store(Request $request)
{
    $request->validate([
        'match_id' => 'required',
        'stadium_id' => 'required',   // ⭐ FK → Stadiums
        'team1_id' => 'required',     // ⭐ FK → Teams (ทีมเหย้า)
        'team2_id' => 'required',     // ⭐ FK → Teams (ทีมเยือน)
        'match_date' => 'required',
        'match_time' => 'required',
        'stage' => 'required',
    ]);

    DB::table('Matches')->insert([
        'match_id' => $request->match_id,
        'stadium_id' => $request->stadium_id,
        'team1_id' => $request->team1_id,
        'team2_id' => $request->team2_id,
        'match_date' => $request->match_date,
        'match_time' => $request->match_time,
        'stage' => $request->stage,
    ]);
}
```

**การเชื่อมต่อ Matches:**

```
Matches.stadium_id → Stadiums.stadium_id  (แข่งที่สนามไหน)
Matches.team1_id   → Teams.team_id        (ทีมเหย้า)
Matches.team2_id   → Teams.team_id        (ทีมเยือน)
```

---

### 4.4 GoalsController.php - บันทึกประตู

```php
public function create()
{
    $matches = DB::table('Matches')->get();   // แมตช์ที่ยิงประตู
    $players = DB::table('Players')->get();   // นักเตะที่ยิง
    return view('goals.create', compact('matches', 'players'));
}

public function store(Request $request)
{
    $request->validate([
        'goal_id' => 'required',
        'match_id' => 'required',    // ⭐ FK → Matches
        'player_id' => 'required',   // ⭐ FK → Players
        'goal_time' => 'required',   // นาทีที่ยิง
        'is_penalty' => 'required',  // เป็นลูกโทษหรือไม่
    ]);

    DB::table('Goals')->insert([
        'goal_id' => $request->goal_id,
        'match_id' => $request->match_id,
        'player_id' =>  $request->player_id,
        'goal_time' =>  $request->goal_time,
        'is_penalty' =>  $request->is_penalty,
    ]);
}
```

---

### 4.5 MatchRefereesController.php - ตาราง Junction

```php
public function create()
{
    $matches = DB::table('Matches')->get();    // แมตช์
    $referees = DB::table('Referees')->get();  // กรรมการ
    return view('matchreferees.create', compact('matches', 'referees'));
}

public function store(Request $request)
{
    $request->validate([
        'match_referee_id' => 'required',
        'match_id' => 'required',     // ⭐ FK → Matches
        'referee_id' => 'required',   // ⭐ FK → Referees
        'role' => 'required',         // บทบาท (หลัก, ผู้ช่วย, VAR)
    ]);
}
```

**Junction Table:**

```
MatchReferees เป็นตารางกลาง เชื่อม Matches กับ Referees

Matches ─────┐
              ├──→ MatchReferees ←──┤
Referees ────┘                      │
                                    └── 1 แมตช์มีหลายกรรมการ
                                        1 กรรมการทำหลายแมตช์
```

---

## 5. Views - หน้าเว็บทั้งหมด

### 5.1 layout.blade.php - Template หลัก

```html
<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <!-- @yield('title') = แสดงชื่อหน้า ที่กำหนดใน @section('title') -->

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />
        <!-- โหลด Bootstrap CSS สำหรับการตกแต่ง -->
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <!-- Navbar สีเข้ม -->
            <a class="navbar-brand" href="#">Football</a>

            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">หน้าแรก</a>
                    <!-- href="/" → ไปที่ Route::get('/') → PlayersController@index -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/matches">ตารางแข่งขัน</a>
                    <!-- href="/matches" → Route::resource('matches') → index() -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/countries">ตารางประเทศ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/goals">ตารางประตู</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/teams">ตารางทีม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/players">นักกีฬา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/referees">กรรมการ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/stadiums">สนาม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/matchreferees"
                        >ตารางกรรมการกับเกม</a
                    >
                </li>
            </ul>
        </nav>

        <div class="container py-5">
            @yield('content')
            <!-- @yield('content') = เนื้อหาจาก @section('content') -->
            <!-- ทุก View จะใส่เนื้อหาตรงนี้ -->
        </div>
    </body>
</html>
```

**การทำงานของ Blade Template:**

```
@yield('title')    ← รอรับค่าจาก @section('title', 'ชื่อหน้า')
@yield('content')  ← รอรับค่าจาก @section('content') ... @endsection
```

---

### 5.2 players/index.blade.php - แสดงรายการ

```blade
@extends('layout')
{{-- สืบทอด layout.blade.php --}}

@section('title', 'นักกีฬา')
{{-- กำหนดชื่อหน้า ส่งไป @yield('title') --}}

@section('content')
{{-- เริ่มเนื้อหาส่งไป @yield('content') --}}

    <div>
        <button class="btn btn-success">
            <a href="{{ route('players.create') }}">เพิ่มข้อมูล</a>
        </button>
        {{-- route('players.create') = URL /players/create --}}
        {{-- เมื่อคลิกจะไป PlayersController@create --}}
    </div>

    <div>
        @if(session('success'))
        {{-- ตรวจว่ามี flash message 'success' ไหม --}}
        {{-- มาจาก ->with('success', '...') ใน Controller --}}
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
            {{-- วนลูปแสดงนักกีฬาแต่ละคน --}}
            {{-- $players มาจาก Controller: compact('players') --}}
            <tr>
                <td>{{ $player->player_id}}</td>
                {{-- แสดงค่า player_id --}}
                {{-- {{ }} = แสดงค่าพร้อม escape HTML (ป้องกัน XSS) --}}

                <td>{{ $player->team_id }}</td>
                <td>{{ $player->first_name }}</td>
                <td>{{ $player->last_name}}</td>
                <td>{{ $player->position }}</td>
                <td>{{ $player->jersey_number }}</td>
                <td>{{ $player->date_of_birth }}</td>
                <td>
                    <a href="{{ route('players.edit', $player->player_id) }}">
                        <button class="btn btn-warning">แก้ไข</button>
                    </a>
                    {{-- route('players.edit', $player->player_id) --}}
                    {{-- = URL /players/5/edit (ถ้า player_id = 5) --}}

                    <form action="{{ route('players.destroy', $player->player_id) }}"
                          method="POST">
                        @csrf
                        {{-- CSRF Token ป้องกันการโจมตี --}}
                        {{-- Laravel บังคับใส่ทุก form --}}

                        @method('DELETE')
                        {{-- เปลี่ยน method เป็น DELETE --}}
                        {{-- HTML form รองรับแค่ GET/POST --}}
                        {{-- @method() สร้าง hidden input _method=DELETE --}}

                        <button type="submit" class="btn btn-danger">ลบ</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
```

---

### 5.3 players/create.blade.php - ฟอร์มเพิ่ม

```blade
@extends('layout')
@section('title', 'เพิ่มนักกีฬา')
@section('content')

    <form action="{{ route('players.store') }}" method="POST">
    {{-- ส่งข้อมูลไป /players (POST) → store() --}}

        @csrf
        {{-- ⭐ จำเป็น! ป้องกัน CSRF Attack --}}

        @method('POST')
        {{-- ระบุ HTTP method (POST = สร้างใหม่) --}}

        <table class="table-bordered">
            <tr>
                <td><strong>รหัสนักเตะ:</strong></td>
                <td>
                    <input type="text" name="player_id"
                           class="form-control" placeholder="รหัสนักเตะ">
                    {{-- name="player_id" → $request->player_id --}}
                </td>
            </tr>
            <tr>
                <td><strong>รหัสทีม:</strong></td>
                <td>
                    <select name="team_id">
                    {{-- name="team_id" → $request->team_id --}}

                        @foreach ($teams as $team)
                        {{-- วนลูปสร้าง option จาก $teams --}}
                        {{-- $teams มาจาก Controller: compact('teams') --}}

                            <option value="{{ $team->team_id }}">
                            {{-- value = ค่าที่จะส่งไป Controller --}}

                                {{ $team->team_id }}&nbsp;&nbsp;{{ $team->coach_name }}
                                {{-- แสดงรหัสทีมและชื่อโค้ช --}}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>ชื่อ:</strong></td>
                <td>
                    <input type="text" name="first_name"
                           class="form-control" placeholder="ชื่อ">
                </td>
            </tr>
            <tr>
                <td><strong>นามสกุล:</strong></td>
                <td>
                    <input type="text" name="last_name"
                           class="form-control" placeholder="นามสกุล">
                </td>
            </tr>
            <tr>
                <td><strong>ตำแหน่ง:</strong></td>
                <td>
                    <input type="text" name="position"
                           class="form-control" placeholder="ตำแหน่ง">
                </td>
            </tr>
            <tr>
                <td><strong>เลขเสื้อ:</strong></td>
                <td>
                    <input type="text" name="jersey_number"
                           class="form-control" placeholder="เลขเสื้อ">
                </td>
            </tr>
            <tr>
                <td><strong>วันเกิด:</strong></td>
                <td>
                    <input type="text" name="date_of_birth"
                           class="form-control" placeholder="yy/mm/dd">
                </td>
            </tr>
            <tr>
                <td>
                    <a href="{{ route('players.index') }}" class="btn btn-danger">
                        ยกเลิก
                    </a>
                    {{-- ปุ่มยกเลิก กลับไปหน้า index --}}

                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    {{-- ปุ่ม submit ส่งฟอร์ม --}}
                </td>
            </tr>
        </table>
    </form>

@endsection
```

---

### 5.4 players/edit.blade.php - ฟอร์มแก้ไข

```blade
@extends('layout')
@section('title', 'แก้ไขนักกีฬา')
@section('content')

    @foreach($players as $player)
    @endforeach
    {{-- วนลูปเพื่อดึงค่า $player ล่าสุดออกมา --}}
    {{-- (เพราะ $players เป็น Collection แม้จะมี 1 ตัว) --}}

    <form action="{{ route('players.update', $player->player_id) }}" method="POST">
    {{-- ส่งไป /players/5 (PUT) → update() --}}

        @csrf
        @method('PUT')
        {{-- ⭐ ใช้ PUT สำหรับ update --}}

        <table class="table-bordered">
            <tr>
                <td><strong>รหัสนักเตะ:</strong></td>
                <td>
                    <input type="text" readonly name="player_id"
                           value="{{ $player->player_id }}"
                           class="form-control">
                    {{-- readonly = แก้ไขไม่ได้ --}}
                    {{-- value="{{ $player->player_id }}" = แสดงค่าเดิม --}}
                </td>
            </tr>
            <tr>
                <td><strong>รหัสทีม:</strong></td>
                <td>
                    <select name="team_id">
                        @foreach ($teams as $team)
                            <option value="{{ $team->team_id }}">
                                {{ $team->team_id }}&nbsp;&nbsp;{{ $team->coach_name }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>ชื่อ:</strong></td>
                <td>
                    <input type="text" name="first_name"
                           value="{{ $player->first_name }}"
                           class="form-control">
                    {{-- value="{{ $player->first_name }}" = แสดงค่าเดิม --}}
                </td>
            </tr>
            {{-- ... ฟิลด์อื่นๆ คล้ายกัน ... --}}
            <tr>
                <td>
                    <a href="{{ route('players.index') }}" class="btn btn-danger">
                        ยกเลิก
                    </a>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </td>
            </tr>
        </table>
    </form>

@endsection
```

---

## 6. การเชื่อมต่อระหว่าง Entity

### 6.1 ER Diagram

```
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│  Countries  │────────→│    Teams    │────────→│   Players   │
│             │  1:M    │             │  1:M    │             │
│ country_id  │         │ team_id     │         │ player_id   │
│ country_name│         │ country_id  │←FK      │ team_id     │←FK
│ continent   │         │ coach_name  │         │ first_name  │
│ fifa_ranking│         │ group_name  │         │ last_name   │
└─────────────┘         └─────────────┘         │ position    │
                              │                 │ jersey_number│
                              │                 │ date_of_birth│
                              │                 └──────┬───────┘
                              │                        │
                              ▼                        │
┌─────────────┐         ┌─────────────┐               │
│  Stadiums   │────────→│   Matches   │←──────────────┘
│             │  1:M    │             │
│ stadium_id  │         │ match_id    │         ┌─────────────┐
│ stadium_name│         │ stadium_id  │←FK      │    Goals    │
│ city        │         │ team1_id    │←FK      │             │
│ capacity    │         │ team2_id    │←FK      │ goal_id     │
└─────────────┘         │ match_date  │         │ match_id    │←FK
                        │ match_time  │         │ player_id   │←FK
                        │ stage       │         │ goal_time   │
                        └──────┬──────┘         │ is_penalty  │
                               │                └─────────────┘
                               │
                               ▼
┌─────────────┐         ┌───────────────┐
│  Referees   │────────→│MatchReferees │
│             │  M:N    │   (Junction)  │
│ referee_id  │         │               │
│ first_name  │         │match_referee_id│
│ last_name   │         │ match_id      │←FK
│ country_id  │←FK      │ referee_id    │←FK
└─────────────┘         │ role          │
      ↑                 └───────────────┘
      │
      │ FK
┌─────────────┐
│  Countries  │
└─────────────┘
```

### 6.2 ตารางความสัมพันธ์

| ตารางหลัก | ตารางที่เชื่อม | ประเภท | Foreign Key                    | อธิบาย                |
| --------- | -------------- | ------ | ------------------------------ | --------------------- |
| Countries | Teams          | 1:M    | `Teams.country_id`             | 1 ประเทศมีหลายทีม     |
| Countries | Referees       | 1:M    | `Referees.country_id`          | 1 ประเทศมีหลายกรรมการ |
| Teams     | Players        | 1:M    | `Players.team_id`              | 1 ทีมมีหลายนักเตะ     |
| Teams     | Matches        | 1:M    | `Matches.team1_id`, `team2_id` | 1 ทีมแข่งหลายแมตช์    |
| Stadiums  | Matches        | 1:M    | `Matches.stadium_id`           | 1 สนามใช้หลายแมตช์    |
| Matches   | Goals          | 1:M    | `Goals.match_id`               | 1 แมตช์มีหลายประตู    |
| Players   | Goals          | 1:M    | `Goals.player_id`              | 1 นักเตะยิงหลายประตู  |
| Matches   | MatchReferees  | 1:M    | `MatchReferees.match_id`       | 1 แมตช์มีหลายกรรมการ  |
| Referees  | MatchReferees  | 1:M    | `MatchReferees.referee_id`     | 1 กรรมการทำหลายแมตช์  |

---

## 7. Flow การทำงานทั้งหมด

### 7.1 Flow: แสดงรายการนักกีฬา

```
Browser Request: GET /players
        │
        ▼
┌─────────────────────────────────────────────────────────────┐
│  routes/web.php                                              │
│  Route::resource('players', PlayersController::class);       │
│  → เลือก method: GET + /players = index()                   │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  PlayersController.php                                       │
│  public function index() {                                   │
│      $players = DB::table('Players')->get();                │
│      return view('players.index', compact('players'));       │
│  }                                                           │
└──────────────────────┬──────────────────────────────────────┘
                       │
         ┌─────────────┴─────────────┐
         │                           │
         ▼                           ▼
┌─────────────────┐        ┌─────────────────────────┐
│    Database     │        │  players/index.blade.php │
│                 │        │                          │
│ SELECT * FROM   │        │  @foreach($players)      │
│ Players;        │        │     {{ $player->... }}   │
│                 │        │  @endforeach             │
│ Returns 10 rows │        │                          │
└─────────────────┘        └───────────┬──────────────┘
                                       │
                                       ▼
                           ┌─────────────────────────┐
                           │     HTML Response       │
                           │  <table>                │
                           │    <tr>Player 1</tr>    │
                           │    <tr>Player 2</tr>    │
                           │    ...                  │
                           │  </table>               │
                           └─────────────────────────┘
```

### 7.2 Flow: เพิ่มนักกีฬาใหม่

```
1. Browser: GET /players/create
        │
        ▼
┌─────────────────────────────────────────────────────────────┐
│  PlayersController::create()                                 │
│  {                                                           │
│      $teams = DB::table('Teams')->get();                    │
│      return view('players.create', compact('teams'));        │
│  }                                                           │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  players/create.blade.php                                    │
│  <form action="{{ route('players.store') }}" method="POST"> │
│      @csrf                                                   │
│      <input name="player_id" ...>                           │
│      <select name="team_id">                                │
│          @foreach($teams as $team)                          │
│              <option value="{{ $team->team_id }}">          │
│          @endforeach                                        │
│      </select>                                              │
│      ...                                                    │
│      <button type="submit">บันทึก</button>                  │
│  </form>                                                    │
└─────────────────────────────────────────────────────────────┘

2. User กรอกข้อมูลแล้วกด "บันทึก"
        │
        ▼
3. Browser: POST /players (พร้อม form data)
        │
        ▼
┌─────────────────────────────────────────────────────────────┐
│  PlayersController::store(Request $request)                  │
│  {                                                           │
│      $request->validate([...]);  // ตรวจสอบข้อมูล           │
│                                                              │
│      DB::table('Players')->insert([                         │
│          'player_id' => $request->player_id,                │
│          'team_id' => $request->team_id,                    │
│          ...                                                │
│      ]);                                                    │
│                                                              │
│      return redirect()->route('players.index')              │
│                       ->with('success', '...');             │
│  }                                                           │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
4. Database: INSERT INTO Players (...) VALUES (...)
        │
        ▼
5. Browser: Redirect to GET /players (กลับหน้า index)
        │
        ▼
6. แสดง flash message "Player created successfully."
```

---

## 8. สรุปตัวแปรสำคัญ

### 8.1 ตัวแปรใน Controller

| ตัวแปร                 | ประเภท       | มาจาก                       | ใช้ทำอะไร                          |
| ---------------------- | ------------ | --------------------------- | ---------------------------------- |
| `$request`             | `Request`    | Parameter ของ method        | รับข้อมูลจาก form                  |
| `$request->field_name` | `mixed`      | Input ในฟอร์ม               | ค่าจาก `<input name="field_name">` |
| `$id`                  | `string`     | URL parameter               | ID ที่ต้องการ edit/delete          |
| `$players`             | `Collection` | `DB::table()->get()`        | รายการนักกีฬาทั้งหมด               |
| `$player`              | `object`     | `DB::table()->first()`      | นักกีฬา 1 คน                       |
| `$teams`               | `Collection` | `DB::table('Teams')->get()` | รายการทีมสำหรับ dropdown           |

### 8.2 ตัวแปรใน View

| ตัวแปร               | มาจาก                           | ใช้ใน View                      |
| -------------------- | ------------------------------- | ------------------------------- |
| `$players`           | `compact('players')`            | `@foreach($players as $player)` |
| `$player`            | `@foreach($players as $player)` | `{{ $player->first_name }}`     |
| `$teams`             | `compact('teams')`              | `@foreach($teams as $team)`     |
| `session('success')` | `->with('success', '...')`      | แสดง flash message              |

### 8.3 Blade Directives ที่ใช้

| Directive             | หน้าที่                       | ตัวอย่าง                       |
| --------------------- | ----------------------------- | ------------------------------ |
| `@extends('layout')`  | สืบทอด layout template        | ใช้ทุกหน้า                     |
| `@section('name')`    | กำหนดเนื้อหาสำหรับ yield      | `@section('content')`          |
| `@yield('name')`      | แสดงเนื้อหาที่กำหนดใน section | ใน `layout.blade.php`          |
| `@csrf`               | ป้อง CSRF token               | ใส่ในทุก `<form>`              |
| `@method('PUT')`      | กำหนด HTTP method             | สำหรับ update/delete           |
| `@foreach`            | วนลูปแสดงข้อมูล               | `@foreach($items as $item)`    |
| `@if` / `@endif`      | เงื่อนไข                      | `@if(session('success'))`      |
| `{{ $var }}`          | แสดงค่า (escaped)             | `{{ $player->name }}`          |
| `{{ route('name') }}` | สร้าง URL จากชื่อ route       | `{{ route('players.index') }}` |

---

## 9. ตัวอย่างการเชื่อมต่อแบบละเอียด

### กรณี: แสดงชื่อนักกีฬาพร้อมชื่อทีม

**ปัญหา**: ตาราง Players มีแค่ `team_id` ไม่มีชื่อทีม

**วิธีแก้**: ใช้ JOIN

```php
// PlayersController.php
public function index()
{
    $players = DB::table('Players')
        ->join('Teams', 'Players.team_id', '=', 'Teams.team_id')
        ->join('Countries', 'Teams.country_id', '=', 'Countries.country_id')
        ->select('Players.*', 'Teams.coach_name', 'Countries.country_name')
        ->get();

    return view('players.index', compact('players'));
}
```

```blade
{{-- players/index.blade.php --}}
@foreach($players as $player)
<tr>
    <td>{{ $player->first_name }}</td>
    <td>{{ $player->coach_name }}</td>      {{-- จาก Teams --}}
    <td>{{ $player->country_name }}</td>    {{-- จาก Countries --}}
</tr>
@endforeach
```

---

## 10. คำสั่ง Artisan ที่ใช้สร้างโปรเจค

```bash
# สร้าง Controller แบบ Resource (มี 7 methods)
php artisan make:controller PlayersController --resource
php artisan make:controller TeamsController --resource
php artisan make:controller MatchesController --resource
# ... เหมือนกันทุกตัว

# ดู Routes ทั้งหมด
php artisan route:list

# รัน Server
php artisan serve
```

---

## 11. Checklist ความเข้าใจ

-   [ ] เข้าใจการทำงานของ `Route::resource()`
-   [ ] เข้าใจ 7 methods ใน Resource Controller (index, create, store, show, edit, update, destroy)
-   [ ] เข้าใจการใช้ `DB::table()` แทน Model
-   [ ] เข้าใจ `$request->validate()` และ `$request->field_name`
-   [ ] เข้าใจ `view('folder.file', compact('var'))`
-   [ ] เข้าใจ Blade: `@extends`, `@section`, `@yield`, `@foreach`, `@csrf`, `@method`
-   [ ] เข้าใจความสัมพันธ์ระหว่างตาราง (Foreign Keys)
-   [ ] เข้าใจ Flash Messages: `->with('success', '...')` และ `session('success')`

---

_สร้างเอกสารเมื่อ: 15 ธันวาคม 2024_  
_อัปเดตล่าสุด: 15 ธันวาคม 2024 เวลา 23:25 น._
