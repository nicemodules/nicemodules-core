<script type="text/x-template" id='crud-filters'>
    <v-card class="pa-4 elevation-0">
        <v-row>
            <v-col v-for="filter of filters" cols="12" sm="6">
                <template v-if="filter.type === 'text'">
                    <v-text-field v-model="filter.value" :label="filter.label"></v-text-field>
                </template>
                <template v-if="filter.type === 'select'">
                    <v-select v-model="filter.value" :label="filter.label" :items="filter.options"></v-select>
                </template>
                <template v-if="filter.type === 'checkbox'">
                    <v-checkbox v-model="filter.value" :label="filter.label"></v-checkbox>
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
                            ></v-text-field>
                        </template>
                        <v-date-picker 
                                v-model="filter.value" 
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
        <v-row>
            <v-btn color="primary" class="ml-auto ma-3" @click="filterItems()" >
                {{ translation.buttons.filter }}
                <v-icon small>mdi-magnify</v-icon>
            </v-btn>
        </v-row>
    </v-card>
</script>


