import { Payment } from "../../components/Payment";

class Credit {
  constructor() {
    if (!document.querySelector("#woocommerce_wc-pagarme-credit_enabled")) return;
    new Payment;
  }
}

document.addEventListener("DOMContentLoaded", () => {
    new Credit;
})
