export class Popup {
  constructor() {
    this.reset();
  }

  create() {
    const body: HTMLElement | null = document.querySelector("body");

    const icon = document.createElement("i");
    icon.setAttribute("id", "wpp-popup-icon");

    const iconDiv = document.createElement("div");
    iconDiv.classList.add("wpp-popup-icon");
    iconDiv.appendChild(icon);

    const title = document.createElement("span");
    title.setAttribute("id", "wpp-popup-title");

    const titleDiv = document.createElement("div");
    titleDiv.classList.add("wpp-popup-title");
    titleDiv.appendChild(title);

    const message = document.createElement("span");
    message.setAttribute("id", "wpp-popup-message");

    const messageDiv = document.createElement("div");
    messageDiv.classList.add("wpp-popup-message");
    messageDiv.appendChild(message);

    const popup = document.createElement("div");
    popup.classList.add("wpp-popup");
    popup.appendChild(iconDiv);
    popup.appendChild(titleDiv);
    popup.appendChild(messageDiv);

    const darker = document.createElement("div");
    darker.classList.add("wpp-darker");
    darker.appendChild(popup);

    body?.appendChild(darker);
  }

  setIcon(type: string) {
    const icon: HTMLElement | null = document.querySelector("#wpp-popup-icon");

    if (icon) {
      switch (type) {
        case "error":
          icon.className = "fa-solid fa-circle-xmark";
          break;

        case "success":
          icon.className = "fa-solid fa-circle-check";
          break;

        case "loading":
          icon.className = "fa-solid fa-spinner";
          break;

        case "warning":
          icon.className = "fa-solid fa-triangle-exclamation";
          break;

        default:
          icon.className = "";
          break;
      }
    }
  }

  setMessage(content: string) {
    const message: HTMLElement | null =
      document.querySelector("#wpp-popup-message");
    if (message) {
      message.innerText = content;
    }
  }

  setTitle(content: string) {
    const title: HTMLElement | null =
      document.querySelector("#wpp-popup-title");
    if (title) {
      title.innerText = content;
    }
  }

  setButton(text: string, classes: string, id: string) {
    const popup: HTMLElement | null = document.querySelector(".wpp-popup");
    const button: any = document.createElement("input");

    if (button) {
      button.setAttribute("type", "button");
      button.setAttribute("id", id);
      button.classList = classes;
      button.value = text;

      const divButton: HTMLElement = document.createElement("div");
      divButton.classList.add("wpp-popup-button");
      divButton.appendChild(button);

      popup?.appendChild(divButton);
    }
  }

  setButtons(data: Array<{id: string, classes: string, text: string}>) {
    const popup = document.querySelector(".wpp-popup");

    const divButton: HTMLElement = document.createElement("div");
    divButton.classList.add("wpp-popup-button");

    data.forEach((button) => {
      const element: any = document.createElement("input");
      console.log(element);
      if (element) {
        element.setAttribute("type", "button");
        element.setAttribute("id", button.id);
        element.classList = button.classes;
        element.value = button.text;
  
        divButton.appendChild(element);
      }
    });

    popup?.appendChild(divButton);
  }

  reset() {
    const elements: Array<string> = [
      "#wpp-popup-icon",
      "#wpp-popup-title",
      "#wpp-popup-message",
      ".wpp-popup",
      ".wpp-darker",
    ];

    elements.forEach((id) => {
      const element: HTMLElement | null = document.querySelector(id);
      if (element) {
        element.remove();
      }
    });
  }
}
