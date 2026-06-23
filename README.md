# Virtual Marketplace for Local Artisans

**Phase 1 (done):** database schema + registration + login + role-based
access control (Admin / Seller / Customer) + session management.

**Phase 2 (done):** Seller Dashboard — products, orders, earnings, plus
Shop Profile, Reviews & Ratings, and Analytics.

**Phase 3 (done):** Customer Marketplace — browse, product detail, cart,
checkout, order tracking, reviews, profile.

## ⚠️ Migrations needed if you imported schema.sql before now

Run these in phpMyAdmin → `artisan_marketplace` → **SQL** tab, in order
(skip any you've already run):

```
database/migration_02_order_item_status.sql      -- per-item fulfillment status
database/migration_03_profile_reviews.sql         -- seller_profiles + reviews tables
database/migration_04_customer_marketplace.sql    -- cart_items, users.address/profile_image, settings.delivery_fee
```

Fresh install? Just import `database/schema.sql` — it already includes
everything.

## What's included

```
artisan-marketplace/
├── config/database.php        PDO connection
├── database/                  schema.sql + all migrations + seed scripts
├── includes/
│   ├── auth.php                Session + role-check helpers
│   ├── seller_helpers.php      Commission/earnings calc + star-rating renderer
│   ├── seller_header.php / seller_footer.php / seller_nav.php
│   ├── customer_helpers.php    Cart count/items/subtotal, delivery fee
│   └── customer_header.php / customer_footer.php  Storefront navbar + footer
├── auth/                       register / login / logout
├── dashboard/
│   ├── admin.php               Placeholder — admin-only (next phase)
│   ├── seller/                 Products, Orders, Earnings, Reviews, Analytics, Profile, Documents
│   └── customer/
│       ├── index.php           Home: categories + featured products
│       ├── products.php        Browse: search, category/price filter, sort, pagination
│       ├── product_detail.php  Gallery, price, reviews, related products, Add to Cart / Buy Now
│       ├── cart.php / cart_add.php / cart_update.php / cart_remove.php
│       ├── checkout.php / checkout_process.php   Address + payment method + order creation
│       ├── orders.php          Order history, per-item tracking timeline, leave a review
│       ├── order_review_save.php
│       ├── profile.php / profile_save.php / change_password.php
├── assets/css/style.css        One shared design system across the whole site
├── uploads/seller_docs/        Seller verification files
├── uploads/products/           Product images + shop/profile images (reused across roles)
└── index.php                   Landing page
```

## Setup (XAMPP)

1. **Copy the project folder** into your XAMPP `htdocs` directory.
2. **Start Apache and MySQL** from the XAMPP Control Panel.
3. **Create the database:** open `http://localhost/phpmyadmin` → **Import**
   tab → choose `database/schema.sql` → **Go**.
   (Existing DB from an earlier phase? Run the migration files above instead.)
4. **Check `config/database.php`** — defaults (`root` / no password) match
   a fresh XAMPP install.
5. **Visit:** `http://localhost/artisan-marketplace/`

## Testing the full shopping loop (this is the important one)

1. Log in as a **seller**, add a product with stock > 0 (Products → Add Product).
2. Log out, **register a new Customer** (or log in as an existing one).
3. **Products** → search/filter/sort all work against real data now. Open a
   product → **Product Detail** shows price, stock, seller name, reviews
   (empty at first), related products.
4. **Add to Cart**, adjust quantity on the **Cart** page, then **Proceed to
   Checkout**.
5. Fill delivery info, pick a payment method, **Place Order**.
   - JazzCash/Easypaisa are simulated as paid instantly (no real gateway —
     a student project can't integrate one without a merchant account).
   - Cash on Delivery stays "pending" until the seller marks the item
     **delivered** — at that point the payment auto-flips to "completed"
     (collected at the door), which is what makes it count toward the
     seller's earnings.
6. **Orders** page shows the order with a tracking timeline. Stock was
   already deducted from the product at checkout, and the seller got a
   **notification** (check their bell icon).
7. Log back in as the **seller** → **Orders** → move the item through
   pending → processing → shipped → **delivered**. Check **Earnings** —
   the sale now counts.
8. Log back in as the **customer** → **Orders** → the delivered item now
   has a **Leave a Review** button. Submit one with a star rating.
9. Log in as the seller again → **Reviews** page shows it, and you can
   reply. **Analytics** and the product's **Product Detail** page on the
   customer side will reflect the new rating too.

This loop is the real test of the whole project — it exercises every
table in the schema end to end.

## Notes for your report / viva

- **Cart is database-backed** (`cart_items` table), not session-based, so
  it survives logout/login — consistent with storing everything else in
  MySQL per the synopsis.
- **Stock is decremented inside a database transaction** at checkout
  (`SELECT ... FOR UPDATE` + rollback on failure), preventing two
  customers from overselling the same limited-stock item.
- **Delivery fee** is a single configurable value in the `settings` table
  (`delivery_fee`, default Rs 200) — ready for the Admin Dashboard to
  expose as a setting later.
- **One review per purchase**: a review is tied to a specific
  `order_item_id`pso a customer can only review something they actually
  bought and received, and only once per purchase.
- Passwords hashed with `password_hash()` (bcrypt); all queries use PDO
  **prepared statements** (SQL-injection safe) throughout, including the
  new customer-facing pages.
- Every customer page that loads a specific order, cart item, or review
  checks ownership against the session user — one customer can't view or
  modify another customer's cart/orders by guessing an ID in the URL.
- Reviews, Profile, Analytics, and the full Customer Marketplace UX
  (filters, sort, tracking timeline) are **not** in the original approved
  synopsis — they were added as optional extras on top of it. Worth a
  one-line mention in your report/viva so the scope difference is clear.

## Next phase (not built yet)

1. ~~Seller Dashboard~~ ✅
2. ~~Customer Marketplace~~ ✅
3. **Admin Dashboard**: approve/reject sellers, commission & delivery-fee
   settings, platform-wide revenue, refund management
