import { UpdateCart } from "../../components/UpdateCart";

class Checkout {
  constructor() {
    if (!document.querySelector("#payment_method_wc-pagarme-billet"))
      return;

    new UpdateCart();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new Checkout();
});
