# TAP Payment Webhook API — Integration Guide

**Version:** 1.0  
**Environment:** Staging  
**Base URL:** `http://stg-gw.tadlbd.com:885`  
**Prepared by:** DITSL Development Team  
**Date:** March 2026

---

## INDEX

| # | Section | Page |
|---|---------|------|
| 1 | [Deposit Webhook](#1-deposit-webhook) | 2 |
| 2 | [Transaction Enquiry](#2-transaction-enquiry) | 5 |
| 3 | [Reconciliation](#3-reconciliation) | 8 |
| 4 | [HMAC Signature Generation Guide](#4-hmac-signature-generation-guide) | 12 |
| 5 | [Status Code Reference](#5-status-code-reference) | 16 |

---

## 1. Deposit Webhook

Receives a deposit notification from TAP. The system verifies the HMAC signature, prevents duplicate processing (idempotency), locates the customer wallet by phone number, credits the wallet balance for completed deposits, and stores the event.

**API Endpoint:**

```
POST http://stg-gw.tadlbd.com:885/api/v1/tap/deposit-webhook
```

**Headers:**

- `X-Tap-Signature: {HMAC-SHA256 hex of raw request body}`  *(or `X-Webhook-Signature`)*
- `Content-Type: application/json`

---

### 1.1 Request Parameters

| SL | Parameter Name | Data Type | Required | Description |
|----|---------------|-----------|----------|-------------|
| 1 | `id` / `event_id` | string | Yes | Unique TAP event identifier — used for idempotency |
| 2 | `event` / `event_type` | string | Yes | TAP event type e.g. `charge.completed` |
| 3 | `data` | object | Yes | Charge / transaction data object |
| 4 | `data.id` | string | Yes | TAP charge / transaction ID |
| 5 | `data.amount` | decimal | Yes | Transaction amount |
| 6 | `data.currency` | string (3) | Yes | ISO 4217 currency code e.g. `AED`, `BDT` |
| 7 | `data.status` | string | Yes | TAP status: `CAPTURED` \| `completed` \| `pending` |
| 8 | `data.customer.phone.number` | string | Yes | Customer phone number — used to locate wallet |
| 9 | `data.metadata.user_id` | string | No | Optional internal user / wallet ID |

---

### 1.2 Response Parameters

| SL | Parameter Name | Data Type | Description |
|----|---------------|-----------|-------------|
| 1 | `statusCode` | int | HTTP / business status code |
| 2 | `message` | string | Human-readable result message |
| 3 | `data` | object | Response data object (see below) — `null` on error |

**`data {}` — Response Object:**

| Parameter Name | Data Type | Description |
|---------------|-----------|-------------|
| `event_id` | string | DITSL-generated event ID e.g. `DITSL_1710000000_abc123` |
| `event_type` | string | Canonical event type e.g. `wallet.deposit.completed` |
| `timestamp` | string | ISO 8601 processing timestamp |
| `transaction_id` | string | TAP charge / transaction ID |
| `external_reference` | string | Original TAP event ID echoed back |
| `user_id` | string | Internal user / wallet ID |
| `amount` | decimal | Credited amount |
| `currency` | string | ISO 4217 currency code |
| `status` | string | `completed` \| `pending` \| `failed` |
| `processed_by` | string | Always `"DITSL"` |
| `current_balance` | decimal | Updated wallet balance after deposit |

---

### 1.3 Example

**Request Body:**
```json
{
  "id": "evt_TAP_12345",
  "event": "charge.completed",
  "data": {
    "id": "chg_TAP_ABC123",
    "amount": 500.00,
    "currency": "AED",
    "status": "CAPTURED",
    "customer": {
      "phone": {
        "number": "0501234567"
      }
    },
    "metadata": {
      "user_id": "42"
    }
  }
}
```

**Sample Response (200 — Success):**
```json
{
  "statusCode": 200,
  "message": "Deposit processed successfully",
  "data": {
    "event_id": "DITSL_1710000000_abc1",
    "event_type": "wallet.deposit.completed",
    "timestamp": "2026-03-15T10:30:00+00:00",
    "transaction_id": "chg_TAP_ABC123",
    "external_reference": "evt_TAP_12345",
    "user_id": "42",
    "amount": 500.00,
    "currency": "AED",
    "status": "completed",
    "processed_by": "DITSL",
    "current_balance": 1500.00
  }
}
```

**Sample Response (200 — Duplicate Event):**
```json
{
  "statusCode": 200,
  "message": "Event already processed",
  "data": {
    "event_id": "evt_TAP_12345",
    "status": "duplicate"
  }
}
```

**Sample Response (401 — Invalid Signature):**
```json
{
  "statusCode": 401,
  "message": "Invalid webhook signature",
  "data": null
}
```

**Sample Response (400 — Wallet Not Found):**
```json
{
  "statusCode": 400,
  "message": "Wallet not found",
  "data": null
}
```

---

## 2. Transaction Enquiry

Queries a single transaction by its internal `transaction_id` or the TAP `external_reference`. Useful for real-time status verification. If `transaction_id` is supplied it is matched first; the system falls back to `external_reference` if no match is found.

**API Endpoint:**

```
POST http://stg-gw.tadlbd.com:885/api/v1/tap/transaction-enquiry
```

**Headers:**

- `X-Tap-Signature: {HMAC-SHA256 hex of raw request body}`
- `Content-Type: application/json`

---

### 2.1 Request Parameters

> ⚠️ At least one of `transaction_id` or `external_reference` must be provided.

| SL | Parameter Name | Data Type | Required | Description |
|----|---------------|-----------|----------|-------------|
| 1 | `transaction_id` | string | Conditional | TAP charge ID stored in the system |
| 2 | `external_reference` | string | Conditional | TAP event ID — fallback lookup if `transaction_id` not found |

---

### 2.2 Response Parameters

| SL | Parameter Name | Data Type | Description |
|----|---------------|-----------|-------------|
| 1 | `statusCode` | int | HTTP / business status code |
| 2 | `message` | string | Human-readable result message |
| 3 | `data` | object | Transaction object (see below) — `null` if not found |

**`data {}` — Transaction Object:**

| Parameter Name | Data Type | Description |
|---------------|-----------|-------------|
| `transaction_id` | string | TAP charge / transaction ID |
| `external_reference` | string | TAP event ID |
| `user_id` | string | Internal user / wallet ID |
| `wallet_number` | string | Customer phone number (wallet identifier) |
| `amount` | decimal | Transaction amount |
| `currency` | string | ISO 4217 currency code |
| `status` | string | `completed` \| `pending` \| `failed` |
| `processed_at` | string | ISO 8601 timestamp of processing |
| `failure_reason` | string \| null | Error description if failed; `null` otherwise |
| `final` | boolean | `true` when status is `completed` or `failed` (no further changes expected) |
| `current_balance` | decimal \| null | Current wallet balance; `null` if wallet unavailable |
| `event_id` | string | DITSL internal event ID |
| `event_type` | string | e.g. `wallet.deposit.completed` |

---

### 2.3 Example

**Request Body:**
```json
{
  "transaction_id": "chg_TAP_ABC123",
  "external_reference": "evt_TAP_12345"
}
```

**Sample Response (200 — Found):**
```json
{
  "statusCode": 200,
  "message": "Transaction found",
  "data": {
    "transaction_id": "chg_TAP_ABC123",
    "external_reference": "evt_TAP_12345",
    "user_id": "42",
    "wallet_number": "0501234567",
    "amount": 500.00,
    "currency": "AED",
    "status": "completed",
    "processed_at": "2026-03-15T10:30:00+00:00",
    "failure_reason": null,
    "final": true,
    "current_balance": 1500.00,
    "event_id": "DITSL_1710000000_abc1",
    "event_type": "wallet.deposit.completed"
  }
}
```

**Sample Response (404 — Not Found):**
```json
{
  "statusCode": 404,
  "message": "Transaction not found",
  "data": null
}
```

**Sample Response (400 — No Identifier Provided):**
```json
{
  "statusCode": 400,
  "message": "Either transaction_id or external_reference is required",
  "data": null
}
```

---

## 3. Reconciliation

Returns all transactions within a date range. Supports optional status filtering and cursor-based pagination using `limit` / `offset`. Maximum **1,000 records** per request. Use this endpoint for end-of-day batch reconciliation or audit purposes.

**API Endpoint:**

```
POST http://stg-gw.tadlbd.com:885/api/v1/tap/reconciliation
```

**Headers:**

- `X-Tap-Signature: {HMAC-SHA256 hex of raw request body}`
- `Content-Type: application/json`

---

### 3.1 Request Parameters

| SL | Parameter Name | Data Type | Required | Default | Description |
|----|---------------|-----------|----------|---------|-------------|
| 1 | `from_date` | string | Yes | — | Start of date range. ISO 8601 (`2026-03-01T00:00:00Z`) or `YYYY-MM-DD` |
| 2 | `to_date` | string | Yes | — | End of date range. Same formats accepted. |
| 3 | `status` | string | No | all | Filter: `completed` \| `pending` \| `failed` |
| 4 | `limit` | int | No | `100` | Max records per response (hard cap: `1000`) |
| 5 | `offset` | int | No | `0` | Records to skip for pagination |

**Date Format Reference:**

| Format | Example | Notes |
|--------|---------|-------|
| ISO 8601 full | `2026-03-01T00:00:00Z` | Recommended |
| Date only | `2026-03-01` | `from_date` defaults to `00:00:00`; `to_date` defaults to `23:59:59` |

---

### 3.2 Response Parameters

| SL | Parameter Name | Data Type | Description |
|----|---------------|-----------|-------------|
| 1 | `statusCode` | int | HTTP / business status code |
| 2 | `message` | string | Human-readable result message |
| 3 | `data` | object | Pagination wrapper + transactions array (see below) |

**`data {}` — Reconciliation Object:**

| Parameter Name | Data Type | Description |
|---------------|-----------|-------------|
| `from_date` | string | Echoed start date input |
| `to_date` | string | Echoed end date input |
| `total_count` | int | Total matching records in the database (ignores pagination) |
| `returned_count` | int | Records returned in this response |
| `limit` | int | Applied limit |
| `offset` | int | Applied offset |
| `transactions` | array | List of transaction objects — same schema as Transaction Enquiry `data {}` |

---

### 3.3 Pagination

```
// Page 1
{ "from_date": "2026-03-01", "to_date": "2026-03-15", "limit": 100, "offset": 0 }

// Page 2
{ "from_date": "2026-03-01", "to_date": "2026-03-15", "limit": 100, "offset": 100 }
```

To check if there are more pages:  
`has_more = (offset + returned_count) < total_count`

---

### 3.4 Example

**Request Body:**
```json
{
  "from_date": "2026-03-01T00:00:00Z",
  "to_date":   "2026-03-15T23:59:59Z",
  "status":    "completed",
  "limit":     100,
  "offset":    0
}
```

**Sample Response (200):**
```json
{
  "statusCode": 200,
  "message": "Reconciliation data retrieved",
  "data": {
    "from_date": "2026-03-01T00:00:00Z",
    "to_date": "2026-03-15T23:59:59Z",
    "total_count": 250,
    "returned_count": 100,
    "limit": 100,
    "offset": 0,
    "transactions": [
      {
        "transaction_id": "chg_TAP_ABC123",
        "external_reference": "evt_TAP_12345",
        "user_id": "42",
        "wallet_number": "0501234567",
        "amount": 500.00,
        "currency": "AED",
        "status": "completed",
        "processed_at": "2026-03-15T10:30:00+00:00",
        "failure_reason": null,
        "final": true,
        "current_balance": 1500.00,
        "event_id": "DITSL_1710000000_abc1",
        "event_type": "wallet.deposit.completed"
      }
    ]
  }
}
```

**Sample Response (400 — Missing Dates):**
```json
{
  "statusCode": 400,
  "message": "Both from_date and to_date are required (ISO 8601 format)",
  "data": null
}
```

**Sample Response (400 — Invalid Date Format):**
```json
{
  "statusCode": 400,
  "message": "Invalid date format. Use ISO 8601 (2026-03-01T00:00:00Z) or date format (2026-03-01)",
  "data": null
}
```

---

## 4. HMAC Signature Generation Guide

> **Security Note:** The shared secret (`TAP_WEBHOOK_SECRET`) is provisioned by the DITSL team. Never expose it in client-side code, logs, or version control.

---

### 4.1 Key Rules

| Rule | Detail |
|------|--------|
| Algorithm | `HMAC-SHA256` |
| Output format | Lowercase hex string (64 characters) |
| Input | Raw JSON body — do **NOT** re-serialise after signing |
| Encoding | UTF-8 for both key and message |
| Header | `X-Tap-Signature` (fallback: `X-Webhook-Signature`) |
| Server check | Timing-safe comparison (`hash_equals`) |

---

### 4.2 Authentication Flow

```
Caller                                           DITSL Server
  │                                                   │
  │  1. Build JSON payload                            │
  │  2. Compute HMAC-SHA256(rawBody, secret)          │
  │  3. Set header: X-Tap-Signature = <hex>           │
  │                                                   │
  │──── POST /api/v1/tap/{endpoint} ─────────────────▶│
  │     Header : X-Tap-Signature: <hex>               │
  │     Body   : { ...json... }                       │
  │                                                   │
  │                        4. Read raw body           │
  │                        5. Compute expected HMAC   │
  │                        6. hash_equals() compare   │
  │                                                   │
  │◀─── 401 Unauthorized  (mismatch) ─────────────────│
  │◀─── 200 / 400 / 404   (valid)    ─────────────────│
```

---
## 5. Status Code Reference

### 5.1 Summary Table

| Status Code | Message | Description |
|-------------|---------|-------------|
| `200` | Success / varies | Request processed successfully |
| `400` | Bad Request / varies | Invalid payload, missing required fields, or wallet not found |
| `401` | Missing webhook signature | `X-Tap-Signature` header absent |
| `401` | Invalid webhook signature | HMAC comparison failed |
| `404` | Transaction not found | No matching transaction in the system |
| `500` | Internal server error | Unhandled server-side exception or DB failure |
| `500` | Webhook configuration error | `TAP_WEBHOOK_SECRET` not set in environment |

---

### 5.2 Complete Error Responses

| Scenario | Response |
|----------|----------|
| Missing signature | `{"statusCode":401,"message":"Missing webhook signature","data":null}` |
| Invalid signature | `{"statusCode":401,"message":"Invalid webhook signature","data":null}` |
| Secret not configured | `{"statusCode":500,"message":"Webhook configuration error","data":null}` |
| Invalid payload structure | `{"statusCode":400,"message":"Invalid payload structure","data":null}` |
| Missing required fields | `{"statusCode":400,"message":"Missing required transaction fields","data":null}` |
| Wallet not found | `{"statusCode":400,"message":"Wallet not found","data":null}` |
| No identifier given | `{"statusCode":400,"message":"Either transaction_id or external_reference is required","data":null}` |
| Missing date range | `{"statusCode":400,"message":"Both from_date and to_date are required (ISO 8601 format)","data":null}` |
| Invalid date format | `{"statusCode":400,"message":"Invalid date format. Use ISO 8601 (2026-03-01T00:00:00Z) or date format (2026-03-01)","data":null}` |
| Transaction not found | `{"statusCode":404,"message":"Transaction not found","data":null}` |
| Server exception | `{"statusCode":500,"message":"Internal server error","data":null}` |

---

*Document maintained by the DITSL Development Team — Staging Base URL: `http://stg-gw.tadlbd.com:885` — March 2026*
