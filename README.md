# 📦 Warehouse Management System (Laravel + PostgreSQL + Docker)

ระบบคลังสินค้าอัจฉริยะที่ออกแบบมาเพื่อจัดการสินค้าแบบ Lot-Based พร้อมรองรับการจัดสต๊อกแบบ FIFO, FEFO, คำนวณต้นทุนแบบ FIFO / LIFO / Average, ระบบเคลื่อนไหวสต๊อก และรายงานครบถ้วน

---

## 🚀 Tech Stack

- Laravel 11 (PHP 8.2)
- PostgreSQL
- Docker / Docker Compose
- Eloquent ORM
- Faker (Mock Data)
- REST API (สำหรับทดสอบระบบ)

---

## 📐 Features

✅ โครงสร้างคลังสินค้าแบบหลายระดับ (คลัง → โซน → ตำแหน่ง)  
✅ รองรับสินค้า 1,000+ SKU และสถานะสินค้าหมดอายุ  
✅ คำนวณต้นทุน: FIFO, LIFO, Average  
✅ อัลกอริทึม Allocation แบบ FIFO / FEFO  
✅ Fulfillment จากคำสั่งซื้อ → Outbound → Logging  
✅ รายงานสต๊อกคงเหลือ + รายงานสินค้าใกล้หมดอายุ  
✅ Mock Data ขนาดใหญ่ (~1 ล้าน record)  
✅ APIs สำหรับการทดสอบ/วัดผล

---

## ⚙️ วิธีติดตั้ง

```bash
git clone <project-url>
cd warehouse-system

# สร้าง .env (จาก .env.example)
cp .env.example .env

# เรียกใช้ Docker
docker-compose up -d

# เข้าสู่ container
docker exec -it laravel_app bash

# ติดตั้ง Composer
composer install

# Migrate + Seed ข้อมูล mock
php artisan migrate:fresh --seed
```

---

## 📡 API ทดสอบ

### 🔍 GET `/api/products`
> แสดงรายการสินค้า

### 📦 GET `/api/stock`
> แสดงสต๊อกคงเหลือ (ตาม batch/location/product)

### 🧊 GET `/api/expiry-report`
> รายงาน batch ที่ใกล้หมดอายุใน 14 วัน

### 🔁 GET `/api/movements?date_from=2024-01-01&date_to=2025-01-01`
> รายงาน stock movement ย้อนหลังตามช่วงเวลา

### 📝 POST `/api/orders`
```json
{
  "items": [
    { "product_id": 1, "quantity": 10 },
    { "product_id": 5, "quantity": 20 }
  ]
}
```
> สร้างคำสั่งซื้อ → Fulfill → สร้าง stock movement อัตโนมัติ

### 📄 GET `/api/orders/{id}`
> ดูคำสั่งซื้อ + รายการสินค้าใน order

---

## 🧠 จุดเด่นของอัลกอริทึม

- **Allocation Engine**:
  - FIFO สำหรับสินค้าทั่วไป
  - FEFO สำหรับสินค้าหมดอายุ
  - รองรับ partial allocation
- **Cost Calculator**:
  - FIFO / LIFO: หาค่าจาก batch ที่เหมาะสม
  - Weighted Average: คำนวณ cost per unit รวม

---

## 📊 Mock Data ขนาดใหญ่

Seeder สร้างข้อมูลดังนี้:
- 5 คลัง
- 20 โซน
- 200 ตำแหน่ง
- 1,000 SKU
- 3–5 batch/SKU
- 30,000+ stock movement logs ย้อนหลัง 1 ปี

---

## 📈 Performance & Design Notes

- ใช้ `Eager Loading` ป้องกัน N+1 query
- ใช้ Transaction ใน Fulfillment Service
- Algorithm complexity: O(n log n) สำหรับการจัดสต๊อก
- ทดสอบแล้วสามารถจัดการ batch หลักหมื่นได้ภายใน ~200ms

---

## 🧪 การทดสอบระบบ

สามารถทดสอบ API ได้ผ่าน:
- Postman
- CURL
- Swagger (สามารถเพิ่มภายหลังได้)

---

## 📂 โครงสร้างโฟลเดอร์สำคัญ

```
app/
├── Models/
├── Services/
│   ├── ProductAllocator.php
│   ├── CostCalculator.php
│   └── SalesOrderFulfillmentService.php
├── Http/
│   └── Controllers/Api/
database/
├── factories/
├── seeders/
routes/
└── api.php
```

---

## 📌 ผู้พัฒนา

**Thanapak "Jai"**  
📧 Email: Thanapak_09@hotmail.com 
📱 พร้อมทำงานจริง สร้างระบบขนาดใหญ่/ซับซ้อน และใช้ Docker เป็น