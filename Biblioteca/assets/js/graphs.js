function gerarCores(quantidade) {
    var hexadecimal = '0123456789ABCDEF'.split('');
    var cores = [];
    for (var i = 0; i < quantidade; i++ ) {
        var cor = '#';
        for (var j = 0; j < 6; j++) {
            cor += hexadecimal[Math.floor(Math.random() * 16)];
        }
        cores.push(cor);
    }
    return cores;
}

$(document).ready(function(){
    $.ajax({
        type: 'POST',
        url: 'dashboardData.php?tipo=totalResEmp',
        success: function(data){
            var ctx = document.getElementById('charttotalresemp').getContext('2d');
            new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: data[0],
                    datasets: [{
                        label: 'Reservas',
                        data: data[1],
                        backgroundColor: '#FFB133'
                    },{
                        label: 'Emprestimos',
                        data: data[2],
                        backgroundColor: '#33FFA0'
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            display: false
                        }
                    },
                }
            });
        }
    });
});

$(document).ready(function(){
    $.ajax({
        type: 'POST',
        url: 'dashboardData.php?tipo=reservaMes',
        success: function(data){
            var ctx = document.getElementById('chartreservames').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data[0],
                    datasets: [{
                        label: 'Livros',
                        data: data[1],
                        backgroundColor: gerarCores(data[1].length)
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            display: false
                        }
                    },
                }
            });
        }
    });
});

$(document).ready(function(){
    $.ajax({
        type: 'POST',
        url: 'dashboardData.php?tipo=emprestimoMes',
        success: function(data){
            var ctx = document.getElementById('chartemprestimomes').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data[0],
                    datasets: [{
                        label: 'Livros',
                        data: data[1],
                        backgroundColor: gerarCores(data[1].length)
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            display: false
                        }
                    },
                }
            });
        }
    });
});

$(document).ready(function(){
    $.ajax({
        type: 'POST',
        url: 'dashboardData.php?tipo=reservaCategoria',
        success: function(data){
            var ctx = document.getElementById('chartreservacategoria').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data[0],
                    datasets: [{
                        label: 'Livros',
                        data: data[1],
                        backgroundColor: gerarCores(data[1].length)
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            display: false
                        }
                    },
                }
            });
        }
    });
});

$(document).ready(function(){
    $.ajax({
        type: 'POST',
        url: 'dashboardData.php?tipo=emprestimoCategoria',
        success: function(data){
            var ctx = document.getElementById('chartemprestimocategoria').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data[0],
                    datasets: [{
                        label: 'Livros',
                        data: data[1],
                        backgroundColor: gerarCores(data[1].length)
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            display: false
                        }
                    },
                }
            });
        }
    });
});