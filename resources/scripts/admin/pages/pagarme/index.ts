import { Popup } from "../../components/Popup";

class Service {
  constructor() {
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

  setWaitingPopup() {
    const popup: Popup = new Popup();
    popup.create();
    popup.setIcon('loading');
    popup.setTitle('Aguarde!');
    popup.setMessage('Carregando...');
  }

  setSuccessPopup(title: string, message: string) {
    const popup: Popup = new Popup();

    popup.create();
    popup.setIcon("success");
    popup.setTitle(title);
    popup.setMessage(message);
    popup.setButtons([
      {
        text: "Confirmar",
        classes: "btn btn-success btn-reload",
        id: "wpp-success-form",
      },
    ]);
  }

  setErrorPopup(title: string, message: string) {
    const popup: Popup = new Popup();

    popup.create();
    popup.setIcon("error");
    popup.setTitle(title);
    popup.setMessage(message);
    popup.setButtons([
      {
        text: "Cancelar",
        classes: "btn btn-failed btn-reload",
        id: "wpp-error-form",
      },
    ]);
  }

  setReloadFuncion() {
    const buttons: NodeListOf<HTMLElement> | null = document.querySelectorAll(".wpp-popup-button .btn-reload");
    buttons.forEach(button => {
      button.addEventListener("click", () => {
        window.location.reload();
      })
    });
  }
}

new Service();
