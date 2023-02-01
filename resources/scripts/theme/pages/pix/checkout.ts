import { UpdateCart } from "../../components/UpdateCart";

class Checkout {
  constructor() {
    if (!document.querySelector("#payment_method_wc-pagarme-pix"))
      return;

    new UpdateCart();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new Checkout();
});
