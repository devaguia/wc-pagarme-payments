import { Payment } from "../../components/Payment";
import { Installments } from "./installments";

class Credit {
  constructor() {
    if (!document.querySelector("#woocommerce_wc-pagarme-credit_enabled"))
      return;
    new Payment();

    this.handleInstalments();
  }

  handleInstalments() {
    const button: HTMLInputElement|null = document.querySelector(
      "#woocommerce_wc-pagarme-credit_installments_config"
    );

    if (button) button.value = "Configure";

    button?.addEventListener("click", () => {
      this.getInstallmentsSettings();
    });
  }

  getInstallmentsSettings() {
    const data = new FormData();
    data.append("action", "get_installment_settings");

    fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
      method: "POST",
      body: data,
    })
      .then((response) => response.json())
      .then(function (response: any) {
        if (response?.content) {
          const installments = new Installments(response.content);

          const close = document.querySelector(".wpp-installments-settings > .close");
          close?.addEventListener("click", () => {
            installments.remove();
          });
        }
      });
  }

  saveInstallmentsSettings() {
    const data = new FormData();
    data.append("action", "save_installment_settings");

    fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
      method: "POST",
      body: data,
    }).then(function (response) {
      return response;
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new Credit();
});
