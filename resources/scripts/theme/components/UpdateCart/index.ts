export class UpdateCart {
    constructor() {
      if (!document.querySelector("#payment_method_wc-pagarme-billet"))
        return;
  
      this.setEvents();
    }
  
    setEvents(): void {
      const gateways: HTMLInputElement | null = document.querySelector("#order_review");
  
      if (gateways) {
        gateways.addEventListener("focusin", () => {
          this.updateCart();
        })
      }
    }
  
    updateCart(): void {
      const methods: NodeListOf<HTMLInputElement> = document.querySelectorAll('input[name="payment_method"]' );
  
      methods.forEach(method => {
          method.addEventListener("click", () => {
              const event: Event = new Event('update_checkout');
              document.body.dispatchEvent(event);
          })
      });
    }
}