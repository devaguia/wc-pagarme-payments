import { Ajax } from "../../components/Ajax";

class Service extends Ajax {
  constructor() {
    super();
    if (!document.querySelector(".wpp-container-pagarme")) return;

    this.submit();
    this.showTokenContent();
    this.checkTokenContent();
    this.exportSettingsFile();
    this.copyWebhook();
  }

  exportSettingsFile(): void {
    const input: HTMLInputElement|null = document.querySelector("#wpp-export-settings");

    input?.addEventListener("click", () => {
      this.getSettingsContent();
    });
  }

  getSettingsContent(): void {
    const data = new FormData();
    data.append("action", "export_settings_file");

    fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
      method: "POST",
      body: data
    })
    .then((response: any) => response.json())
    .then((data: any) => {
      this.downloadSettingsFile(JSON.stringify(data.content, null, 4));
    });
  }

  downloadSettingsFile( content: string ): void {
    const file = new File([content], 'export.json', {
      type: 'application/json',
    });

    const url: string = URL.createObjectURL(file);
    const element: HTMLElement|null = document.createElement('a');

    if (element) {
      element.setAttribute('href', url);
      element.setAttribute('download', 'export.json');
    
      document.body.appendChild(element);
    
      element.click();
    
      document.body.removeChild(element);
    }
  }

  copyWebhook(): void {
    const field: HTMLInputElement|null = document.querySelector("#wpp-webhook-link");
    const button: HTMLAnchorElement|null = document.querySelector("#wpp-webhook-copy");

    if (!field || !button) return;

    button.addEventListener("click", () => {
      let value = field.value;

      try {
       navigator.clipboard.writeText(value);

      } catch (error) {
        field.select();
        document.execCommand('copy');
      }
    });
  }

  showTokenContent(): void {
    const fields: NodeListOf<HTMLInputElement> = document.querySelectorAll("#wpp-pagarme-settings input[type=password");
    if (fields) {
      fields.forEach(field => {
        field.addEventListener("focusin", () => {
          field.setAttribute("type", "text");
        })

        field.addEventListener("focusout", () => {
          field.setAttribute("type", "password");
        })
      });
    }
  }

  checkTokenContent(): void {
    const secretKey: HTMLInputElement|null = document.querySelector("#wpp-secret-key");
    const publicKey: HTMLInputElement|null = document.querySelector("#wpp-public-key");

    if (!secretKey || !publicKey) return;
    
    this.checkEqualKeys(secretKey, publicKey);
    this.checkValidKeys(secretKey, publicKey);

    [secretKey, publicKey].forEach(element => {
      element.addEventListener("keyup", () => {
        this.checkEqualKeys(secretKey, publicKey);
        this.checkValidKeys(secretKey, publicKey);
      });
    });
  }
  
  checkValidKeys( secretKey: HTMLInputElement, publicKey: HTMLInputElement ) {
    const warning: HTMLDivElement|null = document.querySelector("#wpp-warning-valid-key");

    if (!warning) return;

    const sKey = secretKey.value.includes('sk_');
    const pKey = publicKey.value.includes('pk_');

    if (!sKey || !pKey) {
      warning.classList.add('wpp-warning-active');
      this.controlSubmitDisabled(true);
    } else {
      warning.classList.remove('wpp-warning-active');
      this.controlSubmitDisabled(false);
    }
  }

  checkEqualKeys( secretKey: HTMLInputElement, publicKey: HTMLInputElement ) {
    const warning: HTMLDivElement|null = document.querySelector("#wpp-warning-equal-key");

    if (!warning) return;

    const secretMode = secretKey.value.includes('sk_test_');
    const publicMode = publicKey.value.includes('pk_test_');

    if (secretMode !== publicMode) {
      warning.classList.add('wpp-warning-active');
      this.controlSubmitDisabled(true);
    } else {
      warning.classList.remove('wpp-warning-active');
      this.controlSubmitDisabled(false);

      const mode = secretMode  ? 'test' : 'production';
      this.setPaymentMode(mode);
    }
  }

  controlSubmitDisabled(active: boolean = true): void {
    const submit: HTMLInputElement|null = document.querySelector("#wpp-submit");

    if (!active) {
      submit?.removeAttribute("disabled");
      submit?.classList.remove("wpp-submit-disabled");
    } else {
      submit?.setAttribute("disabled", "");
      submit?.classList.add("wpp-submit-disabled");
    }
  }

  setPaymentMode( mode: string): void {
    const paymentMode: HTMLInputElement|null = document.querySelector("#wpp-payment-mode");
    console.log(mode);
    if (paymentMode && mode) {
      paymentMode.value = mode;
    }
  }

  submit(): void {
    const form: HTMLFormElement | null = document.querySelector(
      "#wpp-pagarme-settings"
    );

    form?.addEventListener("submit", (e) => {
      e.preventDefault();
      this.saveSettings(form);
    });
  }

  saveSettings(form: HTMLFormElement): void {
    const body = new FormData(form);
    body.append("action", "save_pagarme_settings");

    this.setWaitingPopup();
    
    fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
      method: "POST",
      body: body,
    })
    .then((response) => response.json())
    .then((data: any) => {

      console.log(data);
      if (data.content) {
        const content: any = data.content;
        const message: string = content?.message;
        const title: string = content?.title;

        if (content?.code === 200) {
          this.setSuccessPopup(title, message);
        } else {
          this.setErrorPopup(title, message);
        }
        this.setReloadFuncion();

        const button = document.querySelector("#wpp-success-form");

        if (button) {
          button.addEventListener("click", () => {
            window.location.reload();
          })
        }
      }
    });
  }
}

new Service();
