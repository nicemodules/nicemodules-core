Vue.component('crud-bulk-actions', { 
    props: ['translation', 'actions'],
    template: '#crud-bulk-actions',
    data: function () {
        return {};
    },
    methods: {
        buttonAction(action) {
            if(!this.$root.selectedItems.length){
                this.$root.snackbarError([this.translation.messages.unselected]);
                return;
            }
            
            this.$root.executeAction(this.$root.selectedItems, action);
        },
    },
    mounted: function () {
    },
    watch: {},
});