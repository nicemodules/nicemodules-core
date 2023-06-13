<?php
/** @var string $crud */

$crud = json_encode($crud);
?>
<div class="nm-app">
    <div id="nm-crud">
        <v-app>
            <v-content class="container align-center px-1">
             
                <v-card>
                    <crud-filters v-if="filters"
                                  :translation="translation"
                                  :filters="filters"
                                  :locale="locale"
                    ></crud-filters>
                    
                    <v-row>
                        <v-col cols="12">
                            
                            <v-data-table
                                    :headers="headers"
                                    :items="items"
                                    :options.sync="options"
                                    :server-items-length="count"
                                    :loading="loading"
                                    :auto-width="true"
                                    :footer-props="{
                              'items-per-page-options': [10, 20, 50, 100] 
                            }"
                                    class="elevation-0"
                                    loading-text=""

                            >

                                <template v-slot:top>


                                    <v-toolbar flat>
                                        <v-toolbar-title>
                                            {{ options.title }}
                                        </v-toolbar-title>

                                        <v-divider
                                                class="mx-4"
                                                inset
                                                vertical
                                        ></v-divider>

                                        <v-spacer></v-spacer>


                                        <crud-edit v-if="fields"
                                                   :translation="translation"
                                                   :fields="fields"
                                                   :get_item="getEditedItem"
                                                   :edit="edit"
                                                   :locale="locale">
                                        </crud-edit>


                                    </v-toolbar>

                                </template>

                                <template v-slot:item.actions="{ item }">
                                    <div class="text-truncate">
                                        <v-icon
                                                small
                                                class="mr-2"
                                                @click="editItem(item)"
                                                color="primary"
                                        >
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon v-if="options.allowDelete"
                                                small
                                                @click="deleteItem(item)"
                                                color="red"
                                        >
                                            mdi-delete
                                        </v-icon>
                                    </div>
                                </template>

                            </v-data-table>

                            <v-dialog v-model="deleteDialog" max-width="800px">
                                <v-card>
                                    <v-card-title class="text-h5">{{ translation.messages.confirmDelete }}
                                    </v-card-title>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="blue darken-1" text @click="closeDelete">{{
                                            translation.buttons.cancel
                                            }}
                                        </v-btn>
                                        <v-btn color="blue darken-1" text @click="deleteConfirm">{{
                                            translation.buttons.ok }}
                                        </v-btn>
                                        <v-spacer></v-spacer>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-col>


                    </v-row>
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