export class Notification {
  private title: string;
  private text: string;
  private time?: number;

  constructor(title: string, text: string, time?: number) {
    this.title = title;
    this.text = text;
    this.time = time;

    this.reset();
    this.make();
  }

  make(): void {
    const div = document.createElement("div");
    div.classList.add("wpp-notification");

    /** close button */
    const close = document.createElement("i");
    close.classList.add("wpp-notification-close", "fa-solid", "fa-xmark");

    /** notification title */
    const spanTitle = document.createElement("span");
    spanTitle.innerText = this.title;

    const title = document.createElement("div");
    title.classList.add("wpp-notification-title");
    title.appendChild(spanTitle);

    /** notification text */
    const spanText = document.createElement("span");
    spanText.innerText = this.text;

    const text = document.createElement("div");
    text.classList.add("wpp-notification-text");
    text.appendChild(spanText);

    /** append elements */
    div.appendChild(close);
    div.appendChild(title);
    div.appendChild(text);

    const container = document.querySelector(".wpp-container");
    container?.appendChild(div);

    this.closeButton(close);

    if (this.time) {
      setTimeout(() => {
        this.reset();
      }, this.time * 1000);
    }
  }

  closeButton(button: HTMLElement): void {
    button.addEventListener("click", () => {
      this.reset();
    });
  }

  reset(): void {
    const notifications = document.querySelectorAll(".wpp-notification");
    notifications.forEach((notification) => {
      notification.classList.add("wpp-notification-close");
      setTimeout(() => {
        notification.remove();
      }, 1000);
    });
  }
}
