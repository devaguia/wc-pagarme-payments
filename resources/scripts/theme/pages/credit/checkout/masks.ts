import IMask from "imask";

export class Masks {
  constructor() {
    if (!document.querySelector(".wc_payment_method .payment_method_wc-pagarme-credit"))
      return;

    this.setEvents();
  }

  setEvents(): void {
    const gateways: HTMLInputElement | null = document.querySelector("#order_review");

    if (gateways) {
      gateways.addEventListener("focusin", () => {
        this.cardMask();
        this.dateMask();
        this.cvvMask();
        this.ownerMask();
      })
    }
  }

  cardMask(): void {
    const card: HTMLInputElement | null = document.querySelector("#wpp-card-number");

    if (card) {
      var mask = {
        mask: '0000 0000 0000 0000'
      };
      IMask(card, mask);
    }
  }

  dateMask(): void {
    const date: HTMLInputElement | null = document.querySelector("#wpp-card-expiry");

    if (date) {
      var mask = {
        mask: '00/00'
      };
      IMask(date, mask);
    }
  }

  cvvMask(): void {
    const cod: HTMLInputElement | null = document.querySelector("#wpp-card-cvv");

    if (cod) {
      var mask = {
        mask: '0000'
      };
      IMask(cod, mask);
    }
  }

  ownerMask(): void {
    const cod: HTMLInputElement | null = document.querySelector("#wpp-card-owner");

    if (cod) {
      var mask = {
        mask: /^[A-Z]+$/i
      };
      IMask(cod, mask);
    }
  }
}
