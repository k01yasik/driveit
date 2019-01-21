$().ready(function () {

    if (typeof posts !== 'undefined' ) {

        let ctx = $('#postChart');

        let postLables = [];
        let postData = [];
        let postCount = 0;

        posts.forEach(function (element) {
            switch (element.month) {
                case 1:
                    element.month = 'Январь';
                    break;
                case 2:
                    element.month = 'Февраль';
                    break;
                case 3:
                    element.month = 'Март';
                    break;
                case 4:
                    element.month = 'Апрель';
                    break;
                case 5:
                    element.month = 'Май';
                    break;
                case 6:
                    element.month = 'Июнь';
                    break;
                case 7:
                    element.month = 'Июль';
                    break;
                case 8:
                    element.month = 'Август';
                    break;
                case 9:
                    element.month = 'Сентябрь';
                    break;
                case 10:
                    element.month = 'Октябрь';
                    break;
                case 11:
                    element.month = 'Ноябрь';
                    break;
                case 12:
                    element.month = 'Декабрь';
                    break;
            }
        });

        posts.forEach((element) => {
            postLables.push(element.month + ' ' + element.year);
            postData.push(element.count);
        });

        postData.forEach((element) => {
            postCount = postCount + element;
        });

        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: postLables,
                datasets: [{
                    label: 'Всего опубликовано статей - ' + postCount,
                    data: postData,
                    backgroundColor: '#573EA4',
                    datalabels: {
                        color: '#FFFFFF'
                    }
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    }
});