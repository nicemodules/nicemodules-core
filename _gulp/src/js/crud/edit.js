Vue.component('crud-edit', {
    props: ['translation', 'fields', 'get_item', 'edit', 'locale'],
    template: '#crud-edit',
    data: function () {
        return {
            add: false,
            item: {},
            editActive: false,
        };
    },
    methods: {
        save(item) {
            
        },
        cancel() {
            this.editActive = false;
        }
    },
    mounted: function () {
        this.add = this.$root.options.allowAdd;
    },
    watch: {
        edit: {
            handler() {
                this.item = this.edit ? Object.assign({}, this.get_item()) : {};
                if(this.edit){
                    this.editActive = true
                }
            }
        },
        editActive: {
            handler() {
                if(!this.editActive){
                    this.$root.edit = false;
                }
            }
        }
    },
});