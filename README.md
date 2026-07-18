# 🗝️ Auction Dee

**Real-time auction marketplace** ธีม "Hidden Vault" — เว็บประมูลสินค้าออนไลน์แบบเรียลไทม์ พัฒนาด้วย Laravel

🔗 **Live Demo:** https://auction-dee-1.onrender.com

---

## ✨ ฟีเจอร์หลัก

### สำหรับผู้ใช้ทั่วไป
- สมัครสมาชิก / เข้าสู่ระบบ (Laravel Breeze)
- ลงสินค้าประมูล พร้อมอัปโหลดรูปภาพ, กำหนดราคาเริ่มต้น, ขั้นต่ำการบิดเพิ่ม, เวลาปิดประมูล
- **บิดราคาแบบเรียลไทม์** — เห็นราคาล่าสุด/ประวัติการบิดของคนอื่นทันทีโดยไม่ต้องรีเฟรชหน้า (ผ่าน WebSocket)
- ระบบป้องกัน race condition ตอนมีคนบิดพร้อมกัน (DB transaction + row locking)
- แจ้งเตือนเมื่อมีคนบิดสูงกว่า / เมื่อประมูลปิดและมีผู้ชนะ
- Dashboard ส่วนตัว — ดูสินค้าที่ลงขาย และสินค้าที่กำลังประมูลอยู่ พร้อมสถานะ "กำลังนำ / ถูกแซง / ชนะ / แพ้"
- นับถอยหลังเวลาปิดประมูลแบบเรียลไทม์

### สำหรับ Admin
- Dashboard สรุปภาพรวมระบบ (จำนวนผู้ใช้, สินค้า, ยอดขายรวม)
- จัดการสินค้า — ดู / แก้ไข (รวมเปลี่ยนรูปภาพ) / ลบ
- จัดการผู้ใช้ — ตั้ง/ถอดสิทธิ์ Admin

### ระบบอัตโนมัติ
- ปิดประมูลอัตโนมัติเมื่อหมดเวลา พร้อมประกาศผู้ชนะจากราคาบิดสูงสุด
- ส่ง Notification ให้ทั้งผู้ชนะและเจ้าของสินค้าโดยอัตโนมัติ

---

## 🛠️ Tech Stack

| ส่วน | เทคโนโลยี |
|---|---|
| Backend | Laravel 13 (PHP 8.4) |
| Database | PostgreSQL (Neon — serverless Postgres) |
| Real-time / WebSocket | Pusher Channels |
| Frontend | Blade + Tailwind CSS + Alpine.js |
| Auth | Laravel Breeze |
| Icons | Lucide |
| Deployment | Render (Docker) |
| Source Control | GitHub |

---

## 🏗️ สถาปัตยกรรมระบบ

```
User บิดราคา
    → Laravel บันทึกลง DB (transaction + lockForUpdate)
    → Broadcast event ผ่าน Pusher
    → ทุกคนที่เปิดหน้าสินค้าเดียวกันเห็นราคาอัปเดตทันที (Laravel Echo)

Scheduler เช็คสินค้าหมดเวลา
    → เปลี่ยนสถานะเป็น "ended" + กำหนดผู้ชนะ
    → ส่ง Notification ให้ผู้ชนะและเจ้าของสินค้า
```

เนื่องจาก deploy บน Render free tier (ไม่มี background worker แบบเสียเงิน) ระบบจึงปรับให้:
- **Broadcasting**: ใช้ Pusher (บริการภายนอก) แทนการรัน Laravel Reverb เอง
- **Queue**: ใช้ `sync` driver แทนการรัน `queue:work` ค้างไว้
- **Scheduler**: มี route ลับ (ป้องกันด้วย secret token) ให้บริการ cron ภายนอกยิงเข้ามาปิดประมูลอัตโนมัติ แทนการรัน `schedule:work` ค้างไว้

---

## 📂 โครงสร้างที่สำคัญ

```
app/
  Console/Commands/CloseExpiredAuctions.php   # คำสั่งปิดประมูลอัตโนมัติ
  Events/NewBidPlaced.php                     # Event ยิงตอนมีคนบิดใหม่
  Http/Controllers/ProductController.php      # CRUD สินค้า + บิด
  Http/Controllers/Admin/AdminController.php  # Admin panel
  Http/Middleware/EnsureUserIsAdmin.php       # กันสิทธิ์เข้าหน้า admin
  Notifications/AuctionWon.php                # แจ้งเตือนผู้ชนะ
  Notifications/AuctionEnded.php              # แจ้งเตือนเจ้าของสินค้า

resources/
  views/products/                             # หน้ารายการ/รายละเอียด/สร้างสินค้า
  views/admin/                                 # Admin panel views
  views/components/vault-entrance.blade.php   # แอนิเมชันประตูวอลต์ (ครั้งแรกต่อแท็บ)
  views/components/vault-atmosphere.blade.php # หมอก/ฝุ่นทอง/แสง ลอยพื้นหลัง
  js/echo.js                                   # ตั้งค่า Laravel Echo + Pusher

Dockerfile                                     # Multi-stage build (Node build assets + PHP runtime)
```

---

## ⚙️ การติดตั้งใช้งาน (Local)

### สิ่งที่ต้องมี
- PHP >= 8.4, Composer
- Node.js + npm
- PostgreSQL (หรือใช้ Neon)

### ขั้นตอน

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

ตั้งค่าในไฟล์ `.env`:
- `DB_*` — ข้อมูลเชื่อมต่อฐานข้อมูล PostgreSQL
- `PUSHER_*` / `VITE_PUSHER_*` — API key จาก https://pusher.com (มี free tier)
- `CRON_SECRET` — สุ่มค่าเองด้วย `php artisan tinker` → `Str::random(40)`

```bash
php artisan migrate
php artisan storage:link
npm run build   # หรือ npm run dev ตอน dev
php artisan serve
```

เปิดใช้งานฟีเจอร์เสริม (ไม่บังคับตอน dev):

```bash
php artisan queue:work        # ประมวลผล notification
php artisan schedule:work     # ปิดประมูลอัตโนมัติทุกนาที
```

### ตั้งสิทธิ์ Admin คนแรก

```bash
php artisan tinker
```
```php
User::where('email', 'your@email.com')->first()->update(['is_admin' => true]);
```

---

## 🚀 Deployment (Render + Neon + Pusher)

โปรเจกต์นี้ deploy ผ่าน **Docker** บน Render (Render ไม่รองรับ PHP runtime แบบ native จึงต้องใช้ Dockerfile)

1. Push โค้ดขึ้น GitHub
2. สร้าง Web Service บน Render โดยเลือก Environment เป็น **Docker** (จะ detect `Dockerfile` อัตโนมัติ)
3. ตั้งค่า Environment Variables ให้ครบ (ดู `.env.example` เป็นแนวทาง) รวมถึง `APP_URL` เป็น domain จริงที่ Render ให้มา
4. Deploy — Dockerfile จะ build assets ผ่าน Node stage แล้วรัน Laravel ผ่าน PHP stage, รัน migration อัตโนมัติทุกครั้งที่ container เริ่มทำงาน
5. ตั้งค่า cron ภายนอก (เช่น cron-job.org) ให้ยิง `https://<your-domain>/cron/close-expired-auctions/{CRON_SECRET}` เป็นระยะ เพื่อปิดประมูลอัตโนมัติบน production

> ⚠️ **ข้อจำกัดบน Render free tier:** Storage ไม่ persistent — รูปภาพที่ผู้ใช้ upload จะหายเมื่อมีการ deploy ใหม่ (แนวทางแก้ในอนาคต: ย้ายไปใช้ Cloudinary หรือ S3-compatible storage)

---

## 📝 หมายเหตุ

โปรเจกต์นี้เป็นงานเรียนรู้ Laravel แบบครบวงจร ตั้งแต่ CRUD พื้นฐาน, WebSocket real-time, background job/scheduler, ไปจนถึงการ deploy จริงบน cloud platform พร้อมแก้ปัญหาที่พบระหว่างทาง (database connection pooling, PHP version, Docker multi-stage build, Vite env var baking ฯลฯ)