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
  props: ['translation', 'fields', 'action', 'edit', 'locale'],
  template: '#crud-edit',
  data: function data() {
    return {
      item: {},
      editActive: false
    };
  },
  methods: {
    save: function save(item) {
      this.$root.calledAction.subject = item;
      this.$root.callAction();
      this.editActive = false;
    },
    cancel: function cancel() {
      this.editActive = false;
    }
  },
  watch: {
    edit: {
      handler: function handler() {
        this.item = this.edit ? Object.assign({}, this.action().subject) : {};
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

Vue.component('crud-item-actions', {
  props: ['item', 'actions'],
  template: '#crud-item-actions',
  data: function data() {
    return {};
  },
  methods: {
    itemAction: function itemAction(item, action) {
      this.$root.executeAction(item, action);
    }
  },
  mounted: function mounted() {},
  watch: {}
});
"use strict";

Vue.component('crud-top-button-actions', {
  props: ['item', 'actions'],
  template: '#crud-top-button-actions',
  data: function data() {
    return {};
  },
  methods: {
    buttonAction: function buttonAction(action) {
      this.$root.executeAction({}, action);
    }
  },
  mounted: function mounted() {},
  watch: {}
});
"use strict";

Vue.component('crud-bulk-actions', {
  props: ['translation', 'actions'],
  template: '#crud-bulk-actions',
  data: function data() {
    return {};
  },
  methods: {
    buttonAction: function buttonAction(action) {
      if (!this.$root.selectedItems.length) {
        this.$root.snackbarError([this.translation.messages.unselected]);
        return;
      }
      this.$root.executeAction(this.$root.selectedItems, action);
    }
  },
  mounted: function mounted() {},
  watch: {}
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
        hasFilters: false,
        translation: crud.translation,
        locale: crud.locale,
        deleteDialog: false,
        edit: false,
        confirm: false,
        calledAction: {},
        selectedItems: [],
        snackbars: {
          success: {
            text: '',
            active: false
          },
          error: {
            text: '',
            active: false
          }
        },
        status: {
          error: 0,
          success: 1
        }
      },
      beforeMount: function beforeMount() {},
      mounted: function mounted() {
        this.hasFilters = Object.keys(this.filters).length;
      },
      methods: {
        executeAction: function executeAction(subject, action) {
          this.calledAction = action;
          this.calledAction.subject = subject;
          if (this.calledAction.confirm) {
            this.confirm = true;
            return;
          }

          // handle predefined actions or call default behaviour 
          switch (this.calledAction.name) {
            case 'add':
            case 'edit':
              this.edit = !this.edit;
              break;
            default:
              this.callAction();
              break;
          }
        },
        callAction: function callAction() {
          var self = this;
          self.loading = true;
          self.confirm = false;
          jQuery.ajax({
            url: self.calledAction.uri,
            data: {
              subject: JSON.stringify(self.calledAction.subject)
            },
            type: 'POST',
            dataType: 'json',
            success: function success(data) {
              crudApp.log('RESPOSE:');
              crudApp.log(data);
              if (data.status === self.status.success) {
                self.snackbarSuccess(data.messages);
              }
              if (data.status === self.status.error) {
                self.snackbarError(data.messages);
              }
              self.getItems();
            },
            error: function error(jqXHR, exception) {
              self.handleAjaxError(jqXHR, exception);
            }
          });
          self.calledAction = {};
        },
        getCalledAction: function getCalledAction() {
          return this.calledAction;
        },
        closeConfirm: function closeConfirm() {
          this.confirm = false;
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
            },
            error: function error(jqXHR, exception) {
              self.handleAjaxError(jqXHR, exception);
            }
          });
        },
        snackbarSuccess: function snackbarSuccess(messages) {
          this.snackbars.success.active = true;
          this.snackbars.success.text = messages.join('<br>');
          crudApp.log('SNACKBAR:: ');
          crudApp.log(this.snackbars.success);
        },
        snackbarError: function snackbarError(messages) {
          this.snackbars.error.active = true;
          this.snackbars.error.text = messages.join('<br>');
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