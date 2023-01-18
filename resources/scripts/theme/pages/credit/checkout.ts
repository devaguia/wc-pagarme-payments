import { Masks } from './checkout/masks';
import { Brands } from './checkout/brands';
import { Tokenize } from './checkout/tokenize';
class Checkout {
  constructor() {
    if (!document.querySelector(".wc_payment_method .payment_method_wc-pagarme-credit"))
      return;

    new Brands;
    new Masks;
    new Tokenize;
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new Checkout();
});
