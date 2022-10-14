import { Ajax } from "../../components/Ajax";
import { Popup } from "../../components/Popup";

class Service extends Ajax {
  constructor() {
    super();
    if (!document.querySelector(".wpp-container-pagarme")) return;

    this.submit();
  }

  submit() {
    const form: HTMLFormElement | null = document.querySelector(
      "#wpp-pagarme-settings"
    );

    form?.addEventListener("submit", (e) => {
      e.preventDefault();
      this.saveSettings(form);
    });
  }

  saveSettings(form: HTMLFormElement) {
    const body = new FormData(form);
    body.append("action", "save_pagarme_settings");

    this.setWaitingPopup();
    
    fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
      method: "POST",
      body: body,
    })
    .then((response) => response.json())
    .then((data: any) => {

      console.log(data);
      if (data.content) {
        const content: any = data.content;
        const message: string = content?.message;
        const title: string = content?.title;

        if (content?.code === 200) {
          this.setSuccessPopup(title, message);
        } else {
          this.setErrorPopup(title, message);
        }
        this.setReloadFuncion();

        const button = document.querySelector("#wpp-success-form");

        if (button) {
          button.addEventListener("click", () => {
            window.location.reload();
          })
        }
      }
    });
  }
}

new Service();
