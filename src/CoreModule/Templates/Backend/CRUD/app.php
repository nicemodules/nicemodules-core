<div id="app">
    <v-app>
        <v-content class="container align-center px-1">
            <h2 class="font-weight-light mb-2">
                CRUD NAME
            </h2>
            <v-card>
                <v-data-table
                        :headers="headers"
                        :items="items"
                        mobile-breakpoint="800"
                        class="elevation-0">
                    <template v-slot:item.actions="{ item }">
                        <div class="text-truncate">
                            <v-icon
                                    small
                                    class="mr-2"
                                    @click="showEditDialog(item)"
                                    color="primary"
                            >
                                mdi-pencil
                            </v-icon>
                            <v-icon
                                    small
                                    @click="deleteItem(item)"
                                    color="pink"
                            >
                                mdi-delete
                            </v-icon>
                        </div>
                    </template>
                    <template v-slot:item.details="{ item }">
                        <div class="text-truncate" style="width: 180px">
                            {{item.Details}}
                        </div>
                    </template>
                    <template v-slot:item.url="{ item }">
                        <div class="text-truncate" style="width: 180px">
                            <a :href="item.URL" target="_new">{{item.URL}}</a>
                        </div>
                    </template>
                </v-data-table>
                <!-- this dialog is used for both create and update -->
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on }">
                        <div class="d-flex">
                            <v-btn color="primary" dark class="ml-auto ma-3" v-on="on">
                                New
                                <v-icon small>mdi-plus-circle-outline</v-icon>
                            </v-btn>
                        </div>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span v-if="editedItem.id">Edit {{editedItem.id}}</span>
                            <span v-else>Create</span>
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <v-text-field v-model="editedItem.Name" label="Name"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="8">
                                    <v-text-field v-model="editedItem.Details" label="Details"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-text-field v-model="editedItem.URL" label="URL"></v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="showEditDialog()">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="saveItem(editedItem)">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-card>
        </v-content>
    </v-app>
</div>
    



<script>
    // get you own airtable token at https://airtable.com!
    new Vue({
        el: '#app',
        vuetify: new Vuetify({
            theme: {
                light: true,
                themes: {
                    light: {
                        primary: 'red',
                        secondary: '#b0bec5',
                        accent: '#8c9eff',
                        error: '#b71c1c',
                    },
                },
            }
        }),
        data () {
            return {
                headers: [
                    { text: 'Id', value: 'id' },
                    { text: 'Name', value: 'Name' },
                    { text: 'Details', value: 'details', sortable: false, width:"100" },
                    { text: 'URL', value: 'url', name:'url', width:"180" },
                    { text: 'Action', value: 'actions', sortable: false },
                ],
                items: [],
                dialog: false,
                editedItem: {}
            }
        },
        mounted() {
            this.loadItems()
        },
        methods: {
            showEditDialog(item) {
                this.editedItem = item||{}
                this.dialog = !this.dialog
            },
            loadItems() {
                this.items = []
            },
            saveItem(item) {
               
            },
            deleteItem(item) {
                //console.log('deleteItem', item)
                let id = item.id
                let idx = this.items.findIndex(item => item.id===id)
                if (confirm('Are you sure you want to delete this?')) {
                    /* not really deleting in API for demo */
                    /*
                    axios.delete(`https://api.airtable.com/v0/${airTableApp}/${airTableName}/${id}`,
                        { headers: { 
                            Authorization: "Bearer " + apiToken,
                            "Content-Type": "application/json"
                        }
                    }).then((response) => {
                        this.items.splice(idx, 1)
                    })*/
                    this.items.splice(idx, 1)
                }
            },
        }
    });


</script>
