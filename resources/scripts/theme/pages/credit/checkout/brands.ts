export class Brands {
  constructor() {
    if (
      !document.querySelector(
        ".wc_payment_method .payment_method_wc-pagarme-credit"
      )
    )
      return;

    this.setEvents();
  }

  setEvents(): void {
    const gateways: HTMLInputElement | null =
      document.querySelector("#order_review");

    if (gateways) {
      gateways.addEventListener("focusin", () => {
        this.handleBrand();
      });
    }
  }

  handleBrand(): void {
    const card: HTMLInputElement | null =
      document.querySelector("#wpp-card-number");
    const cvv: HTMLInputElement | null =
      document.querySelector("#wpp-card-cvv");

    if (card) {
      card.addEventListener("keyup", () => {
        const brand: string = this.getCard(card.value.replace(/\s/g, ""));
        this.setBrand(brand);
      });
    }

    if (cvv) {
      cvv.addEventListener("keyup", () => {
        this.setCvv(cvv.value);
      });
    }
  }

  setBrand(brand: string): void {
    const img: HTMLImageElement | null = document.querySelector(
      "#wpp-credi-card-icon"
    );

    const hidden: HTMLInputElement | null = document.querySelector(
      "#wpp-card-brand"
    );

    if (img) {
      const attr = img.getAttribute("data-img");
      if (attr) {
        img.src = img.src.replace(attr, brand);
        img.setAttribute("data-img", brand);
      }
    }

    if (hidden) {
        hidden.value = brand;
    }
  }

  setCvv(cvv: string): void {
    const img: HTMLImageElement | null =
      document.querySelector("#wpp-cvv-icon");

    const brand = cvv.length < 3 ? "mono/cvv" : "cvv";

    if (img) {
      const attr = img.getAttribute("data-img");
      if (attr) {
        img.src = img.src.replace(attr, brand);
        img.setAttribute("data-img", brand);
      }
    }
  }

  getCard(card: string): string {
    const brandsRegex: any = {
      mastercard: new RegExp("^(?:5[1-5][0-9]{14})"),
      visa: new RegExp("^4[0-9]{12}(?:[0-9]{3})"),
      elo: new RegExp(
        "^((((636368)|(438935)|(504175)|(451416)|(636297))d{0,10})|((5067)|(4576)|(4011))d{0,12})"
      ),
      hipercard: new RegExp("^606282|^3841(?:[0|4|6]{1})0"),
      jcb: new RegExp("^(?:2131|1800|35[0-9]{3})[0-9]{11}$"),
      dinersclub: new RegExp("^3(?:0[0-5]|[68][0-9])[0-9]{11}"),
      discover: new RegExp("^6(?:011|5[0-9]{2})[0-9]{12}"),
      amex: new RegExp("^3[47][0-9]{13}$"),
      aura: new RegExp("^((?!504175))^((?!5067))(^50[0-9])"),
    };

    for (let brand in brandsRegex) {
      if (brandsRegex[brand].test(card)) {
        return brand;
      }
    }

    return "mono/generic";
  }
}
