require('./bootstrap');
require('selectize');
import $ from 'jquery';
window.$ = window.jQuery = $;

$('#schools').selectize({
    placeholder: 'Школы',
    plugins: ["remove_button"],
});
