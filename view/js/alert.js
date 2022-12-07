const form_ajax = document.querySelectorAll(".JFormAjax");

function send_form_ajax(e){
    e.preventDefault();

    let data = new FormData(this);
    let method = this.getAttribute("method");
    let action = this.getAttribute("action");
    let type = this.getAttribute("data-form");

    let header = new Headers();

    let config = {
        method: method,
        headers: header,
        mode: 'cors',
        cache: 'no-cache',
        body: data
    }

    let text_alert;

    if(type==="save"){
        text_alert = "Los datos fueron guardados en el sistema";
    }else if(type==="delete"){
        text_alert = "Los datos fueron eliminados completamente del sistema";
    }else if(type==="update"){
        text_alert = "Los datos fueron actualizados en el sistema";
    }else if(type==="search"){
        text_alert = "Se eliminara el termino de busqueda y tendras que escribir uno nuevo";
    }else if(type==="loans"){
        text_alert = "Desea remover los datos seleccionados para prestamos o resevaciones";
    }else{
        text_alert = "Quieres realizar la operacion solicitada";
    }

    Swal.fire({
        title: '¿Estas seguro?',
        text: text_alert,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
            if (result.value) {
                fetch(action,config)
                .then(response => response.json())
                .then(response => {
                    return alert_ajax(response);
                });
            }
      });

}

form_ajax.forEach(form => {
    form.addEventListener("submit",send_form_ajax);
});

function alert_ajax(alert){
    if(alert.Alert==="simple"){
        Swal.fire({
            title: alert.title,
            text: alert.text,
            type: alert.type,
            confirmButtonText: 'Aceptar'
          });
    }else if(alert.Alert==="reload"){
        Swal.fire({
            title: alert.title,
            text: alert.text,
            type: alert.type,
            confirmButtonText: 'Aceptar'
          }).then((result) => {
                if (result.value) {
                    location.reload();
                }
          });
    }else if(alert.Alert==="clean"){
        Swal.fire({
            title: alert.title,
            text: alert.text,
            type: alert.type,
            confirmButtonText: 'Aceptar'
          }).then((result) => {
                if (result.value) {
                    document.querySelector(".JFormAjax").reset();
                }
          }) ;     
    }else if(alert.Alert==="redirect"){
        window.location.href=alert.URL;
    }
}