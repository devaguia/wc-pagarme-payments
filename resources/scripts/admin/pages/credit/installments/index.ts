import { Installments } from './index';
import { Ajax } from "../../../components/Ajax";
import { Popup } from "../../../components/Popup";

export class Installments extends Ajax {
  constructor(content: string) {
    super();
    this.create(content);
  }

  create(content: string) {
    const container = document.createElement("div");
    container.setAttribute("id", "wpp-installments-container");

    const popup = document.createElement("div");
    popup.classList.add("wpp-installments");
    popup.innerHTML = content;
    container?.appendChild(popup);

    const body = document.querySelector("body");
    body?.appendChild(container);

    this.submit();
  }

  remove() {
    const container = document.querySelector("#wpp-installments-container");
    container?.remove();
  }

  submit() {
    const form: HTMLFormElement | null = document.querySelector(
      ".wpp-installments-settings > form"
    );
    console.log(form);

    form?.addEventListener("submit", (e) => {
      e.preventDefault();
      this.saveSettings(form);
    });
  }

  saveSettings(form: HTMLFormElement) {
    const body = new FormData();
    body.append("action", "save_pagarme_installments");
    body.append("installments", JSON.stringify(this.get_installments()));
    
    this.setWaitingPopup();
    
    fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
      method: "POST",
      body: body,
    })
    .then((response) => response.json())
    .then((data: any) => {

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

  get_installments() {
    const elements: NodeListOf<HTMLInputElement> = document.querySelectorAll(".wpp-installment");
    const installments: Array<Object> = [];

    elements?.forEach(element => {
      const index = element.getAttribute("data-index");
      const value = element.value;

      const item  = {
        index: index, 
        value: value
      }

      installments.push(item);
    });

    return installments;
  }
}
