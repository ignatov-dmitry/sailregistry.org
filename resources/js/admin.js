import $ from 'jquery';
window.$ = window.jQuery = $;
require('selectize');
require('admin-lte/dist/js/adminlte')
window.bsCustomFileInput = require('admin-lte/plugins/bs-custom-file-input/bs-custom-file-input');

$('#certificate_type_parent_id').selectize({
    placeholder: 'Родительский сертификат',
});
