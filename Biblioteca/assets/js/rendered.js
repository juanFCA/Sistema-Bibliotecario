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
