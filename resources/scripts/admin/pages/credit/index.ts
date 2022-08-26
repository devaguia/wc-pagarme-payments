import { Payment } from "../../components/Payment";
import { Instalments } from "./installments";

class Credit {
  constructor() {
    if (!document.querySelector("#woocommerce_wc-pagarme-credit_enabled")) return;
    new Payment;

    this.handleInstalments();
  }

  handleInstalments() {
    const button = document.querySelector("#woocommerce_wc-pagarme-credit_installments_config");
    button?.addEventListener("click", () => {
      new Instalments;
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
    new Credit;
});
