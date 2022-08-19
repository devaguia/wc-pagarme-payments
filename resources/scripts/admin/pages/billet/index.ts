import { Payment } from "../../components/Payment";

class Billet {
  constructor() {
    if (!document.querySelector("#woocommerce_wc-pagarme-billet_enabled")) return;
    new Payment;
  }
}

document.addEventListener("DOMContentLoaded", () => {
    new Billet;
})
