import { Chart, registerables } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

Chart.register(...registerables);
Chart.register(ChartDataLabels);

type ChartData = {
  month: number;
  year: number;
  count: number;
};


interface DashboardData {
  posts?: ChartData[];
  commentsVerified?: number;
  commentsNotVerified?: number;
  datesQuery?: string[];
  usersQuery?: number[];
  sessionQuery?: number[];
  hitsQuery?: number[];
  countryQueryLabels?: string[];
  countryQueryData?: number[];
  cityQueryLabels?: string[];
  cityQueryData?: number[];
};

// Константы для повторно используемых значений
const COLORS = {
  primary: '#573EA4',
  secondary: '#EF4747',
  tertiary: '#BF3985',
  success: '#39BF39',
  warning: '#EFD247',
  palette: [
    '#EF4747', '#EFD247', '#573EA4', '#39BF39', '#EF9347',
    '#EFEF47', '#7A369F', '#2B8F8F', '#EFB747', '#ABDF43',
    '#BF3985', '#3C5AA0'
  ]
};

const MONTH_NAMES: { [key: number]: string } = {
  1: 'Январь', 2: 'Февраль', 3: 'Март', 4: 'Апрель', 5: 'Май', 6: 'Июнь',
  7: 'Июль', 8: 'Август', 9: 'Сентябрь', 10: 'Октябрь', 11: 'Ноябрь', 12: 'Декабрь'
};

// Функция для создания подписей месяцев
const createMonthLabels = (posts: ChartData[]): string[] => {
  return posts.map(post => {
    const monthName = MONTH_NAMES[post.month] || `Месяц ${post.month}`;
    return `${monthName} ${post.year}`;
  });
};

// Функция для создания чарта
const createChart = (
  elementId: string,
  type: 'bar' | 'line' | 'doughnut',
  data: {
    labels: string[];
    datasets: {
      label?: string;
      data: number[];
      backgroundColor?: string | string[];
      borderColor?: string;
      fill?: string;
      datalabels?: {
        color?: string;
        display?: boolean;
      };
    }[];
  },
  options?: object
): Chart | null => {
  const ctx = document.getElementById(elementId) as HTMLCanvasElement | null;
  if (!ctx) {
    console.error(`Element with id ${elementId} not found`);
    return null;
  }

  return new Chart(ctx, { type, data, options });
};

// Основная функция инициализации дашборда
const initDashboard = (data: DashboardData): void => {
  if (!data.posts) return;

  // Posts chart
  createChart(
    'postChart',
    'bar',
    {
      labels: createMonthLabels(data.posts),
      datasets: [{
        label: 'Количество опубликованных статей',
        data: data.posts.map(post => post.count),
        backgroundColor: COLORS.primary,
        datalabels: { color: '#FFFFFF' }
      }]
    },
    {
      scales: {
        yAxes: [{ ticks: { beginAtZero: true } }]
      }
    }
  );

  // Comments chart
  if (data.commentsVerified !== undefined && data.commentsNotVerified !== undefined) {
    createChart(
      'commentsChart',
      'doughnut',
      {
        labels: ['Одобренные комментарии', 'Неодобренные комментарии'],
        datasets: [{
          data: [data.commentsVerified, data.commentsNotVerified],
          backgroundColor: [COLORS.primary, COLORS.secondary],
          datalabels: { color: '#FFFFFF' }
        }]
      }
    );
  }

  // Users chart
  if (data.datesQuery && data.usersQuery && data.sessionQuery && data.hitsQuery) {
    createChart(
      'usersChart',
      'line',
      {
        labels: data.datesQuery,
        datasets: [
          {
            label: 'Количество пользователей',
            data: data.usersQuery,
            backgroundColor: COLORS.primary,
            borderColor: COLORS.primary,
            fill: 'origin',
            datalabels: { display: false }
          },
          {
            label: 'Количество сессий',
            data: data.sessionQuery,
            backgroundColor: COLORS.secondary,
            borderColor: COLORS.secondary,
            fill: 'origin',
            datalabels: { display: false }
          },
          {
            label: 'Количество взаимодействий',
            data: data.hitsQuery,
            backgroundColor: COLORS.tertiary,
            borderColor: COLORS.tertiary,
            fill: 'origin',
            datalabels: { display: false }
          }
        ]
      },
      {
        scales: {
          yAxes: [{ ticks: { beginAtZero: true } }]
        }
      }
    );
  }

  // Country chart
  if (data.countryQueryLabels && data.countryQueryData) {
    createChart(
      'countryChart',
      'doughnut',
      {
        labels: data.countryQueryLabels,
        datasets: [{
          data: data.countryQueryData,
          backgroundColor: COLORS.palette,
          datalabels: { color: '#FFFFFF' }
        }]
      }
    );
  }

  // City chart
  if (data.cityQueryLabels && data.cityQueryData) {
    createChart(
      'cityChart',
      'doughnut',
      {
        labels: data.cityQueryLabels,
        datasets: [{
          data: data.cityQueryData,
          backgroundColor: COLORS.palette.slice(0, 10), // Берем первые 10 цветов
          datalabels: { color: '#FFFFFF' }
        }]
      }
    );
  }
};

document.addEventListener('DOMContentLoaded', () => {
  const dashboardData: DashboardData = window.dashboardData || {};
  initDashboard(dashboardData);
});
