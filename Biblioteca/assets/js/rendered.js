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
        filterPlaceholder: 'Buscar Autor(es)...',
        includeSelectAllOption: true,
        selectAllText: 'Selecionar Tudo',
        buttonWidth: '300px',
        maxHeight: 200,
        buttonText: function(options, select) {
            if (options.length === 0) {
                return 'Selecione o(s) Autor(es)';
            }
            else if (options.length > 4) {
                return 'Mais de 4 Autores selecionados!';
            }
            else {
                var labels = [];
                options.each(function() {
                    if ($(this).attr('label') !== undefined) {
                        labels.push($(this).attr('label'));
                    }
                    else {
                        labels.push($(this).html());
                    }
                });
                return labels.join(', ') + '';
            }
        }
    });
});
