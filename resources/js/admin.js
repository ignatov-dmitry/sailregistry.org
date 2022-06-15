import $ from 'jquery';
window.$ = window.jQuery = $;
require('selectize');
require('admin-lte/dist/js/adminlte')
require('jquery-mask-plugin');
window.bsCustomFileInput = require('admin-lte/plugins/bs-custom-file-input/bs-custom-file-input');

$(document).ready(function (){
    $('#certificate_type_parent_id').selectize({
        placeholder: 'Родительский сертификат',
    });
    $('#country_id').selectize({
        placeholder: 'Страна',
    });

    let school_admin = $('#admin_id').selectize({
        placeholder: 'Введите логин'
    });

    $('#is_active').selectize({
        placeholder: 'Активация'
    });

    let selectize_school_admin = school_admin[0].selectize;

    $('#admin_id-selectized').keyup(function () {
        let search = $(this).val();

        if (search.length > 2) {
            $.ajax({
                url: '/admin/users/ajax/get_users_by_user_login',
                data: {user_login: $(this).val()},
                success: function (users) {
                    selectize_school_admin.clearOptions();
                    $.each(users, function (index, value) {
                        selectize_school_admin.addOption({value: value['id'], text: value['user_login']});
                    });
                    selectize_school_admin.refreshOptions();
                }
            });
        }
    });

    $('#phone').mask('+7 (000) 000-00-00');
});