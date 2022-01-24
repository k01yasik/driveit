if (typeof posts !== 'undefined' ) {

    let ctx = $('#postChart');
    let ctx2 = $('#commentsChart');
    let ctx3 = $('#usersChart');
    let ctx4 = $('#countryChart');
    let ctx5 = $('#cityChart');

    let postLabels = [];
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
        postLabels.push(element.month + ' ' + element.year);
        postData.push(element.count);
    });

    postData.forEach((element) => {
        postCount = postCount + element;
    });

    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: postLabels,
            datasets: [{
                label: 'Количество опубликованных статей',
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

    let commentsCount = commentsVerified + commentsNotVerified;

    let commentsDoughnutChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Одобренные комментарии', 'Неодобренные комментарии'],
            datasets: [{
                data: [commentsVerified, commentsNotVerified],
                backgroundColor: ['#573EA4', '#EF4747'],
                datalabels: {
                    color: '#FFFFFF'
                }
            }]
        }
    });

    let usersChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: datesQuery,
            datasets: [{
                label: 'Количество пользователей',
                data: usersQuery,
                backgroundColor: '#573EA4',
                borderColor: '#573EA4',
                fill: 'origin',
                datalabels: {
                    display: false
                }
            },{
                label: 'Количество сессий',
                data: sessionQuery,
                backgroundColor: '#EF4747',
                borderColor: '#EF4747',
                fill: 'origin',
                datalabels: {
                    display: false
                }
            },{
                label: 'Количество взаимодействий',
                data: hitsQuery,
                backgroundColor: '#BF3985',
                borderColor: '#BF3985',
                fill: 'origin',
                datalabels: {
                    display: false
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

    let countryDoughnutChart = new Chart(ctx4, {
        type: 'doughnut',
        data: {
            labels: countryQueryLabels,
            datasets: [{
                data: countryQueryData,
                backgroundColor: ['#EF4747', '#EFD247', '#573EA4', '#39BF39', '#EF9347', '#EFEF47', '#7A369F', '#2B8F8F', '#EFB747', '#ABDF43', '#BF3985', '#3C5AA0'],
                datalabels: {
                    color: '#FFFFFF'
                }
            }]
        }
    });

    let cityChart = new Chart(ctx5, {
        type: 'doughnut',
        data: {
            labels: cityQueryLabels,
            datasets: [{
                data: cityQueryData,
                backgroundColor: ['#EF4747', '#EFD247', '#573EA4', '#39BF39', '#EF9347', '#EFEF47', '#7A369F', '#2B8F8F', '#EFB747', '#ABDF43'],
                datalabels: {
                    color: '#FFFFFF'
                }
            }]
        }
    });
}