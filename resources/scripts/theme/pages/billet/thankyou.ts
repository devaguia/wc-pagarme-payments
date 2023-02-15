class Thankyou {
    constructor() {
      if (!document.querySelector(".wpp-thakyou-page-billet"))
        return;

        this.copyBilletLine();
    }

    copyBilletLine(): void {
        const button: HTMLInputElement|null = document.querySelector("#wpp-copy-billet");

        if (button) {
            button.addEventListener("click", () => {
                const input: HTMLInputElement|null = document.querySelector("#wpp-billet-line");

                if (input) {
                    try {
                        navigator.clipboard.writeText(input.value);
                 
                    } catch (error) {
                        input.select();
                        document.execCommand('copy');
                    }
                }
            });
        }
    }
}
  
  document.addEventListener("DOMContentLoaded", () => {
    new Thankyou();
  });
  