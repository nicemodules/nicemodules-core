<script type="text/x-template" id='crud-edit'>

    <v-dialog v-model="editActive" max-width="800px">
        
        <v-card>
            <v-card-title>
                <span v-if="item.ID">{{ translation.buttons.edit }}</span>
                <span v-else>{{ translation.buttons.add }}</span>
            </v-card-title>

            <v-card-text>
                <v-row>
                    <template v-for="field of fields">
                        <template v-if="field.type === 'text'">
                            <v-col cols="12" sm="6">
                                <v-text-field v-model="item[field.name]" :label="field.label"></v-text-field>
                            </v-col>
                        </template>
                        
                        <template v-if="field.type === 'select'">
                            <v-col cols="12" sm="6">
                                <v-select v-model="item[field.name]" 
                                          :label="field.label"
                                          item-text="name"
                                          item-value="value"
                                          :items="field.options"></v-select>
                            </v-col>
                        </template>
                        
                        <template v-if="field.type === 'checkbox'">
                            <v-col cols="12" sm="6">
                                <v-checkbox v-model="item[field.name]" :label="field.label"></v-checkbox>
                            </v-col>
                        </template>

                        <template v-if="field.type === 'textarea'">
                            <v-col cols="12">
                                <v-textarea v-model="item[field.name]" :label="field.label"></v-textarea>
                            </v-col>
                        </template>
                        
                        <template v-if="field.type === 'date_time' || field.type === 'date'">
                            <v-col cols="12" sm="6">
                                <v-menu
                                        :close-on-content-click="true"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="auto"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                                v-model="item[field.name]"
                                                :label="field.label"
                                                prepend-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                        ></v-text-field>
                                    </template>

                                    <v-date-picker
                                            v-model="item[field.name]"
                                            no-title
                                            scrollable
                                            :locale="locale"
                                    >
                                        <v-spacer></v-spacer>
                                    </v-date-picker>

                                </v-menu>
                            </v-col>
                        </template>

                    </template>
                </v-row>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue" text @click="cancel()">
                    {{ translation.buttons.cancel }}
                </v-btn>

                <v-btn color="blue" text @click="save(item)">
                    {{ translation.buttons.save }}
                </v-btn>
            </v-card-actions>

        </v-card>
    </v-dialog>

</script>