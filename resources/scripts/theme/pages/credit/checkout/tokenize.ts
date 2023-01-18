type TokenObject = {
    number: string|null,
    holder_name: string|null,
    exp_month: number|null,
    exp_year: number|null,
    cvv: number|null,
    brand: string|null
}

export class Tokenize {

  private cardObject: TokenObject = {
    number: null, 
    holder_name: null,
    exp_month: null,
    exp_year: null, 
    cvv: null,
    brand: null
  };

  private lastCardObject: TokenObject = {
    number: null, 
    holder_name: null, 
    exp_month: null, 
    exp_year: null, 
    cvv: null, 
    brand: null
  };
    
  constructor() {
    if (!document.querySelector(".wc_payment_method .payment_method_wc-pagarme-credit"))
      return;

    this.setEvents();
  }

  setEvents(): void {
    const gateways: HTMLInputElement | null = document.querySelector("#order_review");

    if (gateways) {
      gateways.addEventListener("focusin", () => {
        this.setExpireDate();
        this.setHolderName();
        this.setCardNumber();
        this.setCardBrand();
        this.setCardCvv();

        this.checkCardObjectFields();
      })
    }
  }

  setExpireDate(): void {
    const input: HTMLInputElement|null = document.querySelector("#wpp-card-expiry");

    if (input) {
        input.addEventListener("keyup", () => {

            if (input.value) {
                const splited = input.value.split("/");
        
                if (splited.length == 2) {

                    if (splited[0].length == 2) {
                      this.cardObject.exp_month = parseInt(splited[0]);
                    }

                    if (splited[1].length == 2) {
                      this.cardObject.exp_year = parseInt(splited[1]);
                    }
                }
            }
        });
    }
  }

  setHolderName(): void {
    const input: HTMLInputElement|null = document.querySelector("#wpp-card-owner");

    if (input) {
      input.addEventListener("keyup", () => {
          if (input.value) {
            this.cardObject.holder_name = input.value.toUpperCase();
          }
      });
    }
  }

  setCardNumber(): void {
    const input: HTMLInputElement|null = document.querySelector("#wpp-card-number");

    if (input) {
      input.addEventListener("keyup", () => {
          if (input.value) {
            this.cardObject.number = input.value.replace(/\s/g,'');
          }
      });
    }
  }

  setCardCvv(): void {
    const input: HTMLInputElement|null = document.querySelector("#wpp-card-cvv");

    if (input) {
      input.addEventListener("keyup", () => {
          if (input.value) {
            this.cardObject.cvv = parseInt(input.value);
          }
      });
    }
  }

  setCardBrand(): void {
    const number: HTMLInputElement|null = document.querySelector("#wpp-card-number");
    const input: HTMLInputElement|null = document.querySelector("#wpp-card-brand");

    if (number && input) {
      number.addEventListener("keyup", () => {
          if (input.value) {
            this.cardObject.brand = input.value;
          }
      });
    }
  }

  getPublickey(): string|boolean {
    const input: HTMLInputElement|null = document.querySelector("#wpp-public-key");

    if (input) {
      return input.value;
    }

    return false;
  }

  setCardToken(token: string): void {
    const input: HTMLInputElement|null = document.querySelector("#wpp-card-token");
    if (input) {
      input.value = token; 
    }
  }

  setLastCardObject(): void {
    this.lastCardObject = {
      number: this.cardObject['number'], 
      holder_name: this.cardObject['holder_name'],
      exp_month: this.cardObject['exp_month'],
      exp_year: this.cardObject['exp_year'], 
      cvv: this.cardObject['cvv'],
      brand: this.cardObject['brand']
    }
  }

  cardObjectHasDifference(): boolean {
    let hasDifference = false;

    Object.keys(this.cardObject).forEach(key => {
      let element = this.cardObject[key as keyof TokenObject];
      if (element !== this.lastCardObject[key as keyof TokenObject]) {
        hasDifference = true;
      }
    });

    return hasDifference;
  }

  checkCardObjectFields(): void {
    let isFilled = true;
    
    Object.keys(this.cardObject).forEach(key => {
      let element = this.cardObject[key as keyof TokenObject];
      if (element === null) {
        isFilled = false;
      }
    });

    if (isFilled && this.cardObjectHasDifference()) {
      this.createCardToken();
    }
  }

  createCardToken(): void {
    const data : {card: TokenObject, type: string} = {
      card: this.cardObject,
      type: 'card'
    }

    const publicKey = this.getPublickey();

    if (!publicKey) return;

    fetch(`https://api.pagar.me/core/v5/tokens?appId=${publicKey}`, {
      method: "POST",
      headers: {
        "accept": "application/json",
        "content-type": "application/json"
      },
      body: JSON.stringify(data),
    })
    .then((response) => response.json())
    .then((data: any) => {
      if (data.card) {
        this.setLastCardObject();
        this.setCardToken(JSON.stringify(data));
      }
    });
  }
}
