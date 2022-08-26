export class Instalments {
  constructor(content: string) {
    this.create(content);
  }

  create(content: string) {
    const container = document.createElement("div");
    container.classList.add("wpp-popup-container");

    const popup = document.createElement("div");
    popup.classList.add("wpp-popup");
    popup.innerHTML = content;
    container?.appendChild(popup);

    const body = document.querySelector("body");
    body?.appendChild(container);
  }
}
