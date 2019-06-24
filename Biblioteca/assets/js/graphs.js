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
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        labels: {
                            display: true
                        }
                    }
                }
            });
        }
    });
});

//Exporta o Gráfico
$('#buttontotalresemp').on('click', function(){
    html2canvas($('#charttotalresemp'), {
        onrendered: function(canvas) {
            var imgData = canvas.toDataURL('image/png');
            var pdf = new jsPDF('p', 'mm');
            pdf.setFontSize(22);
            pdf.text(25, 25, "Total de Reservas e Emprestimos no Mês Atual");
            pdf.addImage(imgData, 'PNG', 25, 40);
            pdf.save('test.pdf');
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
                    }
                }
            });
        }
    });
});

//Exporta o Gráfico
$('#buttonresmes').on('click', function(){
    html2canvas($('#chartreservames'), {
        onrendered: function(canvas) {
            var imgData = canvas.toDataURL('image/png');
            var pdf = new jsPDF('p', 'mm');
            pdf.setFontSize(22);
            pdf.text(25, 25, "Reservas por Mês - 3 últimos");
            pdf.addImage(imgData, 'PNG', 25, 40);
            pdf.save('test.pdf');
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
                    }
                }
            });
        }
    });
});

//Exporta o Gráfico
$('#buttonempmes').on('click', function(){
    html2canvas($('#chartemprestimomes'), {
        onrendered: function(canvas) {
            var imgData = canvas.toDataURL('image/png');
            var pdf = new jsPDF('p', 'mm');
            pdf.setFontSize(22);
            pdf.text(25, 25, "Emprestimos por Mês - 3 últimos");
            pdf.addImage(imgData, 'PNG', 25, 40);
            pdf.save('test.pdf');
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
                    }
                }
            });
        }
    });
});

//Exporta o Gráfico
$('#buttonrescat').on('click', function(){
    html2canvas($('#chartreservacategoria'), {
        onrendered: function(canvas) {
            var imgData = canvas.toDataURL('image/png');
            var pdf = new jsPDF('p', 'mm');
            pdf.setFontSize(22);
            pdf.text(25, 25, "Reservas por Categorias");
            pdf.addImage(imgData, 'PNG', 25, 40);
            pdf.save('test.pdf');
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
                    }
                }
            });
        }
    });
});

//Exporta o Gráfico
$('#buttonempcat').on('click', function(){
    html2canvas($('#chartemprestimocategoria'), {
        onrendered: function(canvas) {
            var imgData = canvas.toDataURL('image/png');
            var pdf = new jsPDF('p', 'mm');
            pdf.setFontSize(22);
            pdf.text(25, 25, "Emprestimos por Categorias");
            pdf.addImage(imgData, 'PNG', 25, 40);
            pdf.save('test.pdf');
        }
    });
});
