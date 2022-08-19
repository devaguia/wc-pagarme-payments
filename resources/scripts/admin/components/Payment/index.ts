export class Payment {
  
    constructor() {
        this.setClasses();
    }

    setClasses() {
        const wrap = document.querySelector("#mainform");
        wrap?.classList.add("wpp-container");
        wrap?.classList.add("wpp-container-payment");
    
        const trs = document.querySelectorAll("tr");
        trs?.forEach((tr) => {
          tr.classList.add("top-wpp");
        });
    }
}
  