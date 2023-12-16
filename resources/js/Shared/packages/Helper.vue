<script>
export default {
    computed: {
        user_permissions() {
            const user = window.permissions;
            if (Object.keys(user).length > 0) {
                if (user.hasOwnProperty('permissions_name')) {
                    return user.permissions_name;
                }
            }
            return [];
        },
    },
    methods: {
        $isObject(obj) {
            return JSON.stringify(obj) !== '{}';
        },
        $can(_permissions) {
            if (Array.isArray(_permissions)) {
                let result = false;
                _permissions.forEach((item) => {
                    if (window.permissions.indexOf(item) !== -1) {
                        result = true;
                    }
                });
                return result;
            }
            return window.permissions.indexOf(_permissions) !== -1;
        },
        $clone(obj) {
            return JSON.parse(JSON.stringify(obj));
        },
        $clearParams(filters) {
            const params = {};
            if (filters.page > 1) params.page = filters.page;
            Object.keys(filters).forEach((column) => {
                if (filters[column] && column != 'page') {
                    params[column] = filters[column];
                }
            });
            return params;
        },
        $formDataClearNull(data_arr) {
            let data = new FormData();
            for (const [key, value] of Object.entries(data_arr)) {
                if (typeof value === 'object' && (value !== null)) {
                    for (const [keyObject, valueObject] of Object.entries(value)) {
                        // console.log(typeof valueObject === 'object' && (valueObject !== null),valueObject)
                        if (typeof valueObject === 'object' && (valueObject !== null)) {
                            for (const [keyObjectNested, valueObjectNested] of Object.entries(valueObject)) {
                                data.append(`${key}[${keyObject}][${keyObjectNested}]`, valueObjectNested ? valueObjectNested.trim() : '');
                            }
                        } else {
                            data.append(`${key}[${keyObject}]`, valueObject || '');
                        }
                    }
                } else {
                    data.append(key, value || '');
                }
            }
            return data;
        },
        $formData(data, variable) {
            const form_data = new FormData();
            Object.keys(data).forEach((column) => {
                if (Array.isArray(data[column])) {
                    if (data[column]) {
                        if (Object.keys(data[column]).length) {
                            Object.keys(data[column]).forEach((index) => {
                                const value = data[column][index] === undefined ? '' : data[column][index];
                                if (variable) form_data.append(`${variable}[${column}][${index}]`, value);
                                else form_data.append(`${column}[${index}]`, value);
                            });
                        } else if (variable) form_data.append(`${variable}[${column}]`, []);
                        else form_data.append(column, []);
                    }
                } else {
                    const value = data[column] === undefined ? '' : data[column];
                    if (variable) form_data.append(`${variable}[${column}]`, value);
                    else form_data.append(column, value);
                }
            });
            return form_data;
        },
        $swalSuccess(title, type, timer) {
            if (title) {
                Vue.swal.mixin({
                    position: 'top-end',
                    icon: 'success',
                    title,
                    showConfirmButton: false,
                    timer: 3000,
                });
                /* const toast = Vue.swal.mixin({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: timer ? timer : 3000,
                   width: '300px'
                 })
                 toast({
                   type: type ? type : 'success',
                   title: title,
                 }) */
            }
        },
        $swalError(errors, title) {
            if (errors) {
                let swal_html = '';
                if (Array.isArray(errors) || typeof errors === 'object') {
                    Object.keys(errors).forEach((key) => {
                        if (Array.isArray(errors[key])) {
                            errors[key].forEach((error) => {
                                swal_html += `${error}<br/>`;
                            });
                        } else {
                            swal_html += `${errors[key]}<br/>`;
                        }
                    });
                } else {
                    swal_html = errors;
                }
                if (swal_html) {
                    swal_html = `<span class="error">${swal_html}</span>`;
                    Vue.swal({
                        // type:  'errors',
                        title: title || 'Ошибка',
                        icon: 'error',
                        confirmButtonText: 'Да',
                        html: swal_html,
                    });
                }
            }
        },
        $lang(lang) {
            switch (lang) {
                case 'kk':
                    return 'казахском'
                case 'ru':
                    return 'русском'
                case 'en':
                    return 'английском'
            }
        },
        $toastSuccessSaved() {
            this.$toast.success('Успешно сохранено');
        }, $toastSuccess(text) {
            this.$toast.success(text);
        },
        $toastSuccessCreated() {
            this.$toast.success('Успешно добавлено');
        },
        $toastSuccessDeleted() {
            this.$toast.success('Успешно удален');
        },
        $toastSuccessUpdated() {
            this.$toast.success('Успешно обновлен');
        },
        $isValidUrl(userInput) {
            var res = userInput.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
            return res == null;
        },
        $swalWarning(warning, title) {
            this.$swal({
                // type:  'errors',
                title: title || 'Предупреждение!',
                text: warning,
                icon: 'warning',
                confirmButtonText: 'Да',
            });
        },
        $isNullClear(value, default_value) {
            if (!default_value) default_value = '';
            if (value === null) {
                return default_value;
            }
            return value;
        },
        $dateFormat(dateString, type_format) {
            if (!dateString) return '';
            if (!type_format) type_format = 'datetime';
            let reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
            let dateArray = reggie.exec(dateString);
            if (!dateArray) {
                reggie = /(\d{4})-(\d{2})-(\d{2})/;
                dateArray = reggie.exec(dateString);
            }
            if (dateArray) {
                if (type_format == 'date') return `${dateArray[3]}.${dateArray[2]}.${dateArray[1]}`;
                if (type_format == 'datetime') {
                    return `${dateArray[3]}.${dateArray[2]}.${dateArray[1]
                    } ${
                        dateArray[4]}:${dateArray[5]}`;
                }
                if (type_format == 'full') {
                    return `${dateArray[3]}.${dateArray[2]}.${dateArray[1]
                    } ${
                        dateArray[4]}:${dateArray[5]}:${dateArray[6]}`;
                }
                if (type_format == 'time') return `${dateArray[4]}:${dateArray[5]}`;
                if (type_format == 'fulltime') return `${dateArray[4]}:${dateArray[5]}:${dateArray[6]}`;
            } else {
                return '';
            }
        },
        $baseUrl() {
            return $('meta[name=\'base_url\']').attr('content');
        },
    },
};
</script>