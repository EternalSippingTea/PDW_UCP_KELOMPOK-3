# ERD — Sistem Manajemen Kos & Indekos

## Diagram (Mermaid)

```mermaid
erDiagram
    USERS ||--o{ BOOKING : "mengajukan"
    USERS ||--o{ PEMBAYARAN : "membayar"
    USERS ||--o{ TAGIHAN : "memiliki"
    KAMAR ||--o{ FOTO_KAMAR : "punya"
    KAMAR ||--o{ BOOKING : "dipesan"
    KAMAR ||--o{ TAGIHAN : "untuk"
    BOOKING ||--o{ PEMBAYARAN : "menghasilkan"
    USERS ||--o{ PENGUMUMAN : "dibuat oleh"

    USERS {
      int id PK
      string nama
      string email UK
      string password_hash
      string telepon
      enum role "owner|penghuni"
      datetime created_at
    }
    KAMAR {
      int id PK
      string kode UK
      string tipe
      decimal ukuran_m2
      text fasilitas
      decimal harga_bulanan
      enum status "tersedia|terisi"
      string foto_utama
      datetime created_at
    }
    FOTO_KAMAR {
      int id PK
      int kamar_id FK
      string path
    }
    BOOKING {
      int id PK
      string kode_booking UK
      int user_id FK
      int kamar_id FK
      date tanggal_mulai
      int durasi_bulan
      text catatan
      enum status "pending|approved|rejected|ongoing|completed"
      datetime created_at
    }
    PEMBAYARAN {
      int id PK
      int user_id FK
      int booking_id FK
      int tagihan_id FK
      decimal nominal
      string bukti_path
      enum status "pending|verified|rejected"
      datetime created_at
      datetime verified_at
    }
    TAGIHAN {
      int id PK
      int user_id FK
      int kamar_id FK
      string periode "YYYY-MM"
      decimal nominal
      enum status "belum|lunas"
      date due_date
    }
    PENGUMUMAN {
      int id PK
      int created_by FK
      string judul
      text isi
      datetime created_at
    }
```

## Catatan Relasi

- 1 USER (penghuni) bisa punya banyak BOOKING & TAGIHAN.
- 1 KAMAR bisa punya banyak FOTO & banyak BOOKING (historis).
- 1 BOOKING setelah approved akan otomatis generate TAGIHAN bulanan (sebanyak `durasi_bulan`).
- PEMBAYARAN terhubung ke TAGIHAN spesifik (1 tagihan → 1 pembayaran verified).
- Status kamar otomatis update ke "terisi" saat booking approved, "tersedia" saat completed.
