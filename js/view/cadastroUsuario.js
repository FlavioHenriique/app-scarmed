// Iniciando Datepicker
$(document).ready(function(){
    var date_input=$('input[name="data"]');
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
        format: 'mm/dd/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    };
    date_input.datepicker(options);
})

// Obtendo parâmetro 'msg' da URL para mostrar a mensagem com SweetAlert
let url = new URL(window.location.href);
let msg = url.searchParams.get('message');
if (msg != null) {
    if (msg == 'sucess') {
        Swal.fire(
            'Pronto!',
            'Usuário cadastrado com sucesso!',
            'success'
        );
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Opa...',
            text: msg
        });
    }
}

// Esta function atribui o valor do 'required' do campo 'numInscricao'
// de acordo com o checkbox marcado
function marcaEhProfissional() {
    let marcado = document.getElementById('ehProfissional').checked;
    document.getElementById("numInscricao").required = marcado;
}