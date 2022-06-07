require('./bootstrap');
require('selectize');
require('admin-lte/dist/js/adminlte')
window.bsCustomFileInput = require('admin-lte/plugins/bs-custom-file-input/bs-custom-file-input')
import $ from 'jquery';
window.$ = window.jQuery = $;

$('#schools').selectize({
    placeholder: 'Школы',
    plugins: ["remove_button"],
});
