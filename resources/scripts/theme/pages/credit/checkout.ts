import IMask from "imask";

class Checkout {
  constructor() {
    if (!document.querySelector(".wc_payment_method .payment_method_wc-pagarme-credit"))
      return;

    this.setMasks();
  }

  setMasks() {
    this.cardMask();
    this.dateMask();
    this.cvvMask();

    /**
     * updated_wc_div
     * wc_fragment_refresh
     * update_checkout
     */
    const gateways: HTMLInputElement | null = document.querySelector("#order_review");

    if (gateways) {
      gateways.addEventListener("focusin", () => {
        this.cardMask();
        this.dateMask();
        this.cvvMask();
      })
    }
  }

  cardMask() {
    const card: HTMLInputElement | null = document.querySelector("#wpp-card-number");

    if (card) {
      var mask = {
        mask: '0000 0000 0000 0000'
      };
      IMask(card, mask);
    }
  }

  dateMask() {
    const date: HTMLInputElement | null = document.querySelector("#wpp-card-expiry");

    if (date) {
      var mask = {
        mask: '00/00'
      };
      IMask(date, mask);
    }
  }

  cvvMask() {
    const cod: HTMLInputElement | null = document.querySelector("#wpp-card-cvv");

    if (cod) {
      var mask = {
        mask: '0000'
      };
      IMask(cod, mask);
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new Checkout();
});
