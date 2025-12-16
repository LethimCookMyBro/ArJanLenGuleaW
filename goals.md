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

> **🎯 อ่านตรงนี้ก่อน!** Controller เหมือน "พนักงานร้าน" ที่รับคำสั่งจากลูกค้า แล้วไปหยิบของ/เก็บของให้

---

### 📦 ส่วนหัวไฟล์ (บอกว่าใช้อะไรบ้าง)

```php
<?php
namespace App\Http\Controllers;
```

**แปลง่ายๆ:** บอกว่าไฟล์นี้อยู่ในโฟลเดอร์ Controllers (เหมือนบอกที่อยู่บ้าน)

```php
use Illuminate\Http\Request;
use DB;
```

**แปลง่ายๆ:**

-   `Request` = กล่องรับพัสดุ (ใช้รับข้อมูลที่คนกรอกในฟอร์ม)
-   `DB` = กุญแจห้องเก็บของ (ใช้เปิดฐานข้อมูล)

---

### 📋 Method ที่ 1: `index()` - แสดงรายการทั้งหมด

```php
public function index()
{
    $goals = DB::table('Goals')->get();
    return view('goals.index', compact('goals'));
}
```

**🔍 อธิบายทีละบรรทัด:**

| บรรทัด | โค้ด                                            | แปลเป็นภาษาคน                                           |
| ------ | ----------------------------------------------- | ------------------------------------------------------- |
| 1      | `public function index()`                       | สร้างฟังก์ชันชื่อ index (หน้าแรก)                       |
| 2      | `$goals = DB::table('Goals')->get();`           | ไปเอาข้อมูลทุกแถวจากตาราง Goals มาใส่กล่องชื่อ `$goals` |
| 3      | `return view('goals.index', compact('goals'));` | เอากล่อง `$goals` ไปส่งให้หน้า index.blade.php แสดงผล   |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
เหมือนครูบอกว่า "ไปเอารายชื่อนักเรียนทุกคนมา แล้วติดไว้บนกระดาน"

$goals = DB::table('Goals')->get();
   ↑              ↑              ↑
กล่องใส่       ตู้เก็บข้อมูล     หยิบมาทั้งหมด
รายชื่อ

return view('goals.index', compact('goals'));
   ↑              ↑              ↑
ส่งไป        หน้าเว็บ index   พร้อมกล่องรายชื่อ
```

---

### 📋 Method ที่ 2: `create()` - เปิดหน้ากรอกข้อมูลใหม่

```php
public function create()
{
    $matches = DB::table('Matches')->get();
    $players = DB::table('Players')->get();
    return view('goals.create', compact('matches', 'players'));
}
```

**🔍 อธิบายทีละบรรทัด:**

| บรรทัด | โค้ด                                      | แปลเป็นภาษาคน                                     |
| ------ | ----------------------------------------- | ------------------------------------------------- |
| 1      | `$matches = DB::table('Matches')->get();` | ไปเอารายการแมทช์ทั้งหมดมา (ให้เลือกในดรอปดาวน์)   |
| 2      | `$players = DB::table('Players')->get();` | ไปเอารายชื่อนักเตะทั้งหมดมา (ให้เลือกในดรอปดาวน์) |
| 3      | `return view(...)`                        | ส่งทั้ง 2 อย่างไปหน้ากรอกฟอร์ม                    |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
เหมือนกรอกใบสมัคร ต้องมีตัวเลือกให้เลือก:
- เลือกแมทช์: ไทย vs ญี่ปุ่น, ไทย vs เกาหลี, ...
- เลือกนักเตะ: ชนาธิป, ธีรศิลป์, ...

$matches = DB::table('Matches')->get();
    ↑              ↑
กล่องใส่แมทช์    ไปหยิบจากตู้แมทช์

$players = DB::table('Players')->get();
    ↑              ↑
กล่องใส่นักเตะ   ไปหยิบจากตู้นักเตะ
```

**❓ ทำไมต้องดึง matches และ players มาด้วย?**

> เพราะตาราง Goals เก็บแค่ "รหัส" (`match_id`, `player_id`)
> ถ้าไม่ดึงมา คนกรอกฟอร์มจะไม่รู้ว่า match_id = 1 คือแมทช์อะไร
> เลยต้องดึงมาแสดงในดรอปดาวน์ให้เลือก

---

### 📋 Method ที่ 3: `store()` - บันทึกข้อมูลใหม่

```php
public function store(Request $request)
{
    $request->validate([
        'goal_id' => 'required',
        'match_id' => 'required',
        'player_id' => 'required',
        'goal_time' => 'required',
        'is_penalty' => 'required',
    ]);

    try {
        DB::table('Goals')->insert([
            'goal_id' => $request->goal_id,
            'match_id' => $request->match_id,
            'player_id' => $request->player_id,
            'goal_time' => $request->goal_time,
            'is_penalty' => $request->is_penalty,
        ]);
        return redirect()->route('goals.index')->with('success', 'สร้างสำเร็จ');
    } catch (\Exception $e) {
        return redirect()->route('goals.index')->with('failed', 'สร้างล้มเหลว');
    }
}
```

**🔍 อธิบายทีละส่วน:**

**ส่วนที่ 1: รับข้อมูลจากฟอร์ม**

```php
public function store(Request $request)
```

| โค้ด               | แปลเป็นภาษาคน                                   |
| ------------------ | ----------------------------------------------- |
| `Request $request` | กล่องพัสดุที่รับของจากฟอร์ม (ข้อมูลที่คนกรอกมา) |

**ส่วนที่ 2: ตรวจสอบว่ากรอกครบไหม**

```php
$request->validate([
    'goal_id' => 'required',
    ...
]);
```

| โค้ด         | แปลเป็นภาษาคน                                        |
| ------------ | ---------------------------------------------------- |
| `validate`   | ตรวจสอบความถูกต้อง                                   |
| `'required'` | ต้องกรอก ห้ามเว้นว่าง (ถ้าไม่กรอกจะส่งกลับหน้าฟอร์ม) |

**ส่วนที่ 3: บันทึกลงฐานข้อมูล**

```php
DB::table('Goals')->insert([
    'goal_id' => $request->goal_id,
    ...
]);
```

| โค้ด                 | แปลเป็นภาษาคน                         |
| -------------------- | ------------------------------------- |
| `DB::table('Goals')` | เปิดตู้เก็บข้อมูล Goals               |
| `->insert([...])`    | เพิ่มข้อมูลใหม่เข้าไป                 |
| `$request->goal_id`  | เอาค่าที่คนกรอกในช่อง "goal_id" มาใส่ |

**ส่วนที่ 4: กลับหน้าแรก**

```php
return redirect()->route('goals.index')->with('success', 'สร้างสำเร็จ');
```

| โค้ด                               | แปลเป็นภาษาคน                          |
| ---------------------------------- | -------------------------------------- |
| `redirect()`                       | เปลี่ยนหน้า                            |
| `->route('goals.index')`           | ไปที่หน้า /goals (หน้าแรก)             |
| `->with('success', 'สร้างสำเร็จ')` | พร้อมแสดงข้อความ "สร้างสำเร็จ" สีเขียว |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
เหมือนสมัครสมาชิกร้านค้า:

1. พนักงานรับใบสมัคร ($request)
2. เช็คว่ากรอกครบไหม (validate) - ถ้าไม่ครบ คืนใบสมัครกลับ
3. เอาไปเก็บในแฟ้ม (insert)
4. บอกลูกค้าว่า "สมัครเรียบร้อยแล้ว" (redirect with success)
```

---

### 📋 Method ที่ 4: `edit($id)` - เปิดหน้าแก้ไข

```php
public function edit(string $id)
{
    $goals = DB::table('Goals')->where('goal_id', $id)->get();
    $matches = DB::table('Matches')->get();
    $players = DB::table('Players')->get();
    return view('goals.edit', compact('goals', 'matches', 'players'));
}
```

**🔍 อธิบายทีละบรรทัด:**

| บรรทัด | โค้ด                               | แปลเป็นภาษาคน                    |
| ------ | ---------------------------------- | -------------------------------- |
| 1      | `public function edit(string $id)` | รับรหัสที่จะแก้ไข (เช่น $id = 5) |
| 2      | `->where('goal_id', $id)->get()`   | ไปหาแถวที่ goal_id = 5 เอามา     |
| 3-4    | `$matches, $players`               | ดึงแมทช์และนักเตะมาให้เลือกด้วย  |
| 5      | `return view(...)`                 | ส่งไปหน้าแก้ไขพร้อมข้อมูลเดิม    |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
เหมือนแก้ใบสมัครสมาชิก:

ลูกค้าบอก: "ขอแก้ใบสมัครเลขที่ 5"
                         ↓
พนักงานไปหยิบใบสมัครเลขที่ 5 มา
                         ↓
วางบนเคาน์เตอร์ให้ลูกค้าแก้

$goals = DB::table('Goals')->where('goal_id', $id)->get();
                              ↑                    ↑
                         หาที่ตรงกับ id        หยิบมา
```

**❓ `$id` มาจากไหน?**

> มาจาก URL! เช่น ถ้าคนกดปุ่มแก้ไขแถวที่ 5
> URL จะเป็น `/goals/5/edit`
> ตัวเลข 5 จะถูกส่งมาเป็น `$id`

---

### 📋 Method ที่ 5: `update($request, $id)` - บันทึกการแก้ไข

```php
public function update(Request $request, string $id)
{
    $request->validate([...]);

    try {
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
```

**🔍 อธิบายส่วนสำคัญ:**

| โค้ด                      | แปลเป็นภาษาคน               |
| ------------------------- | --------------------------- |
| `->where('goal_id', $id)` | หาแถวที่ goal_id ตรงกับ $id |
| `->update([...])`         | แก้ไขข้อมูลในแถวนั้น        |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
เหมือนแก้ไขข้อมูลในสมุดทะเบียน:

1. หาหน้าที่ต้องการ (where)
2. ลบของเก่า เขียนใหม่ (update)
3. บอกลูกค้าว่า "แก้เรียบร้อยแล้ว"
```

**❓ ทำไมไม่แก้ goal_id?**

> เพราะ `goal_id` เป็น Primary Key (รหัสหลัก)
> เปรียบเหมือนเลขบัตรประชาชน - เปลี่ยนไม่ได้!

---

### 📋 Method ที่ 6: `destroy($id)` - ลบข้อมูล

```php
public function destroy(string $id)
{
    try {
        DB::table('Goals')->where('goal_id', $id)->delete();
        return redirect()->route('goals.index')->with('success', 'ลบสำเร็จ');
    } catch (\Exception $e) {
        return redirect()->route('goals.index')->with('failed', 'ลบล้มเหลว');
    }
}
```

**🔍 อธิบายส่วนสำคัญ:**

| โค้ด                      | แปลเป็นภาษาคน               |
| ------------------------- | --------------------------- |
| `->where('goal_id', $id)` | หาแถวที่ goal_id ตรงกับ $id |
| `->delete()`              | ลบแถวนั้นทิ้ง               |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
เหมือนฉีกใบสมัครสมาชิกทิ้ง:

1. หาใบที่ต้องการ (where)
2. ฉีกทิ้ง (delete)
3. บอกลูกค้าว่า "ลบเรียบร้อยแล้ว"
```

---

### 🎁 สรุป: compact() คืออะไร?

```php
return view('goals.index', compact('goals'));
```

**แปลง่ายๆ:**

-   `compact('goals')` = เอาตัวแปร `$goals` ห่อใส่กล่องส่งไปให้หน้าเว็บ
-   เหมือน "ส่งพัสดุ" ข้อมูลไปให้หน้าเว็บ
-   หน้าเว็บ (`index.blade.php`) จะเปิดกล่องแล้วเอาข้อมูลไปแสดง

```
compact('goals', 'matches', 'players')
         ↓
┌─────────────────────────────┐
│ กล่องพัสดุ                   │
│ ├── $goals (ข้อมูลประตู)     │
│ ├── $matches (ข้อมูลแมทช์)   │
│ └── $players (ข้อมูลนักเตะ)  │
└─────────────────────────────┘
         ↓
    ส่งไปหน้าเว็บ
```

---

## 📄 3. Views (หน้าเว็บที่คนเห็น)

> **🎯 อ่านตรงนี้ก่อน!** Views คือ "หน้าเว็บ" ที่คนเห็น เหมือนป้ายหน้าร้าน!

---

### 3.1 layout.blade.php - โครงหน้าเว็บ

**มันคืออะไร:** เหมือน "กรอบรูป" ที่ทุกหน้าใช้ร่วมกัน (เมนู, ส่วนหัว) แค่เปลี่ยนเนื้อหาข้างใน

```html
<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <link href="bootstrap.css" rel="stylesheet" />
    </head>
    <body>
        <nav>
            <a href="/goals">ตารางประตู</a>
            <a href="/players">นักกีฬา</a>
        </nav>
        <div class="container">@yield('content')</div>
    </body>
</html>
```

**🔍 อธิบายส่วนสำคัญ:**

| โค้ด                | แปลเป็นภาษาคน                          |
| ------------------- | -------------------------------------- |
| `@yield('title')`   | ช่องว่างรอใส่ชื่อหน้า (หน้าลูกจะส่งมา) |
| `@yield('content')` | ช่องว่างรอใส่เนื้อหา (หน้าลูกจะส่งมา)  |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
layout.blade.php เหมือน "โครงบ้าน":

┌──────────────────────────────┐
│  หลังคา (เมนูด้านบน - nav)   │  ← ทุกหน้าเหมือนกัน
├──────────────────────────────┤
│                              │
│  @yield('content')           │  ← ช่องว่างรอใส่เนื้อหา
│  (เหมือนห้องว่างรอตกแต่ง)     │     แต่ละหน้าตกแต่งต่างกัน
│                              │
└──────────────────────────────┘
```

---

### 3.2 index.blade.php - หน้าดูรายการทั้งหมด

```blade
@extends('layout')
@section('title', 'ตารางประตู')
@section('content')
    <!-- เนื้อหาหน้านี้ -->
@endsection
```

**🔍 อธิบายทีละบรรทัด:**

| โค้ด                              | แปลเป็นภาษาคน                                    |
| --------------------------------- | ------------------------------------------------ |
| `@extends('layout')`              | หน้านี้ใช้กรอบจาก layout.blade.php               |
| `@section('title', 'ตารางประตู')` | ส่งชื่อหน้า "ตารางประตู" ไปใส่ใน @yield('title') |
| `@section('content')`             | เริ่มเนื้อหาที่จะไปใส่ใน @yield('content')       |
| `@endsection`                     | จบเนื้อหา                                        |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
เหมือนต่อจิ๊กซอว์:

layout.blade.php (กรอบ)     +     index.blade.php (เนื้อหา)
┌─────────────────┐              ┌─────────────────┐
│ @yield('title') │    ←───────  │ 'ตารางประตู'    │
├─────────────────┤              └─────────────────┘
│                 │              ┌─────────────────┐
│ @yield('content')│  ←───────  │ ตารางข้อมูล...   │
│                 │              └─────────────────┘
└─────────────────┘
```

---

#### ส่วนปุ่มเพิ่มข้อมูล

```html
<a href="{{ route('goals.create') }}">
    <button class="btn btn-success">เพิ่มข้อมูล</button>
</a>
```

| โค้ด                          | แปลเป็นภาษาคน                  |
| ----------------------------- | ------------------------------ |
| `{{ route('goals.create') }}` | สร้าง URL เป็น `/goals/create` |
| `btn btn-success`             | ปุ่มสีเขียว (จาก Bootstrap)    |

**กดแล้วเกิดอะไร?** → ไปหน้า `/goals/create` → Controller `create()` → เปิดหน้า `create.blade.php`

---

#### ส่วนแสดงข้อความสำเร็จ

```blade
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
```

| โค้ด                       | แปลเป็นภาษาคน                 |
| -------------------------- | ----------------------------- |
| `@if (session('success'))` | ถ้ามีข้อความ success ที่ส่งมา |
| `{{ session('success') }}` | แสดงข้อความนั้นออกมา          |
| `alert-success`            | กล่องข้อความสีเขียว           |

**มาจากไหน?** → มาจาก Controller ที่ทำ `->with('success', 'สร้างสำเร็จ')`

---

#### ส่วนวนลูปแสดงข้อมูล

```blade
@foreach($goals as $go)
<tr>
    <td>{{ $go->goal_id }}</td>
    <td>{{ $go->match_id }}</td>
    <td>{{ $go->player_id }}</td>
    <td>{{ $go->goal_time }}</td>
    <td>{{ $go->is_penalty }}</td>
</tr>
@endforeach
```

**🔍 อธิบายทีละบรรทัด:**

| โค้ด                      | แปลเป็นภาษาคน                       |
| ------------------------- | ----------------------------------- |
| `@foreach($goals as $go)` | วนลูป: ทุกแถวใน $goals เรียกว่า $go |
| `{{ $go->goal_id }}`      | เอาค่า goal_id ของแถวนี้มาแสดง      |
| `{{ $go->match_id }}`     | เอาค่า match_id ของแถวนี้มาแสดง     |
| `@endforeach`             | จบการวนลูป                          |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
$goals = รายชื่อนักเรียนทั้งห้อง (หลายคน)
$go = นักเรียน 1 คน (ทีละคน)

เหมือนเช็คชื่อ:
"เรียกชื่อทีละคน แล้วเขียนลงตาราง"

@foreach($goals as $go)    ←─ "วนดูนักเรียนทีละคน"
    $go->goal_id           ←─ "เขียนชื่อคนนี้"
@endforeach                ←─ "จบแล้ว คนสุดท้ายแล้ว"
```

**❓ `$go->goal_id` คืออะไร?**

```
$go เป็น Object (วัตถุ) ที่มีข้อมูลหลายช่อง:
$go = {
    goal_id: 1,
    match_id: 5,
    player_id: 10,
    goal_time: 45,
    is_penalty: 0
}

$go->goal_id = เอาค่า goal_id ออกมา = 1
$go->match_id = เอาค่า match_id ออกมา = 5
```

---

#### ส่วนปุ่มแก้ไขและลบ

```blade
<!-- ปุ่มแก้ไข -->
<a href="{{ route('goals.edit', $go->goal_id) }}">
    <button class="btn btn-warning">แก้ไข</button>
</a>

<!-- ปุ่มลบ -->
<form action="{{ route('goals.destroy', $go->goal_id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger">ลบ</button>
</form>
```

**🔍 อธิบายทีละบรรทัด:**

| โค้ด                                   | แปลเป็นภาษาคน                                    |
| -------------------------------------- | ------------------------------------------------ |
| `route('goals.edit', $go->goal_id)`    | สร้าง URL เป็น `/goals/5/edit` (ถ้า goal_id = 5) |
| `route('goals.destroy', $go->goal_id)` | สร้าง URL เป็น `/goals/5` สำหรับลบ               |
| `@csrf`                                | รหัสความปลอดภัย (ต้องมีทุกฟอร์ม!)                |
| `@method('DELETE')`                    | บอกว่านี่คือการลบ ไม่ใช่การส่งข้อมูล             |

**❓ ทำไมปุ่มลบต้องใช้ `<form>`?**

```
เพราะ HTML รองรับแค่ 2 วิธี: GET กับ POST
แต่การลบใน Laravel ต้องใช้ DELETE
เลยต้องใช้ฟอร์ม + @method('DELETE') เพื่อ "หลอก" ว่าเป็น DELETE

ปกติ: <form method="POST">  →  ส่งเป็น POST
เพิ่ม: @method('DELETE')    →  Laravel รู้ว่าจริงๆ คือ DELETE
```

---

### 3.3 create.blade.php - หน้ากรอกข้อมูลใหม่

```blade
@extends('layout')
@section('content')
    <form action="{{ route('goals.store') }}" method="POST">
        @csrf

        <input type="text" name="goal_id" placeholder="รหัสประตู">

        <select name="match_id">
            @foreach ($matches as $match)
                <option value="{{ $match->match_id }}">
                    {{ $match->match_id }} - ทีม {{ $match->team1_id }} vs {{ $match->team2_id }}
                </option>
            @endforeach
        </select>

        <select name="player_id">
            @foreach ($players as $player)
                <option value="{{ $player->player_id }}">
                    {{ $player->first_name }} {{ $player->last_name }}
                </option>
            @endforeach
        </select>

        <input type="text" name="goal_time" placeholder="นาทีที่ยิง">
        <input type="text" name="is_penalty" placeholder="จุดโทษไหม (0=ไม่ใช่, 1=ใช่)">

        <a href="{{ route('goals.index') }}" class="btn btn-danger">ยกเลิก</a>
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
@endsection
```

**🔍 อธิบายส่วนสำคัญ:**

| โค้ด                                  | แปลเป็นภาษาคน                                         |
| ------------------------------------- | ----------------------------------------------------- |
| `action="{{ route('goals.store') }}"` | กดบันทึกแล้วส่งไป `/goals` (store method)             |
| `method="POST"`                       | ส่งข้อมูลแบบซ่อน (ไม่โชว์บน URL)                      |
| `@csrf`                               | รหัสความปลอดภัย (ต้องมี!)                             |
| `name="goal_id"`                      | ชื่อช่องนี้ ส่งไป Controller เป็น `$request->goal_id` |

**🏠 เปรียบเทียบ name กับ $request:**

```
หน้าเว็บ (View):
<input name="goal_id" value="1">
<input name="player_id" value="10">
         ↓
         ↓  กดปุ่มบันทึก
         ↓
Controller:
$request->goal_id   = 1
$request->player_id = 10

เหมือนกรอกใบสมัคร:
- ช่อง "ชื่อ" = name
- สิ่งที่เขียน = value
- Controller รับไปเก็บ
```

---

#### ส่วน Dropdown (เลือกจากรายการ)

```blade
<select name="match_id">
    @foreach ($matches as $match)
        <option value="{{ $match->match_id }}">
            {{ $match->match_id }} - ทีม {{ $match->team1_id }} vs {{ $match->team2_id }}
        </option>
    @endforeach
</select>
```

**🔍 อธิบาย:**

| โค้ด                             | แปลเป็นภาษาคน                   |
| -------------------------------- | ------------------------------- |
| `<select name="match_id">`       | Dropdown ที่ส่งค่าชื่อ match_id |
| `@foreach ($matches as $match)`  | วนสร้าง option ทีละแมทช์        |
| `value="{{ $match->match_id }}"` | ค่าที่จะส่งไป Controller (รหัส) |
| ข้อความใน `<option>`             | ที่คนเห็นบนหน้าจอ               |

**🏠 เปรียบเทียบกับชีวิตจริง:**

```
Dropdown = เมนูอาหารตามสั่ง

<option value="1">ไทย vs ญี่ปุ่น</option>
<option value="2">ไทย vs เกาหลี</option>
              ↑              ↑
        ค่าที่ส่ง      ที่คนเห็น

คนเลือก "ไทย vs ญี่ปุ่น" → Controller ได้ค่า 1
```

---

### 3.4 edit.blade.php - หน้าแก้ไข

```blade
@extends('layout')
@section('content')
    @foreach($goals as $go)
    @endforeach

    <form action="{{ route('goals.update', $go->goal_id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="goal_id" value="{{ $go->goal_id }}" readonly>
        <input type="text" name="goal_time" value="{{ $go->goal_time }}">
        <input type="text" name="is_penalty" value="{{ $go->is_penalty }}">

        <select name="match_id">
            @foreach ($matches as $match)
                <option value="{{ $match->match_id }}">{{ $match->match_id }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
@endsection
```

**🔍 อธิบายส่วนสำคัญ:**

| โค้ด                         | แปลเป็นภาษาคน                                       |
| ---------------------------- | --------------------------------------------------- |
| `@method('PUT')`             | บอกว่านี่คือการแก้ไข (ไม่ใช่สร้างใหม่)              |
| `value="{{ $go->goal_id }}"` | ใส่ค่าเดิมไว้ในช่อง                                 |
| `readonly`                   | อ่านได้อย่างเดียว แก้ไม่ได้ (เพราะเป็น Primary Key) |

**❓ ทำไมต้องใช้ `@method('PUT')`?**

```
เหมือนปุ่มลบ: HTML รองรับแค่ GET กับ POST
แต่การแก้ไขใน Laravel ต้องใช้ PUT
เลยต้องใช้ @method('PUT') เพื่อ "หลอก" ว่าเป็น PUT

ปกติ: <form method="POST">  →  ส่งเป็น POST (สร้างใหม่)
เพิ่ม: @method('PUT')       →  Laravel รู้ว่าจริงๆ คือ PUT (แก้ไข)
```

**❓ `@foreach($goals as $go)` ตรงต้น ทำอะไร?**

```
Controller ส่ง $goals มาเป็น Collection (หลายแถว)
แต่จริงๆ มีแค่ 1 แถว (เพราะหาด้วย where แล้ว)

@foreach($goals as $go)
@endforeach

= ดึงข้อมูลแถวนั้นมาใส่ในตัวแปร $go ให้ใช้ด้านล่างได้
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
