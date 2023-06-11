"use strict";

Vue.component('crud-filters', {
  props: ['filters', 'translation', 'locale'],
  template: '#crud-filters',
  data: function data() {
    return {
      pickers: {}
    };
  },
  methods: {
    filterItems: function filterItems() {
      this.$root.getItems();
    },
    closePicker: function closePicker(ref) {
      this.pickers[ref] = false;
    },
    clearPicker: function clearPicker(ref) {
      this.filters[ref].value = '';
      this.pickers[ref] = false;
    }
  },
  mounted: function mounted() {
    console.log(this.locale);
    for (var filter in this.filters) {
      if (filter.type === 'date') {
        this.pickers[filter.name] = false;
      }
    }
  }
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
        app: crudApp,
        editedItem: {},
        editDialog: false,
        items: [],
        fields: crud.fields,
        headers: crud.headers,
        count: 0,
        options: crud.CrudOptions,
        loading: false,
        filters: crud.filters,
        translation: crud.translation,
        locale: crud.locale
      },
      beforeMount: function beforeMount() {},
      methods: {
        editItem: function editItem(item) {
          this.editedItem = item || {};
          this.editDialog = !this.editDialog;
        },
        filterItems: function filterItems() {
          alert('implement filter');
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
        getItems: function getItems() {
          var self = this;
          this.loading = true;
          crudApp.log('CRUD options: ');
          crudApp.log(self.options);
          crudApp.log('Crud filters: ');
          crudApp.log(crud.filters);
          crudApp.log('CRUD uris: ');
          crudApp.log(crud.uris);
          jQuery.ajax({
            url: crud.uris['getItems'],
            data: {
              options: JSON.stringify(self.options),
              filters: JSON.stringify(self.filters)
            },
            type: 'POST',
            dataType: 'json',
            success: function success(data) {
              self.loading = false;
              self.items = data.items;
              self.count = data.count;
              console.log(data.count);
            },
            error: function error(jqXHR, exception) {
              self.handleAjaxError(jqXHR, exception);
            }
          });
        },
        handleAjaxError: function handleAjaxError(jqXHR, exception) {
          var msg = '';
          if (jqXHR.status === 0) {
            msg = 'Not connected.\n Verify Network.';
          } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
          } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500]';
          } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed';
          } else if (exception === 'timeout') {
            msg = 'Time out error.';
          } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
          }
          msg = msg + ', Response text: ' + jqXHR.responseText;
          crudApp.log(msg);
        }
      },
      watch: {
        options: {
          handler: function handler() {
            this.getItems();
          },
          deep: true
        },
        items: {
          handler: function handler(item, newItem) {},
          deep: true
        }
      }
    });
  }
};