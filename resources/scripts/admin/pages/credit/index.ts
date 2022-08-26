import { Payment } from "../../components/Payment";
import { Instalments } from "./installments";

class Credit {
  constructor() {
    if (!document.querySelector("#woocommerce_wc-pagarme-credit_enabled")) return;
    new Payment;
  }

  handleInstalments() {
    const button = document.querySelector("#");
    button?.addEventListener("click", () => {
      new Instalments;
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
    new Credit;
});
