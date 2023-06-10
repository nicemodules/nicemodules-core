"use strict";

Vue.component('crud-filters', {
  props: ['filters'],
  template: '#crud-filters'
});
"use strict";

var NiceModulesCrudApp = {
  debug: true,
  run: function run(params) {
    this.vuetify(params.crud);
  },
  log: function log(something) {
    if (this.debug) {
      console.log(something);
    }
  },
  vuetify: function vuetify(crud) {
    var crudApp = this;
    crudApp.vue = new Vue({
      el: '#nm-crud',
      vuetify: new Vuetify({
        theme: {
          dark: false
        },
        lang: {
          locales: {
            lc: crud.translation
          },
          current: 'lc'
        }
      }),
      data: {
        editedItem: {},
        editDialog: false,
        items: [],
        fields: crud.fields,
        headers: crud.headers,
        count: 0,
        options: crud.CrudOptions,
        loading: false
        //filters: crud.filters,
      },

      beforeMount: function beforeMount() {},
      methods: {
        editItem: function editItem(item) {
          this.editedItem = item || {};
          this.editDialog = !this.editDialog;
        },
        filterItems: function filterItems() {
          this.items = [];
        },
        saveItem: function saveItem(item) {},
        deleteItem: function deleteItem(item) {
          //console.log('deleteItem', item)
          var id = item.id;
          var idx = this.items.findIndex(function (item) {
            return item.id === id;
          });
          if (confirm('Are you sure you want to delete this?')) {
            this.items.splice(idx, 1);
          }
        },
        getData: function getData() {
          var self = this;
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
          handler: function handler() {
            this.getData();
          },
          deep: true
        },
        items: {
          handler: function handler(item, newItem) {
            this.count = this.items.length;
          },
          deep: true
        }
      }
    });
  }
};