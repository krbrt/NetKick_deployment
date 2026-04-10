# Fix Checkout COD
- [x] 1. Understand COD issue from CheckoutController.process() & view (uses session cart, sets status 'pending' for COD; duplicate 'status' line, DB Cart model unused)
- [x] 2. Fix controller DB transaction (removed duplicate status/payment_method; COD now sets notes='Cash on Delivery', status='pending')
- [ ] 3. Update view JS/form if needed
- [ ] 4. Test end-to-end

