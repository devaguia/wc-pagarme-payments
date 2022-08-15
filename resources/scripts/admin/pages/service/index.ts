import { Notification } from "../../components/Notification";

class Service {
  constructor() {
    if (!document.querySelector(".wcpt-container-about")) return;
    this.handleNotification();
  }

  handleNotification(): void {
    setTimeout(() => {
      new Notification("Hello World!", "This is a example notification", 5);
    }, 1000);
  }
}

new Service;
