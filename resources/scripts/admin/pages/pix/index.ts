import { Payment } from "../../components/Payment";

class Pix {
  constructor() {
    if (!document.querySelector("#woocommerce_wc-pagarme-pix_enabled")) return;
    new Payment;
  }
}

document.addEventListener("DOMContentLoaded", () => {
    new Pix;
})
