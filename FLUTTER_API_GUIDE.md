# Greenleaf API Guide for Flutter Developers

Complete A–Z reference for the Greenleaf mobile API: customer login (password + **OTP**), registration (with **OTP verification**), products, cart, wishlist, orders, profile, offers, and dealer flows.

---

## Table of Contents

1. [Base URL & Headers](#1-base-url--headers)
2. [Authentication](#2-authentication)
   - [Password Login](#21-password-login)
   - [OTP Login (WhatsApp)](#22-otp-login-whatsapp)
   - [Password Registration](#23-password-registration)
   - [OTP Registration (WhatsApp)](#24-otp-registration-whatsapp)
   - [Logout](#25-logout)
   - [Get Current User](#26-get-current-user)
   - [Forgot Password](#27-forgot-password)
3. [Profile](#3-profile)
4. [Categories & Subcategories](#4-categories--subcategories)
5. [Products](#5-products)
6. [Cart](#6-cart)
7. [Wishlist](#7-wishlist)
8. [Orders](#8-orders)
9. [Offers](#9-offers)
10. [Notifications](#10-notifications)
11. [Dealer](#11-dealer)
12. [Flutter Integration Tips](#12-flutter-integration-tips)
13. [Error Handling](#13-error-handling)

---

## 1. Base URL & Headers

- **Base URL:** `https://your-domain.com/api/v1` (replace with your `APP_URL` + `/api/v1`).
- **Content-Type:** `application/json`
- **Accept:** `application/json`

For **protected routes**, send the Bearer token:

```
Authorization: Bearer <your_sanctum_token>
```

**Health check (no auth):**

```http
GET /api/v1/test
```

**Response:**

```json
{
  "success": true,
  "message": "API is accessible",
  "timestamp": "2025-02-10T12:00:00.000000Z",
  "server": "Apache/2.4.x"
}
```

---

## 2. Authentication

### 2.1 Password Login

Login with email **or** phone + password.

**Endpoint:** `POST /api/v1/login`

**Body (email):**

```json
{
  "email": "customer@example.com",
  "password": "YourPassword123"
}
```

**Body (phone):**

```json
{
  "phone": "9876543210",
  "password": "YourPassword123"
}
```

**Success (200):**

```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "customer@example.com",
      "phone": "9876543210",
      "role": "customer",
      "email_verified_at": null,
      "created_at": "2025-01-01T00:00:00.000000Z",
      "updated_at": "2025-01-01T00:00:00.000000Z"
    },
    "token": "1|abc123..."
  }
}
```

**Errors:** `401` Invalid credentials, `422` Validation failed.

---

### 2.2 OTP Login (WhatsApp)

Two-step flow: **start** (sends OTP via WhatsApp) → **verify** (returns user + token).

#### Step 1: Start OTP login

**Endpoint:** `POST /api/v1/auth/otp/login/start`

**Body (email or phone + password):**

```json
{
  "email": "customer@example.com",
  "password": "YourPassword123"
}
```

or

```json
{
  "phone": "9876543210",
  "password": "YourPassword123"
}
```

**Success (200):**

```json
{
  "success": true,
  "message": "OTP sent to your WhatsApp. Please verify to complete login.",
  "data": {
    "otp_token": "a1b2c3d4e5f6...",
    "expires_in_minutes": 10
  }
}
```

- Store `otp_token` and pass it in the verify step.
- OTP is sent to the user’s **phone** (WhatsApp). User must have `phone` on account.

**Errors:** `401` Invalid credentials, `400` No phone on file, `429` Rate limit (wait 1 minute), `422` Validation.

#### Step 2: Verify OTP and get token

**Endpoint:** `POST /api/v1/auth/otp/login/verify`

**Body:**

```json
{
  "otp_token": "a1b2c3d4e5f6...",
  "otp": "123456"
}
```

**Success (200):**

```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": { "id": 1, "name": "John Doe", "email": "...", "phone": "...", "role": "customer", ... },
    "token": "2|xyz789..."
  }
}
```

**Errors:** `400` Invalid/expired OTP session, `422` Invalid or expired OTP.

---

### 2.3 Password Registration

Register without OTP (optional; OTP registration recommended for mobile).

**Endpoint:** `POST /api/v1/register`

**Body:**

```json
{
  "name": "John Doe",
  "email": "customer@example.com",
  "password": "YourPassword123",
  "password_confirmation": "YourPassword123",
  "role": "customer",
  "phone": "9876543210"
}
```

**Success (201):** Same shape as login (`user` + `token`).  
**Errors:** `422` Validation (e.g. email already exists).

---

### 2.4 OTP Registration (WhatsApp)

Two-step flow: **start** (validate + send OTP) → **verify** (create user + return token).

#### Step 1: Start OTP registration

**Endpoint:** `POST /api/v1/auth/otp/register/start`

**Body:**

```json
{
  "name": "John Doe",
  "email": "newuser@example.com",
  "password": "YourPassword123",
  "role": "customer",
  "phone": "9876543210"
}
```

**Success (200):**

```json
{
  "success": true,
  "message": "OTP sent to your WhatsApp. Please verify to complete registration.",
  "data": {
    "otp_token": "f6e5d4c3b2a1...",
    "expires_in_minutes": 10
  }
}
```

**Errors:** `422` Validation, `429` Rate limit.

#### Step 2: Verify OTP and create account

**Endpoint:** `POST /api/v1/auth/otp/register/verify`

**Body:**

```json
{
  "otp_token": "f6e5d4c3b2a1...",
  "otp": "123456"
}
```

**Success (201):**

```json
{
  "success": true,
  "message": "Registration successful",
  "data": {
    "user": { "id": 2, "name": "John Doe", "email": "...", "phone": "...", "role": "customer", ... },
    "token": "3|def456..."
  }
}
```

**Errors:** `400` Invalid/expired OTP session, `422` Invalid or expired OTP.

---

### 2.5 Logout

**Endpoint:** `POST /api/v1/logout`  
**Auth:** Required (Bearer token)

**Success (200):**

```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

---

### 2.6 Get Current User

**Endpoint:** `GET /api/v1/user`  
**Auth:** Required

**Success (200):**

```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "customer@example.com",
      "phone": "9876543210",
      "role": "customer",
      "is_dealer": false,
      "is_approved_dealer": false,
      "can_access_dealer_pricing": false,
      "dealer_registration": null,
      ...
    }
  }
}
```

For dealers, `user` may include `dealer_registration`, `business_name`, `gst_number`, etc.

---

### 2.7 Forgot Password

**Endpoint:** `POST /api/v1/forgot-password`

**Body:**

```json
{
  "email": "customer@example.com"
}
```

**Success (200):** `{ "success": true, "message": "Password reset link sent to your email" }`  
**Note:** Backend may still be TODO; check with server team.

---

## 3. Profile

**Auth:** Required for all profile endpoints.

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/profile` | Get profile |
| PUT | `/api/v1/profile` | Update profile |
| POST | `/api/v1/profile/change-password` | Change password |

**GET /api/v1/profile** – Response includes `data.user` (name, email, phone, dealer fields if applicable).

**PUT /api/v1/profile** – Body (all optional): `name`, `email`, `phone`. Response: `data.user` updated.

**POST /api/v1/profile/change-password** – Body:

```json
{
  "current_password": "OldPass123",
  "password": "NewPass123",
  "password_confirmation": "NewPass123"
}
```

---

## 4. Categories & Subcategories

All public (no auth required). Optional: send Bearer token for dealer pricing on products.

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/categories` | List categories with subcategories |
| GET | `/api/v1/categories/{id}` | Single category (with products if applicable) |
| GET | `/api/v1/subcategories` | List subcategories |
| GET | `/api/v1/subcategories/{id}` | Single subcategory |

**GET /api/v1/categories** – Each item: `id`, `name`, `slug`, `description`, `image` (full URL), `products_count`, `subcategories` (array of `id`, `name`, `slug`, `description`, `image`).

---

## 5. Products

Public; optional auth for dealer pricing.

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/products` | List with filters & pagination |
| GET | `/api/v1/products/search?q=...` | Search (min 2 chars) |
| GET | `/api/v1/products/featured` | Featured products |
| GET | `/api/v1/products/{id}` or `/{slug}` | Single product + related |

**Query params for GET /api/v1/products:**

- `category_id`, `subcategory_id`, `brand`, `power_source`
- `min_price`, `max_price`
- `featured` (bool)
- `sort`: `name` \| `price_low` \| `price_high` \| `newest`
- `per_page` (default 15), `page`

**Product object (in list/detail):**

- `id`, `name`, `slug`, `description`, `short_description`, `sku`
- `price`, `original_price`, `sale_price`, `dealer_price`, `dealer_sale_price` (if dealer), `discount_percentage`
- `stock_quantity`, `in_stock`, `is_featured`
- `image` (main, full URL), `images` (gallery, full URLs)
- `brand`, `model`, `power_source`, `warranty`, `weight`, `dimensions`
- `category`: `{ id, name, slug }`
- `subcategory`: `{ id, name, slug }` or null
- `created_at`, `updated_at` (ISO)

Single product response also includes `related_products` (array of same shape).

---

## 6. Cart

**Auth:** Required. Uses session for cart; ensure session is enabled for API (backend uses `StartSession` for cart routes).

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/cart` | Get cart |
| POST | `/api/v1/cart/add` | Add item |
| PUT | `/api/v1/cart/update` | Update quantity |
| DELETE | `/api/v1/cart/remove/{productId}` | Remove item |
| DELETE | `/api/v1/cart/clear` | Clear cart |
| GET | `/api/v1/cart/count` | Cart item count |

**POST /api/v1/cart/add:**

```json
{
  "product_id": 5,
  "quantity": 2
}
```

**PUT /api/v1/cart/update:**

```json
{
  "product_id": 5,
  "quantity": 3
}
```

**GET /api/v1/cart** response:

```json
{
  "success": true,
  "data": {
    "items": [
      {
        "product_id": 5,
        "name": "Product Name",
        "sku": "SKU-001",
        "price": 999.00,
        "quantity": 2,
        "subtotal": 1998.00,
        "image": "https://...",
        "in_stock": true,
        "stock_quantity": 10
      }
    ],
    "subtotal": 1998.00,
    "tax_amount": 159.84,
    "shipping_amount": 25,
    "total": 2182.84,
    "items_count": 1
  }
}
```

---

## 7. Wishlist

**Auth:** Required.

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/wishlist` | List wishlist (product objects) |
| POST | `/api/v1/wishlist/add` | Add product |
| DELETE | `/api/v1/wishlist/remove/{productId}` | Remove |
| DELETE | `/api/v1/wishlist/clear` | Clear |
| GET | `/api/v1/wishlist/check/{productId}` | Check if in wishlist |

**POST /api/v1/wishlist/add:** Body `{ "product_id": 5 }`.

**GET /api/v1/wishlist/check/{productId}:** `data.is_in_wishlist` (boolean).

---

## 8. Orders

**Auth:** Required. Orders are created as **inquiries** (no online payment); admin follows up.

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/orders` | List orders (paginated) |
| GET | `/api/v1/orders/{orderNumber}` | Single order |
| POST | `/api/v1/orders` | Create order (from cart) |
| GET | `/api/v1/orders/{orderNumber}/invoice` | Invoice data |

**Query params for GET /api/v1/orders:**

- `status`: `inquiry` \| `pending` \| `processing` \| `shipped` \| `delivered` \| `cancelled`
- `payment_status`: `not_required` \| `pending` \| `paid` \| `failed` \| `refunded`
- `per_page`, `page`

**POST /api/v1/orders** – Create order from current cart:

```json
{
  "customer_name": "John Doe",
  "customer_email": "john@example.com",
  "customer_phone": "9876543210",
  "billing_address": "123 Main St, City, State - 400001",
  "shipping_address": "123 Main St, City, State - 400001",
  "notes": "Please call before delivery"
}
```

`shipping_address` is optional (defaults to billing). Cart is cleared on success.

**Order object:**

- `order_number`, `customer_name`, `customer_email`, `customer_phone`
- `billing_address`, `shipping_address` (may be objects with `address`)
- `subtotal`, `tax_amount`, `shipping_amount`, `total_amount`
- `payment_method`, `payment_status`, `order_status`, `is_inquiry`
- `notes`, `store` (name, tagline, logo)
- `items`: array of product_name, sku, quantity, price, total, image, offer
- `created_at`, `updated_at`

---

## 9. Offers

Public list/show; optional auth for dealer-specific offers.

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/offers` | List offers |
| GET | `/api/v1/offers/{id}` | Single offer |
| GET | `/api/v1/offers/product/{productId}` | Offers for a product |
| POST | `/api/v1/offers/calculate-discount` | Calculate discount (body: product/cart info as required by backend) |

Query: `type`, `featured` (bool). Response includes `data` (array or object) and optionally `count`.

---

## 10. Notifications

**Auth:** Required.

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/notifications` | List (paginated) |
| POST | `/api/v1/notifications/{id}/read` | Mark one read |
| POST | `/api/v1/notifications/read-all` | Mark all read |

Notification item: `id`, `title`, `message`, `type`, `is_read`, `created_at` (ISO).

---

## 11. Dealer

**Auth:** Required.

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/dealer/status` | Dealer status & registration info |
| POST | `/api/v1/dealer/register` | Submit dealer registration |

**POST /api/v1/dealer/register** – Only for users with `role: dealer`. Body typically includes: `name`, `email`, `business_name`, `gst_number`, `business_address`, `phone`, `company_website`, `business_description`, `pan_number`, and optionally `terms_accepted`. Check backend validation for exact required fields.

---

## 12. Flutter Integration Tips

### Base URL and client

```dart
const String baseUrl = 'https://your-domain.com/api/v1';

class ApiClient {
  final String? token;
  final Dio _dio = Dio(BaseOptions(
    baseUrl: baseUrl,
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    },
  ));

  ApiClient({this.token}) {
    if (token != null) {
      _dio.options.headers['Authorization'] = 'Bearer $token';
    }
  }
}
```

### Storing token after login/OTP verify

After **password login**, **OTP login verify**, or **OTP register verify**, save `data.token` and `data.user` (e.g. with `shared_preferences` or `flutter_secure_storage`), then use the token for all protected requests.

### OTP flow in Flutter

1. **Login with OTP:** Call `POST /auth/otp/login/start` with email/phone + password → show OTP input → call `POST /auth/otp/login/verify` with `otp_token` + `otp` → save token and user.
2. **Register with OTP:** Call `POST /auth/otp/register/start` with name, email, password, role, phone → show OTP input → call `POST /auth/otp/register/verify` with `otp_token` + `otp` → save token and user.

### Sending token on requests

For every request to a protected route, set:

```
Authorization: Bearer <token>
```

### Pagination

List endpoints that support pagination return Laravel-style pagination: `data.current_page`, `data.last_page`, `data.per_page`, `data.total`, `data.data` (items).

---

## 13. Error Handling

- **200/201:** Success; use `data` or `message` as needed.
- **400:** Bad request (e.g. empty cart, no phone for OTP).
- **401:** Unauthorized (invalid credentials or missing/invalid token).
- **403:** Forbidden (e.g. offer not for your account type).
- **404:** Resource not found.
- **422:** Validation error; body has `message` and `errors` (field-wise).
- **429:** Too many OTP requests; wait ~1 minute before resending.
- **500:** Server error; show generic message and retry option.

Standard error body shape:

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

---

## Quick Reference: Auth & OTP Endpoints

| Flow | Step | Method | Endpoint |
|------|------|--------|----------|
| Password login | 1 | POST | `/api/v1/login` |
| OTP login | 1 | POST | `/api/v1/auth/otp/login/start` |
| OTP login | 2 | POST | `/api/v1/auth/otp/login/verify` |
| Password register | 1 | POST | `/api/v1/register` |
| OTP register | 1 | POST | `/api/v1/auth/otp/register/start` |
| OTP register | 2 | POST | `/api/v1/auth/otp/register/verify` |
| Logout | - | POST | `/api/v1/logout` |
| Current user | - | GET | `/api/v1/user` |

All OTP is sent via **WhatsApp** to the user’s phone number. OTP is 6 digits; `otp_token` expires in about 10 minutes (configurable on server).
