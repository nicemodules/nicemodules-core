"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _default = {
  badge: 'Odznaka',
  close: 'Zamknij',
  dataIterator: {
    noResultsText: 'Nie znaleziono danych odpowiadających wyszukiwaniu',
    loadingText: 'Wczytywanie danych...'
  },
  dataTable: {
    itemsPerPageText: 'Wierszy na stronie:',
    ariaLabel: {
      sortDescending: 'Sortowanie malejąco. Kliknij aby zmienić.',
      sortAscending: 'Sortowanie rosnąco. Kliknij aby zmienić.',
      sortNone: 'Bez sortowania. Kliknij aby posortować rosnąco.',
      activateNone: 'Kliknij aby usunąć sortowanie.',
      activateDescending: 'Kliknij aby posortować malejąco.',
      activateAscending: 'Kliknij aby posortować rosnąco.'
    },
    sortBy: 'Sortuj według'
  },
  dataFooter: {
    itemsPerPageText: 'Pozycji na stronie:',
    itemsPerPageAll: 'Wszystkie',
    nextPage: 'Następna strona',
    prevPage: 'Poprzednia strona',
    firstPage: 'Pierwsza strona',
    lastPage: 'Ostatnia strona',
    pageText: '{0}-{1} z {2}'
  },
  datePicker: {
    itemsSelected: '{0} dat(y)',
    nextMonthAriaLabel: 'Następny miesiąc',
    nextYearAriaLabel: 'Następny rok',
    prevMonthAriaLabel: 'Poprzedni miesiąc',
    prevYearAriaLabel: 'Poprzedni rok'
  },
  noDataText: 'Brak danych',
  carousel: {
    prev: 'Poprzedni obraz',
    next: 'Następny obraz',
    ariaLabel: {
      delimiter: 'Carousel slide {0} of {1}'
    }
  },
  calendar: {
    moreEvents: '{0} więcej'
  },
  fileInput: {
    counter: 'Liczba plików: {0}',
    counterSize: 'Liczba plików: {0} (łącznie {1})'
  },
  timePicker: {
    am: 'AM',
    pm: 'PM'
  },
  pagination: {
    ariaLabel: {
      wrapper: 'Nawigacja paginacyjna',
      next: 'Następna strona',
      previous: 'Poprzednia strona',
      page: 'Idź do strony {0}',
      currentPage: 'Bieżąca strona, strona {0}'
    }
  },
  rating: {
    ariaLabel: {
      icon: 'Rating {0} of {1}'
    }
  }
};
exports["default"] = _default;
"use strict";

Vue.component('crud-filters', {
  props: ['filters'],
  template: '#crud-filters'
});
"use strict";

var _pl = _interopRequireDefault(require("locale/pl"));
function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }
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
          locales: _pl["default"],
          current: 'pl'
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