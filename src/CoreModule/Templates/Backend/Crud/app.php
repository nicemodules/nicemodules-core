<?php
/** @var string $crud */

echo '<pre>'.print_r(json_encode($crud, JSON_PRETTY_PRINT), 1).'</pre>';
$crud = json_encode($crud);
?>
<div class="nm-app">
    <div id="nm-crud">
        <v-app>
            <v-content class="container align-center px-1">

                <h2 class="font-weight-light mb-2">
                    {{ options.title }}
                </h2>

                <v-card>
                    <v-data-table
                            :headers="headers"
                            :items="items"
                            :options.sync="options"
                            :server-items-length="count"
                            :loading="loading"
                            :footer-props="{
                              'items-per-page-options': [10, 20, 50, 100] // opcje liczby wierszy na stronę
                            }"
                            class="elevation-1"
                            loading-text=""
                            
                    >

<!--                        <template v-slot:top>-->
<!--                            <crud-filters v-bind="filters"></crud-filters>-->
<!--                        </template>-->


<!--                        <template v-slot:item.actions="{ item }">-->
<!---->
<!--                            <div class="text-truncate">-->
<!--                                <v-icon-->
<!--                                        small-->
<!--                                        class="mr-2"-->
<!--                                        @click="showEditDialog(item)"-->
<!--                                        color="primary"-->
<!--                                >-->
<!--                                    mdi-pencil-->
<!--                                </v-icon>-->
<!---->
<!--                                <v-icon-->
<!--                                        small-->
<!--                                        @click="deleteItem(item)"-->
<!--                                        color="pink"-->
<!--                                >-->
<!--                                    mdi-delete-->
<!--                                </v-icon>-->
<!--                            </div>-->
<!---->
<!--                        </template>-->


                       
                            
                        <template v-slot:item.details="{ item }">
                            <div class="text-truncate" >
                                {{item.Details}}
                            </div>
                        </template>

                        <template v-slot:item.url="{ item }">
                            <div class="text-truncate">
                                <a :href="item.URL" target="_new">{{item.URL}}</a>
                            </div>
                        </template>

                    </v-data-table>
                    
<!--                    <div class="text-center pt-2">-->
<!---->
<!--                        <v-pagination-->
<!--                                v-model="CrudOptions.page"-->
<!--                                :length="CrudOptions.perPage"-->
<!--                        ></v-pagination>-->
<!---->
<!--                        <v-text-field-->
<!--                                :value="itemsPerPage"-->
<!--                                label="Items per page"-->
<!--                                type="number"-->
<!--                                min="-1"-->
<!--                                max="15"-->
<!--                                @input="itemsPerPage = parseInt($event, 10)"-->
<!--                        ></v-text-field>-->
<!---->
<!--                    </div>-->

                    <!-- this dialog is used for both create and update -->

<!--                    <v-dialog v-model="dialog" max-width="500px">-->
<!---->
<!--                        <template v-slot:activator="{ on }">-->
<!--                            <div class="d-flex">-->
<!--                                <v-btn color="primary" class="ml-auto ma-3" v-on="on">-->
<!--                                    Dodaj-->
<!--                                    <v-icon small>mdi-plus-circle-outline</v-icon>-->
<!--                                </v-btn>-->
<!--                            </div>-->
<!--                        </template>-->
<!---->
<!--                        <v-card>-->
<!--                            <v-card-title>-->
<!--                                <span v-if="editedItem.id">Edit {{editedItem.id}}</span>-->
<!--                                <span v-else>Create</span>-->
<!--                            </v-card-title>-->
<!--                            <v-card-text>-->
<!--                                <v-row>-->
<!--                                    <v-col cols="12" sm="4">-->
<!--                                        <v-text-field v-model="editedItem.Name" label="Name"></v-text-field>-->
<!--                                    </v-col>-->
<!--                                    <v-col cols="12" sm="8">-->
<!--                                        <v-text-field v-model="editedItem.Details" label="Details"></v-text-field>-->
<!--                                    </v-col>-->
<!--                                    <v-col cols="12" sm="12">-->
<!--                                        <v-text-field v-model="editedItem.URL" label="URL"></v-text-field>-->
<!--                                    </v-col>-->
<!--                                </v-row>-->
<!--                            </v-card-text>-->
<!---->
<!--                            <v-card-actions>-->
<!--                                <v-spacer></v-spacer>-->
<!--                                <v-btn color="blue " text @click="showEditDialog()">Cancel</v-btn>-->
<!--                                <v-btn color="blue" text @click="saveItem(editedItem)">Save</v-btn>-->
<!--                            </v-card-actions>-->
<!--                        </v-card>-->
<!---->
<!--                    </v-dialog>-->

                </v-card>
            </v-content>
        </v-app>
    </div>
</div>

<script>
    
    
    NiceModulesCrudApp.run({
        crud: <?php echo $crud ?>,
    });
</script>