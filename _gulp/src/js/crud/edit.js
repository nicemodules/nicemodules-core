Vue.component('crud-edit', {
    props: ['translation', 'fields', 'action', 'edit', 'locale'],
    template: '#crud-edit',
    data: function () {
        return {
            item: {},
            editActive: false,
        };
    },
    methods: {
        save(item) {
            this.$root.calledAction.subject = item;
            this.$root.callAction()
            this.editActive = false;
        },
        cancel() {
            this.editActive = false;
        }
    },
    watch: {
        edit: {
            handler() {
                this.item = this.edit ? Object.assign({}, this.action().subject) : {};
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