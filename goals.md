# 📋 ระบบ Goals (บันทึกการยิงประตู)

## 🗂️ ไฟล์ที่เกี่ยวข้อง

```
├── routes/web.php                     → บอกว่า URL ไหน ไปหน้าไหน
├── app/Http/Controllers/GoalsController.php  → สมองของระบบ ประมวลผลทุกอย่าง
└── resources/views/goals/
    ├── index.blade.php   → หน้าดูรายการทั้งหมด
    ├── create.blade.php  → หน้ากรอกข้อมูลใหม่
    └── edit.blade.php    → หน้าแก้ไขข้อมูล
```

---

## 🔗 ไฟล์เชื่อมต่อกันยังไง? (Connection Map)

### 🗺️ แผนที่ง่ายๆ (เข้าใจได้ใน 1 นาที!)

```
╔════════════════════════════════════════════════════════════════════════╗
║                        🚗 เส้นทางการเดินทางของข้อมูล                    ║
╠════════════════════════════════════════════════════════════════════════╣
║                                                                        ║
║   👤 คนเปิดเว็บ     →    📍 Routes     →    🎮 Controller    →   📄 View  ║
║   พิมพ์ URL             บอกทาง             ทำงาน               แสดงผล   ║
║                                               ↕                        ║
║                                          🗄️ Database                   ║
║                                            เก็บข้อมูล                   ║
╚════════════════════════════════════════════════════════════════════════╝
```

### 📌 ตารางการเชื่อมต่อ (ใครคุยกับใคร?)

| ไฟล์ต้นทาง         | เชื่อมไปที่               | ทำอะไร?                                     |
| ------------------ | ------------------------- | ------------------------------------------- |
| `web.php`          | `GoalsController`         | บอกว่า URL `/goals` ให้ไปที่ Controller นี้ |
| `GoalsController`  | ตาราง `Goals` ใน Database | ดึงข้อมูล/เพิ่ม/แก้/ลบ                      |
| `GoalsController`  | `index.blade.php`         | ส่งข้อมูลไปแสดงที่หน้ารายการ                |
| `GoalsController`  | `create.blade.php`        | เปิดหน้าฟอร์มเพิ่มข้อมูล                    |
| `GoalsController`  | `edit.blade.php`          | เปิดหน้าฟอร์มแก้ไขข้อมูล                    |
| `index.blade.php`  | `layout.blade.php`        | ใช้กรอบหน้าเดียวกัน (เมนู, ส่วนหัว)         |
| `create.blade.php` | `layout.blade.php`        | ใช้กรอบหน้าเดียวกัน                         |
| `edit.blade.php`   | `layout.blade.php`        | ใช้กรอบหน้าเดียวกัน                         |

---

### 🎨 ตารางที่เกี่ยวข้อง (ดึงข้อมูลจากไหน?)

**หน้า Goals ใช้ข้อมูลจาก 3 ตาราง:**

| ตาราง     | ใช้ทำอะไร?                                 | Method ที่ใช้        |
| --------- | ------------------------------------------ | -------------------- |
| `Goals`   | เก็บข้อมูลการยิงประตู (รหัส, เวลา, ลูกโทษ) | ทุก Method           |
| `Matches` | ดึงมาให้เลือกว่ายิงในแมทช์ไหน              | `create()`, `edit()` |
| `Players` | ดึงมาให้เลือกว่าใครยิง                     | `create()`, `edit()` |

---

### 🔀 Flow ของแต่ละปุ่ม (กดปุ่มแล้วเกิดอะไร?)

#### 1️⃣ ปุ่ม "เพิ่มข้อมูล" (ในหน้า Index)

```
กดปุ่ม → URL: /goals/create → Controller: create() → View: create.blade.php
```

**อธิบาย:** กดปุ่มสีเขียว "เพิ่มข้อมูล" → ไปหน้ากรอกฟอร์ม

#### 2️⃣ ปุ่ม "บันทึก" (ในหน้า Create)

```
กดปุ่ม → POST /goals → Controller: store() → Database INSERT → กลับหน้า Index
```

**อธิบาย:** กดปุ่มบันทึก → Controller เอาข้อมูลไปเก็บในฐานข้อมูล → กลับหน้าแรก

#### 3️⃣ ปุ่ม "แก้ไข" (ในหน้า Index)

```
กดปุ่ม → URL: /goals/5/edit → Controller: edit(5) → View: edit.blade.php
```

**อธิบาย:** กดปุ่มสีเหลือง "แก้ไข" → ไปหน้าแก้ข้อมูล (พร้อมข้อมูลเดิม)

#### 4️⃣ ปุ่ม "บันทึก" (ในหน้า Edit)

```
กดปุ่ม → PUT /goals/5 → Controller: update(5) → Database UPDATE → กลับหน้า Index
```

**อธิบาย:** กดปุ่มบันทึก → Controller แก้ข้อมูลในฐานข้อมูล → กลับหน้าแรก

#### 5️⃣ ปุ่ม "ลบ" (ในหน้า Index)

```
กดปุ่ม → DELETE /goals/5 → Controller: destroy(5) → Database DELETE → กลับหน้า Index
```

**อธิบาย:** กดปุ่มสีแดง "ลบ" → Controller ลบข้อมูลออกจากฐานข้อมูล → กลับหน้าแรก

---

### 🏠 สรุปแบบเด็กๆ เข้าใจ

**คิดง่ายๆ เหมือนร้านอาหาร:**

-   **Routes (web.php)** = พนักงานต้อนรับ บอกว่าโต๊ะไหนนั่งตรงไหน
-   **Controller** = พ่อครัว รับออเดอร์แล้วทำอาหาร
-   **Database** = ตู้เย็น เก็บวัตถุดิบทั้งหมด
-   **View** = จานอาหาร ที่ลูกค้าเห็นและกินได้

```
ลูกค้าสั่ง (URL) → พนักงานรับ (Routes) → พ่อครัวทำ (Controller)
                                              ↕
                                        ตู้เย็น (Database)
                                              ↓
                                   เสิร์ฟอาหาร (View)
```

---

## 📍 1. Routes (web.php) - บอกทางให้เว็บ

```php
<?php
use App\Http\Controllers\GoalsController;

// บรรทัดนี้บรรทัดเดียว สร้าง 7 เส้นทางให้เราเลย!
// เหมือนบอกว่า "ถ้าคนเข้า /goals ให้ GoalsController จัดการ"
Route::resource('goals', GoalsController::class);

// 7 เส้นทางที่ได้คือ:
// /goals              → ดูรายการทั้งหมด (index)
// /goals/create       → หน้ากรอกข้อมูลใหม่ (create)
// /goals              → บันทึกข้อมูลใหม่ (store) ← ส่งจากฟอร์ม
// /goals/5/edit       → หน้าแก้ไขข้อมูล ID 5 (edit)
// /goals/5            → บันทึกการแก้ไข ID 5 (update) ← ส่งจากฟอร์ม
// /goals/5            → ลบข้อมูล ID 5 (destroy) ← กดปุ่มลบ
```

---

## 🎮 2. Controller (GoalsController.php) - สมองของระบบ

```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;  // ใช้รับข้อมูลจากฟอร์ม
use DB;                        // ใช้คุยกับฐานข้อมูล

class GoalsController extends Controller
{
    // ========== หน้าแรก: ดูข้อมูลทั้งหมด ==========
    // เมื่อคนเข้า /goals จะมาที่นี่
    public function index()
    {
        // ไปดึงข้อมูลทั้งหมดจากตาราง Goals มาเก็บไว้
        // เหมือนบอกว่า "เอาข้อมูลทุกแถวในตาราง Goals มาให้หน่อย"
        $goals = DB::table('Goals')->get();

        // ส่งข้อมูลไปแสดงที่หน้า index.blade.php
        // compact('goals') = ห่อตัวแปร $goals ส่งไปให้หน้าเว็บใช้
        return view('goals.index', compact('goals'));
    }

    // ========== หน้ากรอกข้อมูลใหม่ ==========
    // เมื่อคนกดปุ่ม "เพิ่มข้อมูล" จะมาที่นี่
    public function create()
    {
        // ดึงรายการแมทช์ทั้งหมดมา (ให้เลือกว่ายิงประตูในแมทช์ไหน)
        $matches = DB::table('Matches')->get();

        // ดึงรายการนักเตะทั้งหมดมา (ให้เลือกว่าใครยิง)
        $players = DB::table('Players')->get();

        // ส่งไปหน้ากรอกฟอร์ม พร้อมตัวเลือกแมทช์และนักเตะ
        return view('goals.create', compact('matches', 'players'));
    }

    // ========== บันทึกข้อมูลใหม่ลงฐานข้อมูล ==========
    // เมื่อคนกดปุ่ม "บันทึก" ในหน้า create จะมาที่นี่
    public function store(Request $request)
    {
        // ตรวจสอบว่ากรอกครบไหม (required = ต้องกรอก ห้ามว่าง)
        // ถ้ากรอกไม่ครบ ระบบจะส่งกลับหน้าฟอร์มพร้อมแจ้ง error อัตโนมัติ
        $request->validate([
            'goal_id' => 'required',     // รหัสประตู - ต้องกรอก
            'match_id' => 'required',    // แมทช์ไหน - ต้องเลือก
            'player_id' => 'required',   // ใครยิง - ต้องเลือก
            'goal_time' => 'required',   // นาทีที่ยิง - ต้องกรอก
            'is_penalty' => 'required',  // เป็นจุดโทษไหม - ต้องกรอก
        ]);

        try {
            // เอาข้อมูลจากฟอร์มไปใส่ในฐานข้อมูล
            // $request->goal_id = ค่าที่คนกรอกในช่อง goal_id
            DB::table('Goals')->insert([
                'goal_id' => $request->goal_id,
                'match_id' => $request->match_id,
                'player_id' => $request->player_id,
                'goal_time' => $request->goal_time,
                'is_penalty' => $request->is_penalty,
            ]);

            // สำเร็จ! กลับไปหน้าแรกพร้อมข้อความ "สร้างสำเร็จ"
            return redirect()->route('goals.index')->with('success', 'สร้างสำเร็จ');

        } catch (\Exception $e) {
            // ถ้ามีปัญหา (เช่น รหัสซ้ำ) แจ้งว่าล้มเหลว
            return redirect()->route('goals.index')->with('failed', 'สร้างล้มเหลว');
        }
    }

    // ========== หน้าแก้ไขข้อมูล ==========
    // เมื่อคนกดปุ่ม "แก้ไข" ที่แถวไหน จะมาที่นี่ พร้อม $id ของแถวนั้น
    public function edit(string $id)
    {
        // ดึงข้อมูลแถวที่ต้องการแก้ไขมา
        // where('goal_id', $id) = เอาแถวที่ goal_id ตรงกับ $id
        $goals = DB::table('Goals')->where('goal_id', $id)->get();

        // ดึงแมทช์และนักเตะมาให้เลือกด้วย
        $matches = DB::table('Matches')->get();
        $players = DB::table('Players')->get();

        // ส่งไปหน้าแก้ไข พร้อมข้อมูลเดิม
        return view('goals.edit', compact('goals', 'matches', 'players'));
    }

    // ========== บันทึกการแก้ไข ==========
    // เมื่อคนกดปุ่ม "บันทึก" ในหน้า edit จะมาที่นี่
    public function update(Request $request, string $id)
    {
        // ตรวจสอบข้อมูลเหมือน store แต่ไม่ต้องเช็ค goal_id เพราะแก้ไม่ได้
        $request->validate([
            'match_id' => 'required',
            'player_id' => 'required',
            'goal_time' => 'required',
            'is_penalty' => 'required',
        ]);

        try {
            // อัปเดตข้อมูลในฐานข้อมูล
            // where('goal_id', $id) = หาแถวที่ต้องการแก้
            // update([...]) = เปลี่ยนค่าในแถวนั้น
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

    // ========== ลบข้อมูล ==========
    // เมื่อคนกดปุ่ม "ลบ" จะมาที่นี่
    public function destroy(string $id)
    {
        try {
            // ลบแถวที่ goal_id ตรงกับ $id
            DB::table('Goals')->where('goal_id', $id)->delete();

            return redirect()->route('goals.index')->with('success', 'ลบสำเร็จ');

        } catch (\Exception $e) {
            return redirect()->route('goals.index')->with('failed', 'ลบล้มเหลว');
        }
    }
}
```

---

## 📄 3. Views (หน้าเว็บที่คนเห็น)

### 3.1 layout.blade.php - โครงหน้าเว็บ

**มันคืออะไร:** เหมือนกรอบรูป ทุกหน้าใช้กรอบเดียวกัน แค่เปลี่ยนรูปข้างใน

```html
<!DOCTYPE html>
<html>
    <head>
        <!-- @yield('title') = ช่องว่างรอใส่ชื่อหน้า -->
        <!-- หน้า index ส่งมาว่า "ตารางประตู" ก็จะขึ้น <title>ตารางประตู</title> -->
        <title>@yield('title')</title>

        <!-- โหลด CSS ให้หน้าเว็บสวย -->
        <link href="bootstrap.css" rel="stylesheet" />
    </head>
    <body>
        <!-- เมนูด้านบน ทุกหน้าเห็นเหมือนกัน -->
        <nav>
            <a href="/goals">ตารางประตู</a>
            <a href="/players">นักกีฬา</a>
        </nav>

        <div class="container">
            <!-- @yield('content') = ช่องว่างรอใส่เนื้อหา -->
            <!-- เนื้อหาจากแต่ละหน้าจะมาแสดงตรงนี้ -->
            @yield('content')
        </div>
    </body>
</html>
```

---

### 3.2 index.blade.php - หน้าดูรายการทั้งหมด

```blade
<!-- บอกว่าหน้านี้ใช้กรอบจาก layout.blade.php -->
@extends('layout')

<!-- ส่งชื่อหน้าไปใส่ใน @yield('title') -->
@section('title', 'ตารางประตู')

<!-- เริ่มเนื้อหาที่จะไปใส่ใน @yield('content') -->
@section('content')

    <!-- ปุ่มไปหน้าเพิ่มข้อมูล -->
    <!-- route('goals.create') สร้าง URL เป็น /goals/create -->
    <a href="{{ route('goals.create') }}">
        <button class="btn btn-success">เพิ่มข้อมูล</button>
    </a>

    <!-- ถ้ามีข้อความสำเร็จ (หลังบันทึก/แก้ไข/ลบ) ให้แสดง -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- ตารางแสดงข้อมูล -->
    <table class="table">
        <thead>
            <tr>
                <th>รหัส</th>
                <th>แมทช์</th>
                <th>นักเตะ</th>
                <th>นาที</th>
                <th>จุดโทษ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <!-- วนลูปแสดงข้อมูลทีละแถว -->
            <!-- $goals คือข้อมูลที่ส่งมาจาก Controller -->
            <!-- ทุกรอบ $go คือข้อมูล 1 แถว -->
            @foreach($goals as $go)
            <tr>
                <!-- {{ $go->goal_id }} = เอาค่า goal_id ในแถวนี้มาแสดง -->
                <td>{{ $go->goal_id }}</td>
                <td>{{ $go->match_id }}</td>
                <td>{{ $go->player_id }}</td>
                <td>{{ $go->goal_time }}</td>
                <td>{{ $go->is_penalty }}</td>
                <td>
                    <!-- ปุ่มแก้ไข -->
                    <!-- route('goals.edit', $go->goal_id) สร้าง URL เป็น /goals/5/edit -->
                    <!-- พอกด จะไป Controller ที่ edit() พร้อมส่ง id=5 ไปด้วย -->
                    <a href="{{ route('goals.edit', $go->goal_id) }}">
                        <button class="btn btn-warning">แก้ไข</button>
                    </a>

                    <!-- ปุ่มลบ (ต้องใช้ฟอร์มเพราะเป็นการลบ) -->
                    <form action="{{ route('goals.destroy', $go->goal_id) }}" method="POST">
                        <!-- @csrf = รหัสความปลอดภัย ป้องกันคนปลอมแปลง (ต้องมีทุกฟอร์ม) -->
                        @csrf
                        <!-- @method('DELETE') = บอกว่านี่คือการลบ ไม่ใช่การส่งข้อมูล -->
                        @method('DELETE')
                        <button class="btn btn-danger">ลบ</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
```

---

### 3.3 create.blade.php - หน้ากรอกข้อมูลใหม่

```blade
@extends('layout')
@section('content')

    <!-- ฟอร์มส่งข้อมูลไป store() -->
    <!-- method="POST" = ส่งข้อมูลแบบซ่อน ไม่โชว์บน URL -->
    <form action="{{ route('goals.store') }}" method="POST">
        @csrf  <!-- รหัสความปลอดภัย ต้องมีทุกฟอร์ม -->

        <!-- ช่องกรอกรหัสประตู -->
        <!-- name="goal_id" = ชื่อนี้จะถูกส่งไป Controller เป็น $request->goal_id -->
        <input type="text" name="goal_id" placeholder="รหัสประตู">

        <!-- ช่องเลือกแมทช์ (dropdown) -->
        <!-- $matches มาจาก Controller ที่ส่งมาให้ -->
        <select name="match_id">
            @foreach ($matches as $match)
                <!-- value = ค่าที่จะส่งไป Controller -->
                <!-- ข้อความระหว่าง <option> คือที่คนเห็น -->
                <option value="{{ $match->match_id }}">
                    {{ $match->match_id }} - ทีม {{ $match->team1_id }} vs {{ $match->team2_id }}
                </option>
            @endforeach
        </select>

        <!-- ช่องเลือกนักเตะ -->
        <select name="player_id">
            @foreach ($players as $player)
                <option value="{{ $player->player_id }}">
                    {{ $player->first_name }} {{ $player->last_name }}
                </option>
            @endforeach
        </select>

        <input type="text" name="goal_time" placeholder="นาทีที่ยิง">
        <input type="text" name="is_penalty" placeholder="จุดโทษไหม (0=ไม่ใช่, 1=ใช่)">

        <!-- ปุ่มยกเลิก กลับหน้าแรก -->
        <a href="{{ route('goals.index') }}" class="btn btn-danger">ยกเลิก</a>

        <!-- ปุ่มบันทึก ส่งฟอร์มไป store() -->
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>

@endsection
```

---

### 3.4 edit.blade.php - หน้าแก้ไข

```blade
@extends('layout')
@section('content')

    <!-- ดึงข้อมูลจาก $goals มาใช้ -->
    @foreach($goals as $go)
    @endforeach

    <!-- ส่งไป update() พร้อม id -->
    <form action="{{ route('goals.update', $go->goal_id) }}" method="POST">
        @csrf
        <!-- @method('PUT') = บอกว่านี่คือการแก้ไข ไม่ใช่สร้างใหม่ -->
        @method('PUT')

        <!-- readonly = อ่านได้อย่างเดียว แก้ไม่ได้ -->
        <!-- เพราะ goal_id เป็นรหัสหลัก ห้ามเปลี่ยน -->
        <input type="text" name="goal_id" value="{{ $go->goal_id }}" readonly>

        <!-- value = ค่าเดิมที่ดึงมาจากฐานข้อมูล -->
        <input type="text" name="goal_time" value="{{ $go->goal_time }}">
        <input type="text" name="is_penalty" value="{{ $go->is_penalty }}">

        <!-- Dropdown เหมือน create แต่ต้องเลือกค่าเดิมให้ด้วย -->
        <select name="match_id">
            @foreach ($matches as $match)
                <option value="{{ $match->match_id }}">
                    {{ $match->match_id }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>

@endsection
```

---

## 🔄 4. สรุปง่ายๆ ว่าระบบทำงานยังไง

```
┌─────────────────────────────────────────────────────────────────┐
│                     คนเปิดเว็บ /goals                           │
│                          ↓                                      │
│   web.php: "อ๋อ /goals นี่นะ ไป GoalsController นะ"              │
│                          ↓                                      │
│   Controller: "โอเค ฉันจะไปดึงข้อมูลจากฐานข้อมูลมาให้"            │
│                          ↓                                      │
│   Controller: "เอาข้อมูลไปแสดงที่หน้า index.blade.php นะ"        │
│                          ↓                                      │
│   View: แสดงตารางให้คนดู                                         │
└─────────────────────────────────────────────────────────────────┘
```

---

## 📌 5. คำสั่งสำคัญ (อ่านตรงนี้ก่อนสอบ!)

| คำสั่ง                                                   | มันทำอะไร                                   |
| -------------------------------------------------------- | ------------------------------------------- |
| `Route::resource('goals', ...)`                          | สร้าง 7 เส้นทางให้อัตโนมัติ ไม่ต้องพิมพ์เอง |
| `DB::table('Goals')->get()`                              | ดึงข้อมูลทั้งหมดจากตาราง Goals              |
| `DB::table('Goals')->insert([...])`                      | เพิ่มข้อมูลใหม่เข้าไป                       |
| `DB::table('Goals')->where('goal_id', 5)->update([...])` | แก้ไขข้อมูลที่ ID เป็น 5                    |
| `DB::table('Goals')->where('goal_id', 5)->delete()`      | ลบข้อมูลที่ ID เป็น 5                       |
| `compact('goals')`                                       | ห่อตัวแปร $goals ส่งไปให้ View ใช้          |
| `return view('goals.index', ...)`                        | ไปแสดงหน้า index.blade.php                  |
| `redirect()->route('goals.index')`                       | กลับไปหน้าแรก                               |
| `->with('success', 'สำเร็จ')`                            | ส่งข้อความไปแสดงหลังกลับหน้าแรก             |
| `$request->goal_id`                                      | รับค่าจากช่องที่ name="goal_id"             |
| `@extends('layout')`                                     | ใช้กรอบหน้าเว็บจาก layout                   |
| `@section('content')`                                    | เริ่มเนื้อหา                                |
| `@yield('content')`                                      | ช่องว่างรอใส่เนื้อหา                        |
| `@foreach($goals as $go)`                                | วนลูปดูข้อมูลทีละแถว                        |
| `{{ $go->goal_id }}`                                     | แสดงค่า goal_id                             |
| `{{ route('goals.edit', 5) }}`                           | สร้าง URL เป็น /goals/5/edit                |
| `@csrf`                                                  | รหัสความปลอดภัย ต้องมีทุกฟอร์ม              |
| `@method('PUT')`                                         | บอกว่าเป็นการแก้ไข                          |
| `@method('DELETE')`                                      | บอกว่าเป็นการลบ                             |

---

## ❓ ถ้าอาจารย์ถาม

**ถ: Route::resource ทำอะไร?**

> สร้าง 7 เส้นทาง CRUD อัตโนมัติ (ดู, เพิ่ม, แก้, ลบ)

**ถ: DB::table()->get() ทำอะไร?**

> ดึงข้อมูลทั้งหมดจากตาราง

**ถ: compact() ทำอะไร?**

> ห่อตัวแปรส่งไปให้ View ใช้

**ถ: @csrf ทำอะไร?**

> สร้างรหัสความปลอดภัยป้องกันการปลอมแปลง ต้องมีทุกฟอร์ม

**ถ: @extends('layout') ทำอะไร?**

> บอกว่าหน้านี้ใช้กรอบจาก layout.blade.php

**ถ: @yield กับ @section ต่างกันยังไง?**

> @yield = ช่องว่างรอใส่ของ (อยู่ใน layout)
> @section = ของที่จะใส่ลงไป (อยู่ในหน้าลูก)

**ถ: ทำไมต้องใช้ @method('DELETE')?**

> เพราะ HTML Form รองรับแค่ GET กับ POST ต้องใช้ @method บอก Laravel ว่าจริงๆ เป็น DELETE
