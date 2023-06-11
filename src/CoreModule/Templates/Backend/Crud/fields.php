<script type="text/x-template" id='crud-fields'>
    
    <v-row>
        <v-col v-for="(name, field) in fields" :name="name" cols="12" sm="6">
            <template v-if="field.type === 'text'">
                <v-text-field v-model="item[name]" :label="field.label"></v-text-field>
            </template>
            <template v-if="field.type === 'select'">
                <v-select v-model="item[name]" :label="field.label" :items="field.options"></v-select>
            </template>
            <template v-if="field.type === 'checkbox'">
                <v-checkbox v-model="item[name]" :label="field.label"></v-checkbox>
            </template>
        </v-col>
    </v-row>
    

    <v-btn color="primary" class="ml-auto ma-3" v-on="on">
        Filtruj
        <v-icon small>mdi-magnify</v-icon>
    </v-btn>
    
</script>