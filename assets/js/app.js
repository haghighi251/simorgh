import '../scss/app.scss';
import '../styles/carousel.css';
import '../bootstrap';
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

// app.js
const $ = require('jquery');
global.$ = global.jquery = $;

const moment = require('moment');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');