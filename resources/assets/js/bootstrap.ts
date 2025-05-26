// Import dependencies
import _ from 'lodash';
import axios from 'axios';
import jQuery from 'jquery';
import Echo from 'laravel-echo';
import io from 'socket.io-client';
import smartcrop from 'smartcrop';
import { Chart, registerables } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import tippy, { roundArrow } from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/dist/svg-arrow.css';
import 'tippy.js/themes/material.css';

// Type declarations
declare global {
  interface Window {
    $: typeof jQuery;
    jQuery: typeof jQuery;
    axios: typeof axios;
    Echo: Echo;
    io: typeof io;
    smartcrop: typeof smartcrop;
    Chart: typeof Chart;
    _: typeof _;
  }
}

// Initialize libraries
window._ = _;
window.$ = window.jQuery = jQuery;
window.axios = axios;
window.io = io;
window.smartcrop = smartcrop;

// Configure Axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

// Set CSRF token
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
}

// Initialize Chart.js
Chart.register(...registerables, ChartDataLabels);
window.Chart = Chart;

// Initialize Echo
window.Echo = new Echo({
  broadcaster: 'socket.io',
  host: window.location.hostname
});

// Configure Tippy.js
tippy('.tippy', {
  theme: 'material',
  arrow: roundArrow,
  duration: 500,
  placement: 'right'
});
