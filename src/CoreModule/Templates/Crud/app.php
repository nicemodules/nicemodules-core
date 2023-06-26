<?php

/** @var string $crud */
$crud = json_encode($crud);
?>
<div class="nm-app">
    <div id="nm-crud">
        <v-app>
            <v-content class="container align-center px-1">

                <v-card class="mx-auto">
                    <crud-filters v-if="hasFilters"
                                  :translation="translation"
                                  :filters="filters"
                                  :locale="locale"
                    ></crud-filters>


                    <v-col cols="12">

                        <v-data-table
                                v-model="selectedItems"
                                :headers="headers"
                                :items="items"
                                :options.sync="options"
                                :server-items-length="count"
                                :loading="loading"
                                item-key="ID"
                                :auto-width="true"
                                :show-select="options.bulk"
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

                                    <v-menu offset-y v-if="selectedLanguage">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                    class="mx-2"
                                                    fab
                                                    outlined
                                                    small
                                                    color="grey"
                                                    v-bind="attrs"
                                                    v-on="on"
                                            >
                                                <span :class="'fi fi-'+ selectedLanguage.flag"></span>
                                            </v-btn>
                                        </template>

                                        <v-list>
                                            <v-list-item
                                                    v-for="(item, index) in languages"
                                                    :key="index"
                                            >
                                                <v-list-item-title @click="executeAction(item, languageAction); selectedLanguage = item;">
                                                    <span :class="'fi fi-'+ item.flag"></span> {{ item.name }}
                                                </v-list-item-title>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>

                                    <v-divider
                                            class="mx-4"
                                            inset
                                            vertical
                                    ></v-divider>

                                    <v-spacer></v-spacer>

                                    <crud-top-button-actions :actions="options.topButtonActions"
                                    ></crud-top-button-actions>

                                    <crud-edit v-if="fields"
                                               :translation="translation"
                                               :fields="fields"
                                               :action="getCalledAction"
                                               :edit="edit"
                                               :locale="locale">
                                    </crud-edit>

                                </v-toolbar>

                            </template>

                            <template v-for="header of headers" v-slot:[`item.${header.value}`]="{ item }">
                                <component :is="header.type + '-plain'" :item="item"
                                           :property="header.value"></component>
                            </template>

                        </v-data-table>

                        <template>
                            <crud-bulk-actions v-if="options.bulk"
                                               :translation="translation"
                                               :actions="options.bulkActions">
                            </crud-bulk-actions>
                        </template>


                        <v-dialog v-model="confirm" max-width="800px">
                            <v-card>
                                <v-card-title justify="center">
                                    <v-col cols="12" class="text-center">{{ calledAction.confirm }}</v-col>
                                </v-card-title>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="closeConfirm">{{
                                        translation.buttons.cancel
                                        }}
                                    </v-btn>
                                    <v-btn color="blue darken-1" text @click="callAction()">{{
                                        translation.buttons.ok }}
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-col>


                    <template>
                        <div class="text-center">
                            <v-snackbar
                                    :timeout="2000"
                                    v-model="snackbars.success.active"
                                    :multi-line="true"
                                    shaped
                                    color="success"
                                    bottom
                            >
                                {{ snackbars.success.text }}
                            </v-snackbar>

                            <v-snackbar
                                    :timeout="2000"
                                    v-model="snackbars.error.active"
                                    :multi-line="true"
                                    shaped
                                    color="error"
                                    bottom
                            >
                                {{ snackbars.error.text }}
                            </v-snackbar>
                        </div>
                    </template>

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