// Import dependencies
import _ from 'lodash';
import axios from 'axios';
import jQuery from 'jquery';
import Echo from 'laravel-echo';
import io from 'socket.io-client';
import Pusher from 'pusher-js';
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
    Echo: Echo<'socket.io'> | Echo<'reverb'>;
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

// Use Reverb when configured, with Socket.IO for existing Redis deployments.
const reverbKey = process.env.MIX_REVERB_APP_KEY;
const reverbUsesTls = (process.env.MIX_REVERB_SCHEME ?? 'https') === 'https';
const reverbPort = Number(process.env.MIX_REVERB_PORT ?? (reverbUsesTls ? 443 : 80));

window.Echo = reverbKey
  ? new Echo({
      broadcaster: 'reverb',
      Pusher,
      key: reverbKey,
      wsHost: process.env.MIX_REVERB_HOST ?? window.location.hostname,
      wsPort: reverbPort,
      wssPort: reverbPort,
      forceTLS: reverbUsesTls,
      enabledTransports: ['ws', 'wss']
    })
  : new Echo({
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
