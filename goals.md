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

**หน้าที่:** เป็น Template กลางที่ทุก View ใช้ร่วมกัน ไม่ต้องเขียน HTML ซ้ำๆ

**หลักการทำงาน:**

-   `@yield('title')` = ช่องว่างรอรับ Title จาก Child View
-   `@yield('content')` = ช่องว่างรอรับเนื้อหาจาก Child View
-   Child View ใช้ `@extends('layout')` เพื่อสืบทอด Template นี้
-   Child View ใช้ `@section('title', '...')` และ `@section('content')` เพื่อใส่ข้อมูลลงช่องว่าง

```html
<!DOCTYPE html>
<html>
    <head>
        {{-- @yield('title') = รับค่าจาก @section('title', 'ตารางประตู') ของ
        Child View --}} {{-- ผลลัพธ์:
        <title>ตารางประตู</title>
        --}}
        <title>@yield('title')</title>

        {{-- โหลด CSS Bootstrap จาก CDN --}}
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />
    </head>
    <body>
        {{-- Navbar ใช้ร่วมกันทุกหน้า --}}
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Football</a>
            <ul class="navbar-nav">
                <li><a href="/">หน้าแรก</a></li>
                <li><a href="/goals">ตารางประตู</a></li>
                <li><a href="/players">นักกีฬา</a></li>
                {{-- เมนูอื่นๆ --}}
            </ul>
        </nav>

        {{-- container = กล่องครอบเนื้อหาให้อยู่กลางหน้าจอ --}} {{-- py-5 =
        padding บนล่าง 5 หน่วย --}}
        <div class="container py-5">
            {{-- @yield('content') = รับเนื้อหาจาก @section('content') ของ Child
            View --}} {{-- เนื้อหาจาก index.blade.php, create.blade.php,
            edit.blade.php จะมาแสดงตรงนี้ --}} @yield('content')
        </div>
    </body>
</html>
```

**สรุป:** Layout เป็น "กรอบ" ที่มี navbar และ container พร้อมแล้ว Child View แค่ส่งเนื้อหามาใส่

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
                    {{-- =============== ปุ่มแก้ไข =============== --}}
                    {{-- route('goals.edit', $go->goal_id) สร้าง URL เป็น /goals/5/edit --}}
                    {{-- เมื่อคลิก จะเรียก GoalsController@edit(5) --}}
                    {{-- Controller จะดึงข้อมูล goal_id=5 แล้วส่งไป edit.blade.php --}}
                    <a href="{{ route('goals.edit', $go->goal_id) }}">
                        <button class="btn btn-warning">แก้ไข</button>
                    </a>

                    {{-- =============== ปุ่มลบ =============== --}}
                    {{-- ต้องใช้ Form เพราะการลบเป็น DELETE Request --}}
                    {{-- action ชี้ไป /goals/5 พร้อม method DELETE --}}
                    {{-- เมื่อกดลบ จะเรียก GoalsController@destroy(5) --}}
                    <form action="{{ route('goals.destroy', $go->goal_id) }}" method="POST">
                        @csrf                 {{-- Token ป้องกัน CSRF Attack (จำเป็น) --}}
                        @method('DELETE')     {{-- บอก Laravel ว่าเป็น DELETE (HTML รองรับแค่ GET/POST) --}}
                        <button class="btn btn-danger">ลบ</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection  {{-- จบ Section --}}
```

---

### 🔄 Flow ปุ่มแก้ไข (ละเอียด)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                          FLOW ปุ่มแก้ไข                                      │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│   1. User คลิกปุ่ม "แก้ไข" ที่แถว goal_id = 5                                │
│      ↓                                                                      │
│   2. <a href="{{ route('goals.edit', 5) }}">                                │
│      สร้าง URL: /goals/5/edit                                               │
│      ↓                                                                      │
│   3. Browser ส่ง GET Request ไป /goals/5/edit                               │
│      ↓                                                                      │
│   4. web.php จับ Route → เรียก GoalsController@edit(5)                      │
│      ↓                                                                      │
│   5. Controller ดึงข้อมูล:                                                   │
│      $goals = DB::table('Goals')->where('goal_id', 5)->get();               │
│      ↓                                                                      │
│   6. Controller ส่งไป View:                                                  │
│      return view('goals.edit', compact('goals', 'matches', 'players'));     │
│      ↓                                                                      │
│   7. edit.blade.php แสดงฟอร์มพร้อมค่าเดิม                                    │
│      <input value="{{ $go->goal_time }}">                                   │
│      ↓                                                                      │
│   8. User แก้ไขข้อมูล แล้วกดปุ่ม "บันทึก"                                     │
│      ↓                                                                      │
│   9. Form ส่ง PUT Request ไป /goals/5                                       │
│      <form action="{{ route('goals.update', 5) }}" method="POST">           │
│      @method('PUT')                                                         │
│      ↓                                                                      │
│   10. web.php จับ Route → เรียก GoalsController@update(5)                   │
│       ↓                                                                     │
│   11. Controller อัปเดตข้อมูล:                                               │
│       DB::table('Goals')->where('goal_id', 5)->update([...]);               │
│       ↓                                                                     │
│   12. Controller redirect กลับหน้า index พร้อม Flash Message                 │
│       return redirect()->route('goals.index')->with('success', '...');      │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

### 🗑️ Flow ปุ่มลบ (ละเอียด)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           FLOW ปุ่มลบ                                        │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│   1. User คลิกปุ่ม "ลบ" ที่แถว goal_id = 5                                   │
│      ↓                                                                      │
│   2. Form ส่ง POST Request พร้อม _method=DELETE ไป /goals/5                 │
│      <form action="/goals/5" method="POST">                                 │
│      <input name="_method" value="DELETE">  ← จาก @method('DELETE')         │
│      <input name="_token" value="xxx">      ← จาก @csrf                     │
│      ↓                                                                      │
│   3. Laravel อ่าน _method แล้วเข้าใจว่าเป็น DELETE Request                   │
│      ↓                                                                      │
│   4. web.php จับ Route → เรียก GoalsController@destroy(5)                   │
│      ↓                                                                      │
│   5. Controller ลบข้อมูล:                                                    │
│      DB::table('Goals')->where('goal_id', 5)->delete();                     │
│      ↓                                                                      │
│   6. Controller redirect กลับหน้า index พร้อม Flash Message                 │
│      return redirect()->route('goals.index')->with('success', 'ลบสำเร็จ');  │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

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

## 🔑 5. สรุปคำสั่งสำคัญ

### 📌 Routes

| คำสั่ง                                             | ความหมาย                                                                                                   | ตัวอย่าง                                               |
| -------------------------------------------------- | ---------------------------------------------------------------------------------------------------------- | ------------------------------------------------------ |
| `Route::resource('goals', GoalsController::class)` | สร้าง 7 routes CRUD อัตโนมัติ ได้แก่ index, create, store, show, edit, update, destroy ไม่ต้องเขียนทีละอัน | `Route::resource('players', PlayersController::class)` |

---

### 📌 Database Query (DB Facade)

| คำสั่ง                                                     | SQL ที่ได้                                                           | ตัวอย่าง                                                               |
| ---------------------------------------------------------- | -------------------------------------------------------------------- | ---------------------------------------------------------------------- |
| `DB::table('Goals')->get()`                                | `SELECT * FROM Goals` ดึงข้อมูลทั้งหมดจากตาราง                       | `$goals = DB::table('Goals')->get()`                                   |
| `DB::table('Goals')->where('goal_id', $id)->get()`         | `SELECT * FROM Goals WHERE goal_id = $id` ดึงข้อมูลตามเงื่อนไข       | `$goals = DB::table('Goals')->where('goal_id', 5)->get()`              |
| `DB::table('Goals')->insert([...])`                        | `INSERT INTO Goals VALUES(...)` เพิ่มข้อมูลใหม่ลงตาราง               | `DB::table('Goals')->insert(['goal_id' => 1, 'match_id' => 10])`       |
| `DB::table('Goals')->where('goal_id', $id)->update([...])` | `UPDATE Goals SET ... WHERE goal_id = $id` แก้ไขข้อมูลที่ตรงเงื่อนไข | `DB::table('Goals')->where('goal_id', 5)->update(['goal_time' => 45])` |
| `DB::table('Goals')->where('goal_id', $id)->delete()`      | `DELETE FROM Goals WHERE goal_id = $id` ลบข้อมูลที่ตรงเงื่อนไข       | `DB::table('Goals')->where('goal_id', 5)->delete()`                    |

---

### 📌 Controller Helper

| คำสั่ง                                  | ความหมาย                                                                                | ตัวอย่าง                                                                                                 |
| --------------------------------------- | --------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------- |
| `compact('goals')`                      | สร้าง array `['goals' => $goals]` เพื่อส่งตัวแปรไป View แบบย่อ                          | `return view('goals.index', compact('goals'))` เท่ากับ `return view('goals.index', ['goals' => $goals])` |
| `view('goals.index', compact('goals'))` | โหลดไฟล์ `resources/views/goals/index.blade.php` และส่งตัวแปร $goals ไปให้ใช้ได้ใน View | `return view('goals.create', compact('matches', 'players'))`                                             |
| `redirect()->route('goals.index')`      | เปลี่ยนหน้าไปที่ Route ชื่อ goals.index (หน้า /goals)                                   | `return redirect()->route('goals.index')`                                                                |
| `->with('success', 'ข้อความ')`          | ส่ง Flash Message ไปแสดงหลัง redirect (ใช้ครั้งเดียวแล้วหาย)                            | `return redirect()->route('goals.index')->with('success', 'สร้างสำเร็จ')`                                |
| `$request->validate([...])`             | ตรวจสอบข้อมูลจาก Form ถ้าไม่ผ่านจะ redirect กลับพร้อม Error อัตโนมัติ                   | `$request->validate(['goal_id' => 'required'])`                                                          |
| `$request->goal_id`                     | รับค่าจาก input ที่มี `name="goal_id"` ใน Form                                          | `'goal_id' => $request->goal_id`                                                                         |

---

### 📌 Blade Template (สำหรับ View)

| คำสั่ง                                    | ความหมาย                                                                       | ตัวอย่าง                    |
| ----------------------------------------- | ------------------------------------------------------------------------------ | --------------------------- |
| `@extends('layout')`                      | สืบทอดจากไฟล์ `layout.blade.php` ทำให้ไม่ต้องเขียน HTML ซ้ำ (navbar, head ฯลฯ) | View ทุกไฟล์ต้องมีบรรทัดนี้ |
| `@section('content')`                     | เริ่มกำหนดเนื้อหาที่จะถูกใส่ลงใน `@yield('content')` ของ layout                | ใช้คู่กับ `@endsection`     |
| `@yield('content')`                       | ช่องว่างใน layout ที่รอรับเนื้อหาจาก `@section('content')` ของ Child View      | อยู่ใน layout.blade.php     |
| `@endsection`                             | จบ section ที่เปิดไว้                                                          | ต้องมีหลัง `@section` เสมอ  |
| `@foreach($goals as $go)`                 | วน Loop ข้อมูลใน $goals โดยแต่ละรอบเก็บใน $go                                  | ใช้คู่กับ `@endforeach`     |
| `@if (condition)`                         | เงื่อนไข ถ้าเป็นจริงจะแสดงเนื้อหาข้างใน                                        | ใช้คู่กับ `@endif`          |
| `{{ $go->goal_id }}`                      | แสดงค่า property `goal_id` จาก Object $go (พร้อม Escape HTML ป้องกัน XSS)      | แสดงตรงๆ บนหน้าเว็บ         |
| `{{ route('goals.create') }}`             | สร้าง URL จากชื่อ Route ได้ `/goals/create` ไม่ต้อง hardcode URL               | ใช้ใน href หรือ action      |
| `{{ route('goals.edit', $go->goal_id) }}` | สร้าง URL พร้อมส่ง parameter ได้ `/goals/5/edit`                               | ใส่ ID เข้าไปใน URL         |

---

### 📌 Form Security

| คำสั่ง              | ความหมาย                                                                                                    | ทำไมต้องใช้                                                             |
| ------------------- | ----------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------- |
| `@csrf`             | สร้าง hidden input `<input type="hidden" name="_token" value="xxx">` ป้องกัน Cross-Site Request Forgery     | **ต้องใส่ทุก Form ที่เป็น POST/PUT/DELETE** ถ้าไม่ใส่จะ Error 419       |
| `@method('PUT')`    | สร้าง hidden input `<input type="hidden" name="_method" value="PUT">` บอก Laravel ว่าเป็น PUT Request       | HTML Form รองรับแค่ GET/POST ต้องใช้ @method บอกว่าเป็น PUT หรือ DELETE |
| `@method('DELETE')` | สร้าง hidden input `<input type="hidden" name="_method" value="DELETE">` บอก Laravel ว่าเป็น DELETE Request | ใช้กับปุ่มลบ                                                            |

---

### 📌 Flash Message

```blade
{{-- ใน Controller --}}
return redirect()->route('goals.index')->with('success', 'สร้างสำเร็จ');

{{-- ใน View --}}
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
```

-   `session('success')` รับค่าจาก `->with('success', '...')` แสดงครั้งเดียวแล้วหายไป
