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
                    locales: { lc: crud.translation },
                    current: 'lc',
                },
            }),
            data: {
                editedItem: {},
                editDialog: false,
                items: [],
                fields: crud.fields,
                headers: crud.headers,
                count: 0,
                options: crud.CrudOptions,
                loading: false,
                //filters: crud.filters,
            },
            beforeMount: function beforeMount() {

            },
            methods: {
                editItem(item) {
                    this.editedItem = item || {}
                    this.editDialog = !this.editDialog
                },
                filterItems() {
                    this.items = []
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
                getData() {
                    const self = this;
                    this.loading = true;

                    crudApp.log('SYNC');

                    crudApp.log(this.options);
                    // call backend
                    setTimeout(function () {
                        self.loading = false;
                        self.count = self.items.length;
                    }, 2000);


                }
            },
            watch: {
                options: {
                    handler() {
                        this.getData()
                    },
                    deep: true,
                },
                items: {
                    handler: function handler(item, newItem) {
                        this.count = this.items.length;
                    },
                    deep: true
                },
            },
        })
    }

}



