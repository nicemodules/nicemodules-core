"use strict";

Vue.component('crud-filters', {
  props: ['filters', 'translation', 'locale'],
  template: '#crud-filters',
  data: function data() {
    return {
      pickers: {},
      expandFilters: false,
      filterClass: 'default--text'
    };
  },
  methods: {
    clearFilters: function clearFilters() {
      for (var name in this.filters) {
        this.filters[name].value = null;
      }
      this.filterClass = 'default--text';
      this.filterItems();
    },
    filterItems: function filterItems() {
      this.$root.getItems();
    },
    closePicker: function closePicker(ref) {
      this.pickers[ref] = false;
    },
    clearPicker: function clearPicker(ref) {
      this.filters[ref].value = '';
      this.pickers[ref] = false;
    },
    changeFilter: function changeFilter(filter) {
      this.checkFiltersActive();
    },
    checkFiltersActive: function checkFiltersActive() {
      for (var name in this.filters) {
        if (this.filters[name].value) {
          this.filterClass = 'primary--text';
          return;
        }
      }
      this.filterClass = 'default--text';
    }
  },
  mounted: function mounted() {
    for (var name in this.filters) {
      if (this.filters[name].value) {
        this.expandFilters = true;
      }
      if (this.filters[name].type === 'date') {
        this.pickers[name] = false;
      }
    }
    this.checkFiltersActive();
  },
  watch: {}
});
"use strict";

Vue.component('crud-edit', {
  props: ['translation', 'fields', 'get_item', 'edit', 'locale'],
  template: '#crud-edit',
  data: function data() {
    return {
      add: false,
      item: {},
      editActive: false
    };
  },
  methods: {
    save: function save(item) {},
    cancel: function cancel() {
      this.editActive = false;
    }
  },
  mounted: function mounted() {
    this.add = this.$root.options.allowAdd;
  },
  watch: {
    edit: {
      handler: function handler() {
        this.item = this.edit ? Object.assign({}, this.get_item()) : {};
        if (this.edit) {
          this.editActive = true;
        }
      }
    },
    editActive: {
      handler: function handler() {
        if (!this.editActive) {
          this.$root.edit = false;
        }
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
        items: [],
        fields: crud.fields,
        headers: crud.headers,
        count: 0,
        options: crud.CrudOptions,
        loading: false,
        filters: crud.filters,
        translation: crud.translation,
        locale: crud.locale,
        editDialog: false,
        deleteDialog: false,
        edit: false,
        editedItem: {}
      },
      beforeMount: function beforeMount() {},
      mounted: function mounted() {},
      methods: {
        editItem: function editItem(item) {
          this.editedItem = item || {};
          this.edit = !this.edit;
        },
        getEditedItem: function getEditedItem() {
          return this.editedItem;
        },
        saveItem: function saveItem(item) {},
        deleteItem: function deleteItem(item) {
          //console.log('deleteItem', item)
          var id = item.id;
          var idx = this.items.findIndex(function (item) {
            return item.id === id;
          });
        },
        deleteConfirm: function deleteConfirm(item) {},
        closeDelete: function closeDelete() {},
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