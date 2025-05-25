// Import dependencies directly instead of attaching to window where possible
import _ from 'lodash';
import axios from 'axios';
import jQuery from 'jquery';
import Echo from 'laravel-echo';
import io from 'socket.io-client';
import smartcrop from 'smartcrop';
import Chart from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import tippy, { roundArrow } from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/dist/svg-arrow.css';
import 'tippy.js/themes/material.css';

// Type declarations for window extensions
declare global {
  interface Window {
    $: typeof jQuery;
    jQuery: typeof jQuery;
    axios: typeof axios;
    Echo: Echo;
    io: typeof io;
    smartcrop: typeof smartcrop;
    Chart: typeof Chart;
  }
}

// Initialize jQuery
try {
  window.$ = window.jQuery = jQuery;
} catch (e) {
  console.error('jQuery initialization failed', e);
}

// Initialize Lodash
window._ = _;

// Configure Axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

// Set CSRF token
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Initialize Socket.io and Echo
window.io = io;
window.Echo = new Echo({
  broadcaster: 'socket.io',
  host: window.location.hostname //+ ':6001'
});

// Initialize Smartcrop
window.smartcrop = smartcrop;

// Initialize Chart.js
window.Chart = Chart;
Chart.plugins.register(ChartDataLabels);

// Configure Tippy.js
tippy('.tippy', {
  theme: 'material',
  arrow: roundArrow,
  duration: 500,
  placement: 'right'
});

// Optional: Export initialized libraries for module usage
export { axios, jQuery as $, _, Echo, io, smartcrop, Chart, tippy };
