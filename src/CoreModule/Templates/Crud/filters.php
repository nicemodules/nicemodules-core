<script type="text/x-template" id='crud-filters'>

    <v-expansion-panels focusable class="nm-border-radius-0">
        <v-expansion-panel v-model="expandFilters" class="nm-bs2border-bottom nm-border-radius-0">
            <v-expansion-panel-header>
                <v-icon :class="filterClass">mdi mdi-filter</v-icon>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
                <v-form @submit="filterItems">
                    <v-container>
                        <v-row>
                            <v-col v-for="filter of filters" cols="12" md="3" @keyup.enter="filterItems()">

                                <template v-if="filter.type === 'text'">
                                    <v-text-field v-model="filter.value"
                                                  :label="filter.label"
                                                  @change="changeFilter(filter)"
                                    ></v-text-field>
                                </template>

                                <template v-if="filter.type === 'select'">
                                    <v-select v-model="filter.value" :label="filter.label"
                                              :items="filter.options"
                                              @change="changeFilter(filter)"
                                    ></v-select>
                                </template>

                                <template v-if="filter.type === 'checkbox'">
                                    <v-checkbox v-model="filter.value"
                                                :label="filter.label"
                                                @change="changeFilter(filter)"
                                    ></v-checkbox>
                                </template>

                                <template v-if="filter.type === 'date_time' || filter.type === 'date'">
                                    <v-menu
                                            v-model="pickers[filter.name]"
                                            :close-on-content-click="false"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                    v-model="filter.value"
                                                    :label="filter.label"
                                                    prepend-icon="mdi-calendar"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @change="changeFilter(filter)"
                                            ></v-text-field>
                                        </template>

                                        <v-date-picker v-model="filter.value"
                                                       range
                                                       no-title
                                                       scrollable
                                                       :locale="locale"
                                        >
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                    text
                                                    color="primary"
                                                    @click="clearPicker(filter.name)"
                                            >
                                                {{ translation.buttons.cancel }}
                                            </v-btn>
                                            <v-btn
                                                    text
                                                    color="primary"
                                                    @click="closePicker(filter.name)"
                                            >
                                                {{ translation.buttons.ok }}
                                            </v-btn>
                                        </v-date-picker>

                                    </v-menu>


                                </template>
                            </v-col>
                        </v-row>
                        
                        <v-row justify="end">
                            <v-col cols="auto">
                                <v-btn color="default" @click="clearFilters()">
                                    <v-icon left small>mdi-filter-remove</v-icon>
                                    {{ translation.buttons.clear }}
                                </v-btn>
                            </v-col>
                            <v-col cols="auto">
                                <v-btn color="primary" @click="filterItems()">
                                    <v-icon left small>mdi-magnify</v-icon>
                                    {{ translation.buttons.filter }}
                                </v-btn>
                            </v-col>
                        </v-row>


                    </v-container>

                </v-form>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-expansion-panels>


</script>


