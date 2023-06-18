Vue.component('crud-top-button-actions', {
    props: ['item', 'actions'],
    template: '#crud-top-button-actions',
    data: function () {
        return {
        };
    },
    methods: {
        buttonAction(action) {
            this.$root.executeAction({}, action)
        },
    },
    mounted: function () {
    },
    watch: {},
});