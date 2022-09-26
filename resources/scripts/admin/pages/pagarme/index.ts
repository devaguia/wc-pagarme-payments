class Service {
  constructor() {
    if (!document.querySelector(".wpp-container-pagarme")) return;

    this.submit();
  }

  submit() {
    const form : HTMLFormElement | null = document.querySelector("#wpp-pagarme-settings");

    form?.addEventListener("submit", (e) => {
      e.preventDefault();
      this.saveSettings(form);
    });
  }

  saveSettings(form: HTMLFormElement) {

    const body = new FormData(form);
    body.append("action", "save_pagarme_settings");

    fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
      method: "POST",
      body: body,

    }).then(function (response) {
      return response;
    });
  }
}

new Service;