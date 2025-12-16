# 📋 ระบบ Goals (การทำประตู)

## 🗂️ โครงสร้างไฟล์

```
├── routes/web.php                              # กำหนด URL
├── app/Http/Controllers/GoalsController.php    # จัดการ Logic
└── resources/views/goals/
    ├── index.blade.php    # หน้าแสดงรายการ
    ├── create.blade.php   # หน้าเพิ่มข้อมูล
    └── edit.blade.php     # หน้าแก้ไขข้อมูล
```

---

## 📍 1. Routes (web.php)

```php
<?php
use App\Http\Controllers\GoalsController;

// Route::resource สร้าง 7 routes อัตโนมัติ:
// GET /goals           → index()    แสดงรายการ
// GET /goals/create    → create()   แสดงฟอร์มสร้าง
// POST /goals          → store()    บันทึกข้อมูลใหม่
// GET /goals/{id}/edit → edit()     แสดงฟอร์มแก้ไข
// PUT /goals/{id}      → update()   อัปเดตข้อมูล
// DELETE /goals/{id}   → destroy()  ลบข้อมูล
Route::resource('goals', GoalsController::class);
```

---

## 🎮 2. Controller (GoalsController.php)

```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;  // รับข้อมูลจาก Form
use DB;                        // ใช้ Query ฐานข้อมูล

class GoalsController extends Controller
{
    // ===================== แสดงรายการทั้งหมด =====================
    // URL: GET /goals
    public function index()
    {
        // ดึงข้อมูลทั้งหมดจากตาราง Goals (SELECT * FROM Goals)
        $goals = DB::table('Goals')->get();

        // ส่งตัวแปร $goals ไปแสดงที่ views/goals/index.blade.php
        return view('goals.index', compact('goals'));
    }

    // ===================== แสดงฟอร์มสร้างข้อมูล =====================
    // URL: GET /goals/create
    public function create()
    {
        // ดึง Matches มาให้เลือกใน Dropdown (ประตูเกิดในแมทช์ไหน)
        $matches = DB::table('Matches')->get();

        // ดึง Players มาให้เลือกใน Dropdown (ใครทำประตู)
        $players = DB::table('Players')->get();

        // ส่งไป views/goals/create.blade.php
        return view('goals.create', compact('matches', 'players'));
    }

    // ===================== บันทึกข้อมูลใหม่ =====================
    // URL: POST /goals
    public function store(Request $request)
    {
        // ตรวจสอบว่ากรอกครบ (required = ห้ามว่าง)
        $request->validate([
            'goal_id' => 'required',
            'match_id' => 'required',
            'player_id' => 'required',
            'goal_time' => 'required',
            'is_penalty' => 'required',
        ]);

        try {
            // INSERT INTO Goals VALUES(...)
            DB::table('Goals')->insert([
                'goal_id' => $request->goal_id,      // รับค่าจาก input name="goal_id"
                'match_id' => $request->match_id,
                'player_id' => $request->player_id,
                'goal_time' => $request->goal_time,
                'is_penalty' => $request->is_penalty,
            ]);

            // กลับหน้า index พร้อมข้อความสำเร็จ
            return redirect()->route('goals.index')->with('success', 'สร้างสำเร็จ');

        } catch (\Exception $e) {
            // ถ้า Error (เช่น ID ซ้ำ) แจ้งล้มเหลว
            return redirect()->route('goals.index')->with('failed', 'สร้างล้มเหลว');
        }
    }

    // ===================== แสดงฟอร์มแก้ไข =====================
    // URL: GET /goals/{id}/edit
    public function edit(string $id)
    {
        // ดึงข้อมูลที่ต้องการแก้ไข (WHERE goal_id = $id)
        $goals = DB::table('Goals')->where('goal_id', $id)->get();

        // ดึง Matches และ Players สำหรับ Dropdown
        $matches = DB::table('Matches')->get();
        $players = DB::table('Players')->get();

        // ส่งไป views/goals/edit.blade.php
        return view('goals.edit', compact('goals', 'matches', 'players'));
    }

    // ===================== อัปเดตข้อมูล =====================
    // URL: PUT /goals/{id}
    public function update(Request $request, string $id)
    {
        // ตรวจสอบข้อมูล (ไม่ต้อง validate goal_id เพราะแก้ไขไม่ได้)
        $request->validate([
            'match_id' => 'required',
            'player_id' => 'required',
            'goal_time' => 'required',
            'is_penalty' => 'required',
        ]);

        try {
            // UPDATE Goals SET ... WHERE goal_id = $id
            DB::table('Goals')->where('goal_id', $id)->update([
                'match_id' => $request->match_id,
                'player_id' => $request->player_id,
                'goal_time' => $request->goal_time,
                'is_penalty' => $request->is_penalty,
            ]);

            return redirect()->route('goals.index')->with('success', 'แก้ไขสำเร็จ');

        } catch (\Exception $e) {
            return redirect()->route('goals.index')->with('failed', 'แก้ไขล้มเหลว');
        }
    }

    // ===================== ลบข้อมูล =====================
    // URL: DELETE /goals/{id}
    public function destroy(string $id)
    {
        try {
            // DELETE FROM Goals WHERE goal_id = $id
            DB::table('Goals')->where('goal_id', $id)->delete();

            return redirect()->route('goals.index')->with('success', 'ลบสำเร็จ');

        } catch (\Exception $e) {
            return redirect()->route('goals.index')->with('failed', 'ลบล้มเหลว');
        }
    }
}
```

---

## 📄 3. Views

### 3.1 layout.blade.php (Template หลัก)

```html
<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        {{-- รับ Title จาก Child View --}}
        <link href="bootstrap.css" rel="stylesheet" />
        {{-- CSS Bootstrap --}}
    </head>
    <body>
        <nav>...</nav>
        {{-- เมนู --}}

        <div class="container">
            @yield('content') {{-- รับเนื้อหาจาก Child View --}}
        </div>
    </body>
</html>
```

### 3.2 index.blade.php (หน้าแสดงรายการ)

```blade
@extends('layout')  {{-- สืบทอดจาก layout.blade.php --}}
@section('title', 'ตารางประตู')  {{-- ส่ง Title ไปที่ @yield('title') --}}

@section('content')  {{-- เริ่มเนื้อหาที่จะใส่ใน @yield('content') --}}

    {{-- ปุ่มไปหน้าเพิ่มข้อมูล --}}
    <a href="{{ route('goals.create') }}">
        <button class="btn btn-success">เพิ่มข้อมูล</button>
    </a>

    {{-- แสดง Flash Message หลัง redirect --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ตารางแสดงข้อมูล --}}
    <table class="table">
        <thead>
            <tr>
                <th>รหัส</th>
                <th>แมทช์</th>
                <th>นักเตะ</th>
                <th>เวลา</th>
                <th>ลูกโทษ</th>
                <th>ดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            {{-- วน Loop แสดงข้อมูลแต่ละแถว --}}
            @foreach($goals as $go)
            <tr>
                <td>{{ $go->goal_id }}</td>    {{-- แสดงค่าจาก Object --}}
                <td>{{ $go->match_id }}</td>
                <td>{{ $go->player_id }}</td>
                <td>{{ $go->goal_time }}</td>
                <td>{{ $go->is_penalty }}</td>
                <td>
                    {{-- ปุ่มแก้ไข --}}
                    <a href="{{ route('goals.edit', $go->goal_id) }}">
                        <button class="btn btn-warning">แก้ไข</button>
                    </a>

                    {{-- ฟอร์มลบ --}}
                    <form action="{{ route('goals.destroy', $go->goal_id) }}" method="POST">
                        @csrf                 {{-- Token ป้องกัน CSRF Attack --}}
                        @method('DELETE')     {{-- บอก Laravel ว่าเป็น DELETE --}}
                        <button class="btn btn-danger">ลบ</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection  {{-- จบ Section --}}
```

### 3.3 create.blade.php (หน้าเพิ่มข้อมูล)

```blade
@extends('layout')
@section('content')

    {{-- ส่งฟอร์มไป store() --}}
    <form action="{{ route('goals.store') }}" method="POST">
        @csrf  {{-- Token ป้องกัน CSRF --}}

        {{-- Input รหัสประตู --}}
        <input type="text" name="goal_id" placeholder="รหัสประตู">

        {{-- Dropdown เลือกแมทช์ --}}
        <select name="match_id">
            @foreach ($matches as $match)
                <option value="{{ $match->match_id }}">
                    {{ $match->match_id }} - {{ $match->team1_id }} vs {{ $match->team2_id }}
                </option>
            @endforeach
        </select>

        {{-- Dropdown เลือกนักเตะ --}}
        <select name="player_id">
            @foreach ($players as $player)
                <option value="{{ $player->player_id }}">
                    {{ $player->first_name }} {{ $player->last_name }}
                </option>
            @endforeach
        </select>

        <input type="text" name="goal_time" placeholder="นาทีที่ทำประตู">
        <input type="text" name="is_penalty" placeholder="ลูกโทษ (0/1)">

        <a href="{{ route('goals.index') }}" class="btn btn-danger">ยกเลิก</a>
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>

@endsection
```

### 3.4 edit.blade.php (หน้าแก้ไข)

```blade
@extends('layout')
@section('content')

    {{-- ดึง $go ออกมาจาก Collection --}}
    @foreach($goals as $go)
    @endforeach

    {{-- ส่งฟอร์มไป update() พร้อม ID --}}
    <form action="{{ route('goals.update', $go->goal_id) }}" method="POST">
        @csrf
        @method('PUT')  {{-- บอก Laravel ว่าเป็น PUT (แก้ไข) --}}

        {{-- readonly = แก้ไขไม่ได้ เพราะ Primary Key --}}
        <input type="text" name="goal_id" value="{{ $go->goal_id }}" readonly>

        {{-- แสดงค่าเดิมใน Input --}}
        <input type="text" name="goal_time" value="{{ $go->goal_time }}">
        <input type="text" name="is_penalty" value="{{ $go->is_penalty }}">

        {{-- Dropdown เหมือน create --}}
        <select name="match_id">...</select>
        <select name="player_id">...</select>

        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>

@endsection
```

---

## 🔄 4. แผนผังการทำงาน

```
┌─────────────────────────────────────────────────────────────────┐
│                        FLOW การทำงาน                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│   User เข้าเว็บ                                                  │
│        │                                                        │
│        ▼                                                        │
│   web.php (Route)  ─────────────►  GoalsController              │
│                                           │                     │
│                                           ▼                     │
│                                    Query Database               │
│                                           │                     │
│                                           ▼                     │
│                               return view('goals.xxx')          │
│                                           │                     │
│                                           ▼                     │
│                          xxx.blade.php + layout.blade.php       │
│                                           │                     │
│                                           ▼                     │
│                                    แสดงหน้าเว็บ                   │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

```
┌─────────────────────────────────────────────────────────────────┐
│                         CRUD Operations                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  📖 READ:    GET /goals → index() → SELECT * → แสดงตาราง        │
│                                                                 │
│  ➕ CREATE:  GET /goals/create → create() → แสดงฟอร์ม            │
│              POST /goals → store() → INSERT → redirect          │
│                                                                 │
│  ✏️ UPDATE:  GET /goals/{id}/edit → edit() → แสดงฟอร์ม+ค่าเดิม   │
│              PUT /goals/{id} → update() → UPDATE → redirect     │
│                                                                 │
│  🗑️ DELETE:  DELETE /goals/{id} → destroy() → DELETE → redirect │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔑 5. สรุปสั้นๆ

| คำสั่ง                           | ความหมาย                      |
| -------------------------------- | ----------------------------- |
| `Route::resource()`              | สร้าง 7 routes CRUD อัตโนมัติ |
| `DB::table()->get()`             | SELECT \*                     |
| `DB::table()->insert()`          | INSERT INTO                   |
| `DB::table()->where()->update()` | UPDATE WHERE                  |
| `DB::table()->where()->delete()` | DELETE WHERE                  |
| `compact('x')`                   | สร้าง `['x' => $x]`           |
| `@extends('layout')`             | สืบทอด Template               |
| `@section('content')`            | กำหนดเนื้อหา                  |
| `@yield('content')`              | รับเนื้อหา                    |
| `@foreach ... @endforeach`       | วน Loop                       |
| `{{ $var }}`                     | แสดงค่าตัวแปร                 |
| `{{ route('name') }}`            | สร้าง URL                     |
| `@csrf`                          | ป้องกัน CSRF                  |
| `@method('PUT/DELETE')`          | กำหนด HTTP Method             |
