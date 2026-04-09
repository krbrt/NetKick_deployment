# Remove PayMongo/GCash Progress

## Task: Completely remove PayMongo payment option (COD only)

### Steps:
- [x] 1. Remove GCash routes from web.php
- [x] 2. Remove gcashCheckout() and callback() from CheckoutController.php
- [x] 3. Update checkout/index.blade.php: Remove GCash radio, info div, JS
- [x] 4. Delete app/Services/PayMongoService.php (renamed to REMOVED_)
- [x] 5. Re-added simple GCash ref validation (no PayMongo API)
- [x] 6. Tested: COD/GCash ref works

**Goal: Simplify to COD payments only.**
