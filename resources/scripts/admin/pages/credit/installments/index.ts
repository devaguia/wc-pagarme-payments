export class Instalments {
  constructor() {
    this.create();
  }

  create() {
    const popup = document.createElement("div");
    popup.classList.add("wpp-installments-popup");

    const container = document.createElement("div");
    container.setAttribute("id", "wpp-installments-container");

    const body = document.querySelector("body");

    container?.appendChild(popup);
    body?.appendChild(container);

    this.get();
  }

  get() {
    const data = new FormData();
    data.append("action", "get_installment_settings");

    fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
      method: "POST",
      body: data,
    }).then(function (response) {
      return response;
    });
  }

  save() {
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
