Vue.component('crud-filters', {
    props: ['filters', 'translation', 'locale'],
    template: '#crud-filters',
    data: function () {
        return {
            pickers: {},
            expandFilters: false,
            filterClass: 'default--text'
        };
    },
    methods: {
        clearFilters() {
            for (const name in this.filters) {
                this.filters[name].value = null;
            }

            this.filterClass = 'default--text';
            
            this.filterItems();
        },
        filterItems: function () {
            this.$root.getItems()
        },
        closePicker: function (ref) {
            this.pickers[ref] = false;
        },
        clearPicker: function (ref) {
            this.filters[ref].value = '';
            this.pickers[ref] = false;
        },
        changeFilter(filter) {
            this.checkFiltersActive();
        },
        checkFiltersActive() {
            for (const name in this.filters) {
                if (this.filters[name].value) {
                    this.filterClass = 'primary--text';
                    return;
                }
            }

            this.filterClass = 'default--text';
        }
    },
    mounted: function () {

        for (const name in this.filters) {

            if (this.filters[name].value) {
                this.expandFilters = true;
            }

            if (this.filters[name].type === 'date') {
                this.pickers[name] = false;
            }
        }

        this.checkFiltersActive();
    },
    watch: {},
});