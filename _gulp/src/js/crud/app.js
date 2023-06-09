const NiceModulesCrudApp = {
    debug: true,
    run: function (params) {
        this.vuetify(params.crud);
    },
    log(something) {
        if (this.debug) {
            console.log(something);
        }
    },
    vuetify: function (crud) {
        const crudApp = this;

        crudApp.vue = new Vue({
            el: '#nm-crud',
            vuetify: new Vuetify({
                theme: {
                    dark: false
                },
                lang: {
                    locales: {lc: crud.translation},
                    current: 'lc',
                },
            }),
            data: {
                items: [],
                fields: crud.fields,
                headers: crud.headers,
                count: 0,
                options: crud.CrudOptions,
                loading: false,
                filters: crud.filters,
                hasFilters: false,
                translation: crud.translation,
                locale: crud.locale,
                deleteDialog: false,
                edit: false,
                confirm: false,
                calledAction: {},
                selectedItems: [],
                languages: crud.languages,
                selectedLanguage: crud.selectedLanguage,
                languageAction: crud.languageAction,
                snackbars: {
                    success: {
                        text: '',
                        active: false,
                    },
                    error: {
                        text: '',
                        active: false,
                    },
                },
                status: {
                    error: 0,
                    success: 1,
                }
            },
            beforeMount() {
                
            },
            mounted() {
                this.hasFilters = Object.keys(this.filters).length;
                
                console.log(this.languages);
            },
            methods: {
                executeAction(subject, action) {
                    this.calledAction = action;
                    this.calledAction.subject = subject;

                    if (this.calledAction.confirm) {
                        this.confirm = true;
                        return;
                    }

                    // handle predefined actions or call default behaviour 
                    switch (this.calledAction.name) {
                        case 'add':
                        case 'edit':
                            this.edit = !this.edit;
                            break;
                        default:
                            this.callAction();
                            break;
                    }
                },
                callAction() {
                    const self = this;
                    self.loading = true;
                    self.confirm = false;

                    jQuery.ajax({
                        url: self.calledAction.uri,
                        data: {
                            subject: JSON.stringify(self.calledAction.subject),
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function (data) {
                            crudApp.log('RESPONSE:');
                            crudApp.log(data);

                            if (data.status === self.status.success) {
                                self.snackbarSuccess(data.messages);
                            }

                            if (data.status === self.status.error) {
                                self.snackbarError(data.messages);
                            }

                            self.getItems();
                        },
                        error: function error(jqXHR, exception) {
                            self.handleAjaxError(jqXHR, exception);
                        }
                    });

                    self.calledAction = {};
                },
                getCalledAction() {
                    return this.calledAction;
                },
                closeConfirm() {
                    this.confirm = false;
                },
                getItems() {
                    const self = this;
                    this.loading = true;

                    crudApp.log('CRUD options: ');
                    crudApp.log(self.options);
                    crudApp.log('Crud filters: ');
                    crudApp.log(crud.filters);
                    crudApp.log('CRUD uris: ');
                    crudApp.log(crud.uris);

                    jQuery.ajax({
                        url: crud.uris['getItems'],
                        data: {
                            options: JSON.stringify(self.options),
                            filters: JSON.stringify(self.filters)
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function (data) {
                            self.loading = false;
                            self.items = data.items;
                            self.count = data.count;
                        },
                        error: function error(jqXHR, exception) {
                            self.handleAjaxError(jqXHR, exception);
                        }
                    });
                },
                snackbarSuccess(messages) {
                    this.snackbars.success.active = true;
                    this.snackbars.success.text = messages.join('<br>');

                    crudApp.log('SNACKBAR:: ');
                    crudApp.log(this.snackbars.success);
                },
                snackbarError(messages) {
                    this.snackbars.error.active = true;
                    this.snackbars.error.text = messages.join('<br>');
                },
                handleAjaxError: function (jqXHR, exception) {
                    var msg = '';

                    if (jqXHR.status === 0) {
                        msg = 'Not connected.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500]';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    }

                    msg = msg + ', Response text: ' + jqXHR.responseText;
                    crudApp.log(msg);
                },
            },
            watch: {
                options: {
                    handler() {
                        this.getItems()
                    },
                    deep: true,
                },
                items: {
                    handler: function handler(item, newItem) {
                        
                    },
                    deep: true
                },
            },
        })
    }

}



