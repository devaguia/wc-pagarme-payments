import { Masks } from './checkout/masks';
import { Brands } from './checkout/brands';
import { Tokenize } from './checkout/tokenize';
import { UpdateCart } from '../../components/UpdateCart';
class Checkout {
  constructor() {
    if (!document.querySelector(".wc_payment_method .payment_method_wc-pagarme-credit"))
      return;

    new Brands;
    new Masks;
    new Tokenize;
    new UpdateCart
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new Checkout();
});
