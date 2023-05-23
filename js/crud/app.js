const NiceModulesCrudApp = {
    run: function (params) {
        this.vuetify(params.crud);
    },
    vuetify: function (crud) {
        const crudApp = this;

        crudApp.vue = new Vue({
            el: '#nm-crud',
            vuetify: new Vuetify({
                theme: {
                    dark: false
                }
            }),
            data: {
                editedItem: {},
                editDialog: false,
                title: crud.title,
                items: crud.items,
                headers: crud.headers,
                filters: crud.filters,
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
            },
            // watch: {
            //     // items: {
            //     //     handler: this.handleItemChange,
            //     //     deep: true
            //     // }
            // },
        })
    }
    
}



