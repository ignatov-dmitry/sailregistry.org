require('selectize');
require('jquery-mask-plugin');
require('admin-lte/dist/js/adminlte')
window.bsCustomFileInput = require('admin-lte/plugins/bs-custom-file-input/bs-custom-file-input');
require('./bootstrap');
import $ from 'jquery';
window.$ = window.jQuery = $;
require('inputmask');

$(document).ready(function (){
    $('#img').change(function () {
        let rd = new FileReader(); // Создаем объект чтения файла
        let files = this.files [0]; // Получаем файлы в файловом компоненте
        rd.readAsDataURL(files); // чтение файла заменено на тип base64
        rd.onloadend = function (e) {
            // После загрузки получаем результат и присваиваем его img
            document.getElementById("photo").src = this.result;
        }
    });

    $('#user_form').submit(function (e){
        e.preventDefault();
        let ruFields = $('input[name$="name_ru"]');

        $.ajax({
            url: '/admin/users/transliterationNames',
            dataType: 'json',
            data: ruFields,
            beforeSend: function (){
                $('.preload').css('display', 'block');
            },
            success: function (data) {
                $.each(data, function (item, value){
                    $('#' + item).val(value);
                });
                $('.preload').css('display', 'none');
                $('#user_form').unbind('submit').submit();
            }
        });
    });

    $('#certificate_type_parent_id').selectize({placeholder: 'Родительский сертификат'});
    $('#country_id').selectize({placeholder: 'Страна'});

    let school_admin = $('#admin_id').selectize({
        placeholder: 'Введите логин',
        plugins: ["remove_button"]
    });

    if (school_admin[0] !== undefined) {
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
    }

    $('#is_active').selectize({
        placeholder: 'Активация'
    });
    $('#countries').selectize({
        placeholder: 'Страны',
        plugins: ["remove_button"]
    });
    $('#schools').selectize({
        placeholder: 'Школы',
        plugins: ["remove_button"]
    });

    $('#school_id').selectize({
        placeholder: 'Школа',
    });

    $('#school_ids').selectize({
        placeholder: 'Школа',
        plugins: ["remove_button"]
    });

    $('#type').selectize({
        placeholder: 'Тип'
    });

    $('#source').selectize({
        placeholder: 'Источник'
    });

    $('#phone').mask('+7 (000) 000-00-00');
});

Inputmask({ alias: "datetime", inputFormat: "dd.mm.yyyy"}).mask(".date");
