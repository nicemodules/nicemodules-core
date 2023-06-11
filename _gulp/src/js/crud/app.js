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
                app: crudApp,
                editedItem: {},
                editDialog: false,
                items: [],
                fields: crud.fields,
                headers: crud.headers,
                count: 0,
                options: crud.CrudOptions,
                loading: false,
                filters: crud.filters,
                translation: crud.translation,
                locale: crud.locale,
            },
            beforeMount: function() {

            },
            methods: {
                editItem(item) {
                    this.editedItem = item || {}
                    this.editDialog = !this.editDialog
                },
                filterItems() {
                   alert('implement filter');
                },
                saveItem(item) {

                },
                deleteItem(item) {
                    //console.log('deleteItem', item)
                    let id = item.id
                    let idx = this.items.findIndex(item => item.id === id)
                    if (confirm('Are you sure you want to delete this?')) {
                        this.items.splice(idx, 1)
                    }
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
                            
                            console.log(data.count);
                        },
                        error: function error(jqXHR, exception) {
                            self.handleAjaxError(jqXHR, exception);
                        }
                    });

                   
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



