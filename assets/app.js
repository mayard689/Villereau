/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
const $ = require('jquery');

require('bootstrap');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

//installed with "yarn add aos@next"
import AOS from 'aos';
import 'aos/dist/aos.css';
AOS.init({
    easing: "ease-out",
    duration: 800,
    mirror : true,
});
