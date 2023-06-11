Vue.component('crud-filters', {
    props: ['filters', 'translation', 'locale'],
    template: '#crud-filters',
    data: function() {
        return {
            pickers: {},
        };
    },
    methods:{
        filterItems: function (){
            this.$root.getItems()
        },
        closePicker: function (ref){
            this.pickers[ref]  = false;
        },
        clearPicker: function (ref){
            this.filters[ref].value  = '';
            this.pickers[ref]  = false;
        }
    },
    mounted: function() {
        console.log(this.locale);
        
        for (let filter in this.filters) {
            if(filter.type === 'date'){
                this.pickers[filter.name] = false;
            }
        }
    },
    
});