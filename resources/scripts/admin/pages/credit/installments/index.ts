export class Installments {
  constructor(content: string) {
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
  }

  remove() {
    const container = document.querySelector("#wpp-installments-container");
    container?.remove();
  }
}
