import '../scss/app.scss';
import '../styles/carousel.css';
import '../bootstrap';

// app.js
const $ = require('jquery');
global.$ = global.jquery = $;

const moment = require('moment');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');