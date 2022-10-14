import { Popup } from "../Popup";

export abstract class Ajax {
    setWaitingPopup() {
        const popup: Popup = new Popup();
        popup.create();
        popup.setIcon('loading');
        popup.setTitle('Aguarde!');
        popup.setMessage('Carregando...');
      }
    
      setSuccessPopup(title: string, message: string) {
        const popup: Popup = new Popup();
    
        popup.create();
        popup.setIcon("success");
        popup.setTitle(title);
        popup.setMessage(message);
        popup.setButtons([
          {
            text: "Confirmar",
            classes: "btn btn-success btn-reload",
            id: "wpp-success-form",
          },
        ]);
      }
    
      setErrorPopup(title: string, message: string) {
        const popup: Popup = new Popup();
    
        popup.create();
        popup.setIcon("error");
        popup.setTitle(title);
        popup.setMessage(message);
        popup.setButtons([
          {
            text: "Cancelar",
            classes: "btn btn-failed btn-reload",
            id: "wpp-error-form",
          },
        ]);
      }
    
      setReloadFuncion() {
        const buttons: NodeListOf<HTMLElement> | null = document.querySelectorAll(".wpp-popup-button .btn-reload");
        buttons.forEach(button => {
          button.addEventListener("click", () => {
            window.location.reload();
          })
        });
      }
}