$('#recover').click(function () {
    $('form.login-form').animate({ height: "toggle", opacity: "toggle" }, "slow");
    $('form.recover-form').animate({ height: "toggle", opacity: "toggle" }, "slow");
});
$('#logrecover').click(function () {
    $('form.recover-form').animate({ height: "toggle", opacity: "toggle" }, "slow");
    $('form.login-form').animate({ height: "toggle", opacity: "toggle" }, "slow");
});
$('#register').click(function () {
    $('form.login-form').animate({ height: "toggle", opacity: "toggle" }, "slow");
    $('form.register-form').animate({ height: "toggle", opacity: "toggle" }, "slow");
});
$('#logregister').click(function () {
    $('form.register-form').animate({ height: "toggle", opacity: "toggle" }, "slow");
    $('form.login-form').animate({ height: "toggle", opacity: "toggle" }, "slow");
});

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function () {
        $('#divalert').fadeOut().empty();
    }, 5000);
}, false);

$(document).ready(function() {
    $('#autores').multiselect({
        inheritClass: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar Autor(es)...',
        includeSelectAllOption: true,
        selectAllText: 'Selecionar Tudo',
        buttonWidth: '100%',
        maxHeight: 200,
        nonSelectedText: 'Selecione o(s) Autor(es)',
        nSelectedText: ' - Autores selecionados',
        allSelectedText: 'Todos foram Selecionados'
    });
});

$(document).ready(function() {
    $('#categoria').multiselect({
        inheritClass: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar Categoria...',
        buttonWidth: '100%',
        maxHeight: 200,
        nonSelectedText: 'Selecione a Categoria',
    });
});

$(document).ready(function() {
    $('#editora').multiselect({
        inheritClass: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar Editora...',
        buttonWidth: '100%',
        maxHeight: 200,
        nonSelectedText: 'Selecione a Editora',
    });
});

function notificacao(icon, titulo, texto, tipo){
    return $.notify({
        // opções
        icon: icon,
        title: titulo,
        message: texto 
    },{
        // configurações
        type: tipo,
        placement: {
            from: "top",
            align: "center"
        },
        delay: 5000,
	    timer: 1000
    });
};