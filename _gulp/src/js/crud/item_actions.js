Vue.component('crud-item-actions', {
    props: ['item', 'actions'],
    template: '#crud-item-actions',
    data: function () {
        return {
        };
    },
    methods: {
        itemAction(item, action) {
            this.$root.executeAction(item, action);
        },
    },
    mounted: function () {
    },
    watch: {},
});